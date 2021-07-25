<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WebController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function success(): View
    {
        return view('success');
    }

    public function fail(): View
    {
        return view('fail');
    }
}
