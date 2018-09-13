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
        $users =  User::all()->except(Auth::id());
        return view('users.index',compact('users'));
    }
    public function toggleLike( $id)
    {
       $existing_like =  Like::where('likeable_id', Auth::id())
                ->where('user_id',$id)
                ->first();
        $message = 'Updated';
       if(!is_null($existing_like)){
           $existing_like->update(['is_like' => !$existing_like->is_like]);

           if($this->isMutual($id)){
               $message = 'Matched!';
           }
       }else{
           Auth()->user()->likes()->create([
               'likeable_type' => User::class,
               'is_like'       => true,
               'user_id'       => $id
           ]);
       }

       return back()->with('message', $message);

    }

    private function isMutual($id)
    {
       return Like::where('likeable_id', $id)
            ->where('user_id',Auth::id())
            ->where( function($query) use ($id){
                $query->where('likeable_id', Auth::id())
                    ->where('user_id',$id);
            })
           ->where('is_like', true)->first();
    }
}
