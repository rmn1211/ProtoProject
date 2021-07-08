<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    
    public function home()
    {
        return view('main.home');
    }
    public function heafoo()
    {
        return view('heafoo');
    }
    public function login()
    {
        return view('myauth.login');
    }

    public function overview()
    {
        return view('report.overview');
    }

    public function report($id)
    {
        return view('report.check_report', ['match' => $id]);
    }
    public function old()
    {
        return view('welcome');
    }
}
