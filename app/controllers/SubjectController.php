<?php
namespace App\Controllers;

class SubjectController extends BaseController{

    public function index(){
        return view('subject.subjects',[
            "header"=>true
        ]);
    }
}
?>