@extends('layouts.main')
@section('main-content')

<div class="container-fluid px-5">
<div class="container form-quiz">
    <div class="safe-area">
        <div class="quiz-result-area">
            <h4 class="mx-2">Kết quả làm bài</h4>
            <div class="info">
                <div class="student-info">
                    <div class="avatar">
                        <img src="{{PUBLIC_URL}}img/avatar/{{$_SESSION['user']['avatar']}}">
                    </div>
                    <div class="name">
                        <p>{{$_SESSION['user']['name']}}</p>
                    </div>
                </div>

                <div class="quiz-result-info row">
                </div>
                <?php if ($showBtn) : ?>
                    <div class="d-flex justify-content-center reattempt-btn mt-3">
                        <a href="{{BASE_URL}}quizs/lam-bai/{{$qzid}}"><button class="btn btn-danger">Làm lại Quiz</button></a>
                    </div>
                <?php endif?>

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

    showResult = (result)=>{
        str = `<table class="table table-light table-striped col-md-12 col-lg-6">
                        <tbody>
                            <tr><td><strong>Môn học: </strong>${result.subjectName}</td></tr>
                            <tr><td><strong>Quiz: </strong>${result.name}</td></tr>
                            <tr><td><strong>Số lượng câu hỏi: </strong>${result.countQuestions}</td></tr>
                            <tr><td><strong>Thời gian làm quiz: </strong>${result.duration_minutes} phút</td></tr>
                            <tr><td><strong>Deadline: </strong>${result.start_time} đến ${result.end_time}</td></tr>
                        </tbody>
                    </table>
                    <table class="table table-light table-striped col-md-12 col-lg-6">
                        <tbody>
                            <tr><td><strong>Trạng thái: </strong>${result.status}</td></tr>
                            <tr><td><strong>Điểm số: </strong>${result.score*10}/10</td></tr>
                            <tr><td><strong>Thời gian làm bài: </strong>${parseInt(result.count_time/60) +'phút '+ result.count_time%60 + 'giây'}</td></tr>
                            <tr><td><strong>Số lần làm lại: </strong>${result.reattemp}</td></tr>
                            <tr><td><strong>Đủ điều kiện: </strong>${result.isOk}</td></tr>
                        </tbody>
                    </table>`
        $(".quiz-result-info").html(str)
    }

    prom().then(() => {
        $.get("{{BASE_URL}}api/quizs/get-result/{{$qzid}}", function(data) {
            console.log(data);
            showResult(data)
        });
    })
</script>
@endsection
