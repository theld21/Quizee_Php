<?php

use App\Controllers\LoginController;
use App\Controllers\SubjectController;
use App\Controllers\QuizController;
use App\Controllers\DashboardController;
use App\API\QuizAPI;
use App\API\SubjectAPI;

use Phroute\Phroute\RouteCollector;
function defineRoute($url){
    $router = new RouteCollector();

    $router->filter('auth', function(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            header('location: ' . BASE_URL . 'dang-nhap');
            die;
        }
    });

    $router->get('dang-nhap', [LoginController::class, 'loginForm']);
    $router->post('checkpoin', [LoginController::class, 'checkpoin']);
    $router->get('dang-ky', [LoginController::class, 'loginForm']);
    $router->get('tao-tai-khoan', [LoginController::class, 'createAccount']);
    $router->any('dang-xuat', function(){
        session_destroy();
        header('location: ' . BASE_URL . 'dang-nhap');
        die;
    });

    $router->get('/', [SubjectController::class, 'index']);

    $router->group(['prefix' => 'mon-hoc', 'before' => 'auth'], function($router){
        $router->get('/', [SubjectController::class, 'index']);
    });
    
    $router->group(['prefix' => 'quizs', 'before' => 'auth'], function($router){
        $router->get('list/{sbjid}', [QuizController::class, 'index']);
        $router->get('tao-moi/{sbjid}/{count}', [QuizController::class, 'formAddQuiz']);
        $router->get('sua-quiz/{sbjid}/{qzid}', [QuizController::class, 'formEditQuiz']);
        $router->get('lam-bai/{qzid}', [QuizController::class, 'startQuiz']);
        $router->get('ket-qua/{qzid}', [QuizController::class, 'quizResult']);
        $router->get('thong-ke/{qzid}', [QuizController::class, 'quizAnalytics']);
    });
    
    // API
    $router->post('api/subject/change-image/{id}', [SubjectAPI::class, 'saveImage']);
    $router->group(['prefix' => 'api/subject', 'before' => 'auth'], function($router){
        $router->get('get-list-subject', [SubjectAPI::class, 'getListSubject']);
        $router->post('add/', [SubjectAPI::class, 'saveAdd']);
        // $router->post('change-image/{id}', [SubjectAPI::class, 'saveImage']);
        $router->post('edit/{id}', [SubjectAPI::class, 'saveEdit']);
        $router->get('delete/{id}', [SubjectAPI::class, 'remove']);
    });

    $router->group(['prefix' => 'api/quizs', 'before' => 'auth'], function($router){
        $router->get('get-list-question-edit/{qzid}', [QuizAPI::class, 'getListQuestionEdit']);
        $router->get('get-quiz-details/{qzid}', [QuizAPI::class, 'getQuizDetails']);
        $router->get('get-analytics/{qzid}', [QuizAPI::class, 'getAnalytics']);
        $router->get('delete/{id}', [QuizAPI::class, 'remove']);
        $router->post('add/{sbjid}', [QuizAPI::class, 'saveAdd']);
        $router->post('edit/{qzid}', [QuizAPI::class, 'saveEdit']);
    });
    
    $router->group(['prefix' => 'api/quizs', 'before' => 'auth'], function($router){
        $router->get('get-list-quiz/{sbjid}', [QuizAPI::class, 'getListQuiz']);
        $router->get('get-result/{qzid}', [QuizAPI::class, 'getResult']);
        $router->get('get-list-question/{qzid}/{sqzid}', [QuizAPI::class, 'getListQuestion']);
        $router->get('check-time/{sqzid}', [QuizAPI::class, 'checkTime']);
        $router->get('submit-answer/{sqzid}/{qstid}/{ansid}', [QuizAPI::class, 'submitAnswer']);
        $router->get('finish-quiz/{sqzid}', [QuizAPI::class, 'finishQuiz']);
    });
    
    $dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($url, PHP_URL_PATH));

    echo $response;
}

?>