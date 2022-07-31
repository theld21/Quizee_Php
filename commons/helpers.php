<?php

const BASE_URL = "http://localhost/PHP2/assm/";
const PUBLIC_URL = BASE_URL . 'public/';

function isAdmin(){
    return (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 2) ? 1 : 0;
}

function isStudent(){
    return (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) ? 1 : 0;
}

function echoJson($arr, $pretty = false){
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: *");
    echo $pretty == true ? json_encode($arr, JSON_PRETTY_PRINT) : json_encode($arr);
}

function getCurentTime(){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    return date('Y-m-d H:i:s');
}

?>