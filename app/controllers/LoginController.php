<?php

namespace App\Controllers;

use App\Models\User;

class LoginController
{
    public function __construct()
    {
        if (isset($_SESSION['user'])) {
            header('location: ' . BASE_URL . 'mon-hoc');
        }
    }

    public function loginForm()
    {
        return view('login.loginForm');
    }

    public function createAccount()
    {
        var_dump($_POST);
        $data = [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "password" => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        if (!isset($_FILES['image'])) {
            $data['avatar'] = 'default-avatar.png';
        } else {
            $extension = end(explode(".", $_FILES['image']['name']));
            $newfilename = md5($data['email']) . "." . $extension;

            $data['avatar'] = $newfilename;
            $file = $_FILES['image']['tmp_name'];
            $path = "./public/img/avatar/" . $newfilename;
            if (move_uploaded_file($file, $path))
            echo 'ok';
            else echo 'err';
        }

        $model = new User();
        $model->insert($data);
        header('location: ' . BASE_URL . 'mon-hoc');
        die;
    }

    public function checkpoin()
    {
        $data = [
            "email" => $_POST['email'],
            "password" => $_POST['password']
        ];
        $model = new User();
        $user = $model->login($data);

        if (!is_null($user)) {
            $_SESSION['user'] = [
                "id" => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role_id' => $user->role_id,
            ];
            header('location: ' . BASE_URL . 'mon-hoc');
        } else {
            echo '<script>alert("' . User::$err . '");window.location.href = "' . BASE_URL  . 'dang-nhap";</script>';
        }
    }

    public function logout()
    {
        session_destroy();
        header('location: ' . BASE_URL . 'dang-nhap');
    }
}
