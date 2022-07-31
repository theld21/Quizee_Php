@extends('layouts.main')
@section('main-content')

<style>body {background-image: linear-gradient(135deg, #09203f, #2c648f)}</style>

<div class="login-area">
    <div class="padding container d-flex justify-content-center login-form">
        <div class="col-md-10 col-md-offset-1">
            <form class="signup-form" id="login-form" action="<?= BASE_URL . 'checkpoin' ?>" method="post">
                <h2 class="text-center">LOGIN</h2>
                <hr>
                <div class="form-group"> <input type="email" name="email" class="form-control" placeholder="Email Address" required="required"> </div>
                <div class="form-group"> <input type="password" name="password" class="form-control" placeholder="Password" required="required"> </div>
                hoặc <a style="text-decoration: underline;" href="#" onclick="switchForm()"> ĐĂNG KÝ </a> tài khoản mới
                <div class="form-group text-center mt-2"> <button type="submit" class="btn btn-blue btn-block">Đăng nhập</button> </div>
            </form>

            <form class="signup-form" id="register-form" action="<?= BASE_URL . 'tao-tai-khoan' ?>" method="post" style="display: none" enctype="multipart/form-data">
                <h2 class="text-center">SIGNUP NOW</h2>
                <hr>
                <div class="form-group"> <input type="text" name="name" class="form-control" placeholder="Full Name" required="required"> </div>
                <div class="form-group"> <input type="email" name="email" class="form-control" placeholder="Email Address" required="required"> </div>
                <div class="form-group"> <input type="text" name="password" class="form-control" placeholder="Password" required="required"> </div>
                <div class="form-group"> <input type="text" name="repassword" class="form-control" placeholder="rePassword" required="required"> </div>
                <div class="form-group">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Ảnh đại diện: </div>
                        </div>
                        <input type="file" id="avatar" accept=".png, .jpg, .jpeg, .jfif" name="image">
                    </div>
                </div>
                hoặc <a style="text-decoration: underline;" href="#" onclick="switchForm()"> ĐĂNG NHẬP </a> ở đây
                <div class="form-group text-center mt-2"> <button type="submit" class="btn btn-blue btn-block">Đăng ký</button> </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('main-script')
    
<script>
    var loginForm = true

    function switchForm() {
        if (loginForm) {
            $("#login-form").attr('style', 'display: none')
            $("#register-form").removeAttr('style')
        } else {
            $("#register-form").attr('style', 'display: none')
            $("#login-form").removeAttr('style')
        }
        loginForm = !loginForm
    }
</script>

@endsection
