@extends('layouts.main')
@section('main-content')

<div class="container-fluid px-5">
    <div class="safe-area">
        <h4 class="mx-2">Danh sách môn học</h4>
        <div class="d-flex align-content-start flex-wrap text-center subject-items">
            <img src="https://thumbs.gfycat.com/ArtisticShoddyKudu-size_restricted.gif">
        </div>
        @if (isAdmin())
            <div class="area-plus">
                <div>
                    <i data-toggle="modal" data-target="#exampleModal" onclick="createSubject()" class="fas fa-plus subject"></i>
                </div>
            </div>
        @endif
    </div>
</div>
@if (isAdmin())
@include('subject._modal')
@endif
@endsection

@section('main-script')
<script>

    prom = () => {
        return new Promise((resolve) => {
            resolve()
        })
    }

    showSubject = (listQuestion)=>{
        str = listQuestion.map( (sub)=>{
            return `<div class="area-subject col-sm-6 col-md-4 col-lg-3 col-xl-3">
                    <div class="subject">
                        <div class="image"><a href="{{BASE_URL}}quizs/list/${sub.id}"><img src="{{BASE_URL}}/public/img/subject/${sub.img}"></a></div>
                        <div class="subj-content">
                            <a href="{{BASE_URL}}quizs/list/${sub.id}">
                                <h6>${sub.name}</h6>
                            </a>
                            <p><i class="fas fa-book"></i> ${sub.countQuizs} Quiz</p>
                            @if (isAdmin())
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" onclick="editSubject(${sub.id}, this, '${sub.img}')">Sửa</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" onclick="removeSubject(${sub.id}, this)">Xóa</button>
                            @endif
                        </div>
                    </div>
                </div>`
        }).join('')
        if(str=='') str = '<h2 class="text-center my-5">Không có dữ liệu ...</h2>'
        $(".subject-items").html(str)
    }

    reloadList = ()=>{
        prom().then(() => {
            $.get("{{BASE_URL}}api/subject/get-list-subject", function(data) {
                console.log(data)
                listQuestion = data
                showSubject(listQuestion)
            });
        })
    }
    reloadList()
    
</script>
@endsection