<?php

namespace App;

use App\Like\Like;
use App\Location\Location;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','date_of_birth','gender','latitude','longitude','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function getAgeAttribute()
    {
        $dateOfBirth = $this->date_of_birth;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');
    }

    public function isLiked($user)
    {
        return $this->likes()->where('user_id',$user)
                        ->where('is_like', true)
                        ->exists();
    }

    public function getDistanceAttribute()
    {
        return round(6371 * acos(
                cos(deg2rad($this->latitude)) * cos(deg2rad(auth()->user()->latitude))
                * cos(deg2rad(auth()->user()->longitude) - deg2rad($this->longitude))
                + sin(deg2rad($this->latitude)) * sin(deg2rad(auth()->user()->latitude))
            ),2);
    }

}
