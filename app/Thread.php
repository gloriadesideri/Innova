<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Thread extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
    use Searchable;




    protected $fillable=['title','body','solved'];

    public function solutions(){
        return $this->hasMany('App\Solution')->orderBy('created_at','desc');
    }
    public function comments(){
        //return $this->hasMany('App\ThreadComment');
        return $this->morphMany('App\Comment','commentable')->orderBy('created_at','desc');

    }
    public function section(){
        return $this->belongsTo('App\Section');
    }
    public function arguments(){
        return $this->belongsToMany('App\Argument');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function reports(){
        return $this->morphMany('App\Report','reportable');
    }
    public function channel(){
        return $this->belongsToThrough('App\Channel','App\Section');
    }
}
