<?php

namespace App\Http\Controllers;

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
        return view('overviews.teams_overview');
    }
    public function player_overview()
    {
        return view('overviews.player_overview');
    }

}
