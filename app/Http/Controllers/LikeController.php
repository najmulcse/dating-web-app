<?php

namespace App\Http\Controllers;

use App\Like\Like;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {

    }

    public function storeOrToggleLike( Request $request)
    {
        $existingLike =  Like::where('likeable_id', Auth::id())
            ->where('user_id',$request->id)
            ->first();

        if(!is_null($existingLike)){
            $existingLike->update(['is_like' => !$existingLike->is_like]);
            $isLike = $existingLike->is_like;
        }else{
            $like = Auth()->user()->likes()->create([
                'likeable_type' => User::class,
                'is_like'       => true,
                'user_id'       => $request->id
            ]);
            $isLike = $like->is_like;
        }

        $isMutualLike = $this->isMutualLike($request->id);

        return response()->json(['is_mutual'=> $isMutualLike,'is_like' => $isLike]);

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
}
