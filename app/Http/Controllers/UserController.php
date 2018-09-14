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

        $users = $this->getUsersFromCurrentLocation(23.768064400000004,90.3588037,5);
        return view($this->viewPath.'.near-user-list',compact('users'));
    }

    public function storeOrToggleLike( Request $request)
    {
       $existing_like =  Like::where('likeable_id', Auth::id())
                ->where('user_id',$request->id)
                ->first();

       if(!is_null($existing_like)){
            $existing_like->update(['is_like' => !$existing_like->is_like]);
           $is_like = $existing_like->is_like;
       }else{
           $like = Auth()->user()->likes()->create([
               'likeable_type' => User::class,
               'is_like'       => true,
               'user_id'       => $request->id
           ]);
           $is_like = $like->is_like;
       }

       $is_mutual = $this->isMutual($request->id);

        return response()->json(['is_mutual'=> $is_mutual,'is_like' => $is_like]);

    }

    private function isMutual($id)
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
