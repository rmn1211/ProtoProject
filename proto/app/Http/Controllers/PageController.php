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
    
     public function match_ok()
    {
        return view('report.match_ok');
    }

    public function teams_overview()
    {
        return view('report.teams_overview');
    }
    public function spieler_overview()
    {
        return view('report.spieler_overview');
    }
    
}
