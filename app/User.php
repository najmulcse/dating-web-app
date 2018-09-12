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
        'name', 'email', 'password','date_of_birth','gender'
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

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function getAgeAttribute()
    {
        $dateOfBirth = $this->date_of_birth;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');
    }
}
