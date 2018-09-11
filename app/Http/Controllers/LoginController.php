<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $viewPath = 'authentication';
    public function __construct()
    {
    }

    public function showLoginForm()
    {
        if(session()->has('isLogedIn')){
            return redirect()->route('home');
        }

        return view("{$this->viewPath}.login");
    }

    public function login(Request $request)
    {
        if($user = User::where('email',$request->email)){
            session()->put('isLogedIn',true);
            return view('home',compact('user'));
        };
        return back()->with('message','Email address not found');
    }

    public function logout()
    {
        session()->forget('isLogedIn');
        return redirect()->route('home');
    }
}
