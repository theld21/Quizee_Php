@extends('layouts.main')
@section('main-content')

<style>
body {background-image: linear-gradient(135deg, #09203f, #2c648f);}
</style>
<div class="container-fluid container-playing-quiz">
    <div class="header-quiz-area">
        <div class="container-fluid btn-area mt-4 mx-3">
            <span class="float-left logo"><i class="fas fa-feather-alt"></i>QUIZee</span>
            <span class="float-right time"><span id="timeCounter"></span> <i class="fas fa-stopwatch"></i></span>
        </div>
    </div>
    <div class="playing-quiz-area container">
        <div class="question-area">
            <span id="questionIndex"></span>
        </div>
        <div class="answer-area mt-4"></div>
        <div class="btn-area mt-4">
            <button class="float-left btn btn-primary" onclick="showQuestion('pre')">Câu trước</button>
            <button class="float-right btn btn-danger" onclick="showQuestion('next')">Câu tiếp</button>
        </div>
    </div>
    <div class="end-btn text-center mt-5">
        <button class="float-center btn btn-end btn-success" onclick="finishQuiz()">Kết thúc bài kiểm tra</button>
    </div>
</div>

@endsection

@section('main-script')

<script>
    curentQuestion = 1
    listQuestion = []

    sleep = (ms) => {
        return new Promise((resolve) => {
            setTimeout(resolve, ms);
        })
    }

    showQuestion = (directType) => {
        switch (directType) {
            case 'next':
                if (curentQuestion < listQuestion.length)
                    curentQuestion += 1
                else
                    return
                break;
            case 'pre':
                if (curentQuestion > 1)
                    curentQuestion -= 1
                else
                    return
                break;
        }

        let str = ''
        let chars = ['A. ', 'B. ', 'C. ', 'D. ']
        for (x of listQuestion[curentQuestion - 1].listAnswer) {
            str += `<div class="form-check answer-row">
                        <input class="form-check-input" type="radio" name="${listQuestion[curentQuestion - 1].id}" onchange="submitAnswer()" id="${x.id}">
                        <div class="mx-2"><label class="form-check-label" for="${x.id}">${x.content}</label></div>
                    </div>`
        }
        $("#questionIndex").html(`<strong>Câu ${curentQuestion}:</strong> ` + listQuestion[curentQuestion - 1].content)
        $(".answer-area").html(str)
        if (listQuestion[curentQuestion - 1].answerChecked != null)
            $("#" + listQuestion[curentQuestion - 1].answerChecked).prop('checked', true)
    }

    getTimeRemaining = () => {
        $.get(`{{BASE_URL}}api/quizs/check-time/{{$StudentQuizId}}`, function(data) {
            if (data.timeRemaining > 0)
                $("#timeCounter").text(parseInt(data.timeRemaining / 60) + ":" + (data.timeRemaining % 60 < 10 ? '0' : '') + data.timeRemaining % 60);
            else {
                finishQuiz()
            }
        });
    }

    submitAnswer = () => {
        $("input").each(function() {
            if ($(this).is(":checked")) {
                listQuestion[curentQuestion - 1].answerChecked = $(this).attr('id')
                $.get(`{{BASE_URL}}api/quizs/submit-answer/{{$StudentQuizId}}/${$(this).attr('name')}/${$(this).attr('id')}`, (data)=>{console.log(data);});
                return
            }
        })
    }

    finishQuiz = () => {
        $.get(`{{BASE_URL}}api/quizs/finish-quiz/{{$StudentQuizId}}`, ()=>{
            $(location).prop('href', '{{BASE_URL}}quizs/ket-qua/{{$qzid}}')
        })
    }

    getTimeRemainingInterval = () => {
        sleep(1000).then(() => {
            getTimeRemaining()
            getTimeRemainingInterval()
        })
    }

    sleep(0).then(() => {
        getTimeRemaining()
        getTimeRemainingInterval()
    })

    sleep(0).then(() => {
        $.get("{{BASE_URL}}api/quizs/get-list-question/{{$qzid}}/{{$StudentQuizId}}", function(data) {
            console.log(data)
            listQuestion = data
            showQuestion()
        });
    })
</script>
@endsection