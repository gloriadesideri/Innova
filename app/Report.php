<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded=[];

    public function reportable(){
        return $this->morphTo();
    }

    public function reason(){
        return $this->belongsTo('App\Reason');
    }
}
