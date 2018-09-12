<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function users()
    {
        $users =  User::all()->except(Auth::id());
        return view('users.index',compact('users'));
    }
}
