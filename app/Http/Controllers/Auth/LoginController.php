<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if(!session()->exists('location')){
            $location = [
              'latitude' =>  $request->latitude,
              'longitude' => $request->longitude
            ];
            session()->put('location', $location);
        }

    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function loggedOut(Request $request)
    {
        if(session()->exists('location'))
        {
            session()->flash('location');
        }
    }

}
