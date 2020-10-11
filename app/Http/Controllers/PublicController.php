<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDashboard()
    {
        return view('dashboard');
    }
}
