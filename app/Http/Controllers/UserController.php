<?php

namespace App\Http\Controllers;

use App\Like\Like;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function users()
    {
        $mutualUsers = $this->getMutualLikeUsers();

        $users =  User::all()->except(Auth::id());
        return view('users.index',compact('users','mutualUsers'));
    }

    public function nearUsers()
    {

        $users = $this->getUsersFromCurrentLocation(23.768064400000004,90.3588037,3.10686);
        return view('users.near-user-list',compact('users'));
    }

    public function toggleLike( Request $request)
    {
        $existingLike =  Like::where('likeable_id', Auth::id())
                ->where('user_id',$request->id)
                ->first();

       if(!is_null($existingLike)){
           $existingLike->update(['is_like' => !$existingLike->is_like]);

       }else{
           Auth()->user()->likes()->create([
               'likeable_type' => User::class,
               'is_like'       => true,
               'user_id'       => $request->id
           ]);
       }
       $isMutualLike = $this->isMutualLike($request->id);

        return response()->json(['is_mutual'=> $isMutualLike]);

    }

    private function isMutualLike($id)
    {
        return  Like::where(function($query) use ( $id ){
            $query->where('likeable_id', auth()->id())
                ->where('user_id', $id)
                ->where('likeable_type', User::class)
                ->where('is_like', true);
        })
        ->orWhere(function($query) use ( $id ){
            $query->where('likeable_id', $id)
                ->where('user_id', auth()->id())
                ->where('likeable_type', User::class)
                ->where('is_like', true);
        })->count() == 2;
    }

    public function getUsersFromCurrentLocation( $lat, $long, $distance)
    {
        return User::all()->filter(function ($user) use ($lat, $long, $distance) {
            $actual = 3959 * acos(
                    cos(deg2rad($lat)) * cos(deg2rad($user->latitude))
                    * cos(deg2rad($user->longitude) - deg2rad($long))
                    + sin(deg2rad($lat)) * sin(deg2rad($user->latitude))
                );

            return $distance > $actual;
        });
    }
}
