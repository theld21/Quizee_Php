<!-- MODAL -->
<style>
    #upload-img-btn{
        position: absolute;
        background: rgb(255, 255, 255);
        border: 1px solid grey;
        box-shadow: 0px 0px 8px #000000;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        padding: 10px;
        right: 0;
    }
    #upload-img-btn:hover{
        cursor: pointer;
        box-shadow: 0px 0px 15px #000000;
    }
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div id="modalForm">
                    <div class="form-group text-center">
                        <label for="recipient-name" class="col-form-label"></label>
                        <input type="text" class="form-control" id="recipient-name" name="name">
                    </div>
                </div>
                <div class="preview my-3" style="position: relative">
                    <label class="text-center" id="upload-img-btn" for="file"><i class="fas fa-pencil-alt"></i></label>
                    <img src="" for="file" id="img-subject-preview" width="100%" alt="">
                    <input type="file" id="file" name="file" hidden>
                </div>
                    <div class="text-center">
                        <button class="text-right btn btn-primary" id="submit-btn">Đồng ý</button>
                    </div>
            </div>
        </div>
    </div>
</div>



@section('modal-script')
<script>
    var targetId

    $(document).ready(function (e) {
        $('#file').change(function () {
            var file_data = $('#file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: 'http://localhost/PHP2/assm/api/subject/change-image/'+targetId,
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                    $("#img-subject-preview").attr('src', "{{BASE_URL}}/public/img/subject/"+JSON.parse(response).name)
                    reloadList()
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });
    });

    function editSubject(id, btn, img) {
        targetId = id
        url = "{{BASE_URL}}api/subject/delete/" + id

        $("#img-subject-preview").attr('src', "{{BASE_URL}}/public/img/subject/"+img)
        $("#exampleModalLabel").text("Sửa môn học")
        $("#modalForm label").text("Tên môn học:")
        $("#recipient-name").val(btn.parentNode.children[0].innerText)
        $("#modalForm input").removeAttr("hidden");
        $(".modal-body .preview").show();
        $("#modalForm input").show();
        $("#file").val('').removeAttr('disabled');

        $("#submit-btn").prop("onclick", null).off("click").click(()=>{
            if ($("#recipient-name").val()=='') {
                showAlert('Không được để trống', 'fail')
            }
            else{
                $.post(
                    "{{BASE_URL}}api/subject/edit/"+id,
                    JSON.stringify({name : $("#recipient-name").val()}),
                    function(data){
                        console.log(data)
                        if (data.status=='ok') {
                            $('#exampleModal').modal('hide')
                            reloadList()
                            showAlert('Cập nhật thành công')
                        }
                        else showAlert('Lỗi xử lý', 'fail')
                    }
                )
            }
            
        })
    }

    function removeSubject(id, btn) {
        $("#exampleModalLabel").text("Xóa môn học")
        $("#modalForm label").html("Bạn có muốn xóa: <strong>" + btn.parentNode.children[0].innerText + "</trong> ?")
        $("#modalForm input").hide();
        $(".modal-body .preview").hide();

        let url = "{{BASE_URL}}api/subject/delete/" + id
        $("#submit-btn").prop("onclick", null).off("click").click(()=>{
            $.get(url, (data)=>{
                console.log(data)
                if (data.status=='ok') {
                    $('#exampleModal').modal('hide')
                    reloadList()
                    showAlert('Đã xóa')
                }
                else showAlert('Lỗi xử lý', 'fail')
            })
        })
    }

    function createSubject() {
        $("#exampleModalLabel").text("Thêm môn học mới")
        $("#modalForm label").text("Tên môn học:")
        $("#recipient-name").val("")
        $("#modalForm input").show();
        $(".modal-body .preview").hide();
        $("#file").attr('disabled','');

        $("#submit-btn").prop("onclick", null).off("click").click(()=>{
            if ($("#recipient-name").val()=='') {
                showAlert('Không được để trống', 'fail')
            }
            else{
                $.post(
                    "{{BASE_URL}}api/subject/add/",
                    JSON.stringify({name : $("#recipient-name").val()}),
                    function(data){
                        console.log(data);
                        $('#exampleModal').modal('hide')
                        if (data.status=='ok'){
                            showAlert('Cập nhật thành công')
                            reloadList()
                        }
                        else showAlert('Lỗi xử lý', 'fail')
                    }
                )
            }
        })
    }
</script>
@endsection