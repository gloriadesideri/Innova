<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function users(){
        return $this->belongsToMany('App\User');
    }
    public function posts(){
        return $this->hasMany('App\Post')->orderBy('created_at','desc');;
    }

    public function sections(){
        return $this->hasMany('App\Section');
    }
}
