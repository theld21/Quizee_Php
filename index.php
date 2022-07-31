<?php
session_start();

require_once './commons/helpers.php';
require_once './vendor/autoload.php';
require_once './commons/utils.php';
require_once './commons/route.php';

$url = isset($_GET['url']) ? $_GET['url'] : "/";
defineRoute($url);

?>