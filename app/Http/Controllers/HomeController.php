<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        if(! session()->has('isLogedIn')){
            return view('welcome');
        }

        return view('home');
    }
}
