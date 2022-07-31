@extends('layouts.main')
@section('main-content')

<div class="container-fluid px-5">
    <div class="container form-quiz">
        <div class="safe-area">
            <div class="quiz-result-area">
                <h4 class="mx-2">Thống kê kết quả</h4>
                <div class="info">

                    <div class="quiz-result-info row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên học sinh</th>
                                    <th>Email</th>
                                    <th>Điểm</th>
                                    <th>Số lần làm lại</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('main-script')
<script>

    prom = () => {
        return new Promise((resolve) => {
            resolve()
        })
    }

    showSubject = (listQuestion)=>{
        str = listQuestion.map( (x)=>{
            return `<tr>
                        <td>${x.name}</td>
                        <td>${x.email}</td>
                        <td>${x.score*10}</td>
                        <td>${x.reattemp}</td>
                    </tr>`
        }).join('')
        $("tbody").html(str)
    }

    reloadList = ()=>{
        prom().then(() => {
            $.get("{{BASE_URL}}api/quizs/get-analytics/{{$qzid}}", function(data) {
                console.log(data)
                listQuestion = data
                showSubject(listQuestion)
            });
        })
    }
    reloadList()
    
</script>
@endsection