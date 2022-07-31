<?php
namespace App\Controllers;

class BaseController{

    public static function isAdmin(){
        return (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 2) ? 1 : 0;
    }

    public static function isStudent(){
        return (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) ? 1 : 0;
    }

    

    
}
?>