<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable=['best'];
    public function thread(){
        return $this->belongsTo('App\Thread');
    }
    public function comments(){
        //return $this->hasMany('App\SolutionComment');
        return $this->morphMany('App\Comment','commentable')->orderBy('created_at','desc');

    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function reports(){
        return $this->morphMany('App\Report','reportable');
    }
    public function channel(){
        return $this->belongsToThrough('App\Channel', ['App\Section', 'App\Thread']);

    }
    public function section(){
        return $this->belongsToThrough('App\Section','App\Thread');
    }

}
