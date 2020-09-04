<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function threads(){
        return $this->hasMany('App\Thread');
    }
}
