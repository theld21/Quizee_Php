@extends('layouts.main')
@section('main-content')

<div class="container-fluid px-5">
    <div class="list-quiz">
        <div class="safe-area">
            <h4 class="mx-2">{{$subjectName}}</h4>
            <div class="d-flex align-content-start flex-wrap quizs quiz-items">
                <img src="https://thumbs.gfycat.com/ArtisticShoddyKudu-size_restricted.gif">
            </div>

            <div class="add-more-btn"></div>
        </div>
    </div>
</div>

@if (isAdmin())
@include('quiz._modal')
@endif
@endsection

@section('main-script')
<script>
    prom = () => {
        return new Promise((resolve) => {
            resolve()
        })
    }

    createStatus = (status, t1, t2)=>{
        return status==1? t1:t2
    }

    showQuiz = (listQuiz)=>{
        str = listQuiz.map( (quiz)=>{
            return `<div class="quiz col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="quiz-area">
                            <div class="name">
                                <a href="{{BASE_URL}}quizs/@if(isAdmin()){{'sua-quiz/'.$sbjid.'/${quiz.id}'}}@else{{'ket-qua/${quiz.id}'}}@endif">
                                    <div class="label">${quiz.name}</div>
                                </a>
                            </div>
                            @if (isAdmin())
                                <div class="text-center mt-2">
                                    <button type="button" class="btn ${createStatus(quiz.status,'btn-primary','btn-danger')}" data-toggle="modal" data-target="#exampleModal" onclick="editDeadlineQuiz('${quiz.id}', '${quiz.duration_minutes}', '${quiz.start_time}', '${quiz.end_time}', '${quiz.status}')">${createStatus(quiz.status,'Đang Hiện','Đang Ẩn')}</button>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" onclick="editDeadlineQuiz('${quiz.id}', '${quiz.duration_minutes}', '${quiz.start_time}', '${quiz.end_time}', '${quiz.status}')">Gia hạn</button>
                                    <a href="{{BASE_URL}}quizs/thong-ke/${quiz.id}"><button type="button" class="btn btn-success">Thống kê</button></a>
                                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal" onclick="removeQuiz('${quiz.id}', this)"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            @endif
                            <div class="subj-content mb-2">
                                <span class="float-left"> ${quiz.countQuestions} câu hỏi</span>
                                <span class="float-right">Deadline: ${quiz.end_time}</span>
                            </div>
                        </div>
                    </div>`
        }).join('')
        if(str=='') str = '<h2 class="text-center my-5">Không có dữ liệu ...</h2>'
        $(".quiz-items").html(str)
        
        @if (isAdmin())
            btn = `<div class="area-plus">
                <div class="plus">
                    <a href="{{BASE_URL}}quizs/tao-moi/{{$sbjid}}/${listQuiz.length}"><i class="fas fa-plus subject" onclick=""></i></a>

                </div>
                </div>`
            $('.add-more-btn').html(btn)
        @endif
    }
    reloadList = ()=>{
        prom().then(() => {
            $.get("{{BASE_URL}}api/quizs/get-list-quiz/{{$sbjid}}}", function(data) {
                console.log(data)
                showQuiz(data)
            });
        })
    }
    reloadList()
</script>
@endsection