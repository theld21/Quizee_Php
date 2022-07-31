<?php
namespace App\Controllers;
class DashboardController extends BaseController{
    public function index($id){
        return view('layouts.dashboard.main');
    }
}
?>