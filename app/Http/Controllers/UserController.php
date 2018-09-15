<?php

namespace App\Http\Controllers;

use App\Like\Like;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $viewPath = 'users';

    public function users()
    {
        $users =  User::all()->except(Auth::id());
        return view($this->viewPath.'.index',compact('users','mutualUsers'));
    }

    public function nearUsers()
    {
        $latitude = session()->get('location.latitude');
        $longitude = session()->get('location.longitude');
        $users = $this->getUsersFromCurrentLocation($latitude, $longitude,5);
        return view($this->viewPath.'.near-user-list',compact('users'));
    }



    public function getUsersFromCurrentLocation( $lat, $long, $distance)
    {
        return User::all()
            ->except(Auth::id())
            ->filter(function ($user) use ($lat, $long, $distance) {
            $actual = 6371 * acos(
                    cos(deg2rad($lat)) * cos(deg2rad($user->latitude))
                    * cos(deg2rad($user->longitude) - deg2rad($long))
                    + sin(deg2rad($lat)) * sin(deg2rad($user->latitude))
                );
            return $distance > $actual;
        });
    }
}
