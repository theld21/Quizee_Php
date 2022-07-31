@extends('layouts.main')
@section('main-content')

<div class="container-fluid px-5">
<div class="container form-quiz">
    <form action="" method="post">
        <div class="safe-area">
            <h4 class="mx-2"><?= $subjectName . ' - (' . (isset($quizName) ? $quizName  : "Thêm quiz mới") . ')' ?></h4>
            <!-- Info -->
            <div class="info">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Tên Quiz</label>
                        <input type="text" class="form-control" name="name" id="quiz-name" placeholder="Nhập tên Quiz" value="@if($action=='add'){{'Quiz '.$count+1}}@endif">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4 col-lg-3 col-lg-3">
                        <label for="name">Thời gian làm bài (phút)</label>
                        <input type="nubmer" class="form-control" id="quiz-duration" name="duration" placeholder="Nhập thời gian">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Kể từ ngày</label>
                        <input type="date" class="form-control" id="quiz-start" name="startTime" placeholder="Chọn thời gian bắt đầu">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="duration">Đến ngày</label>
                        <input type="date" class="form-control" id="quiz-end" name="endTime" placeholder="Chọn thời gian kết thúc">
                    </div>
                </div>
                <label class="switch">
                    <input type="checkbox" id="switchStatus" name="status"  onclick="changeSwitchStatus()">
                    <span class="slider round"></span>
                </label>
                <span id="switchStatusLabel"></span>
            </div>

            <!-- Questions -->
            <div class="questions"></div>

            <!-- Submit -->
            <button type="button" name="submit" id="submitBtn" >Lưu</button>

            <!-- addMore -->
            <div class="area-plus">
                <div data-toggle="modal" data-target="#exampleModal" class="plus" onclick="addMore()">
                    <i class="fas fa-plus subject"></i>
                </div>
            </div>

        </div>
    </form>
</div>
</div>

@endsection

@section('main-script')
<script>

    $("#submitBtn").click(()=>{
        check = true
        for (const e of $("input, textarea"))
            if (e.value=='') check = false

        if (!check) {
            showAlert('Không được để trống', 'fail')
        }
        else{
            $.post("{{BASE_URL}}api/quizs/@if($action == 'add'){{'add/'.$sbjid}}@else{{'edit/'.$qzid}}@endif",
                $('form').serialize(),
                function (data,s) {
                    console.log(data);
                    if (data.status=='ok') {
                        showAlert('Cập nhật thành công')
                    }
                    else showAlert('Lỗi xử lý', 'fail')
            })
        }
    })
    
    prom = () => {  
        return new Promise((resolve) => {
            resolve()
        })
    }
    
    @if($action == 'edit')
    prom().then(() => {
        $.get("{{BASE_URL}}api/quizs/get-list-question-edit/{{$qzid}}}", function(data) {
            console.log(data)
            for (x of data)
                addMore(x)
        });
    })
    @endif

    function changeSwitchStatus() {
        $("#switchStatusLabel").text(document.querySelector("#switchStatus").checked ? "Hiện quiz" : "Ẩn quiz")
    }

    @if($action == 'edit')
        prom().then(() => {
            $.get("{{BASE_URL}}api/quizs/get-quiz-details/{{$qzid}}}", function(data) {
                console.log(data)
                $("#quiz-name").val(data[0].name)
                $("#quiz-duration").val(data[0].duration_minutes)
                $("#quiz-start").val(data[0].start_time)
                $("#quiz-end").val(data[0].end_time)
                if (data[0].status==1){
                    $("#switchStatus").prop('checked', true);
                    changeSwitchStatus()
                }
            });
        })
    @endif

    function createAnswerView(questionIndex, question) {
        let str = ''
        for (let i = 0; i <= 3; i++) {
            str += `<div class="form-check" id="q${questionIndex}">
                    <input class="form-check-input" type="radio" name="correctQ${questionIndex}" value="${i}" ${ (typeof(question) != "undefined" && question.answers[i].is_correct == 1) ? 'checked' : ''}>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">${i+1}</div>
                        </div>
                        <input type="text" class="form-control" name="answerContent${i}Q${questionIndex}" value="${ typeof(question) != "undefined" ? question.answers[i].content : ''}">
                    </div>
                </div>`
        }
        return str
    }

    function addMore(question) {
        questionIndex = $('.question').length + 1
        $(".questions").append(
            `<div class="question">
                <strong>Câu ${questionIndex}:</strong>
                <textarea class="form-control" name="questionContent${questionIndex}" id="exampleFormControlTextarea1" rows="3">${ typeof(question) != "undefined" ? question.content : ''}</textarea>
                ${createAnswerView(questionIndex, question)}
            </div>`
        )
    }

    changeSwitchStatus()

</script>
@endsection