<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
//        dd(asset('assets/admin'));
        return view('admin.pages.dashboard');
    }
}
