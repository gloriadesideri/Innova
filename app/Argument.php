<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Argument extends Model
{
    public function threads(){
        return $this->belongsToMany('App\Thread');
    }
}
