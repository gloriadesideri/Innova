<?php

namespace App;
use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableContract;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements ReacterableContract, MustVerifyEmail
{
    use Notifiable, Reacterable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }
    public  function channels(){
        return $this->belongsToMany('App\Channel');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function threads(){
        return $this->hasMany('App\Threads');
    }
    public function isSubscribed($id){
        return !empty($this->channels()->find($id));
    }
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }


}
