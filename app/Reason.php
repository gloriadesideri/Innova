<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $guarded=[];
    public function report(){
        return $this->hasMany('App\Report');
    }
}
