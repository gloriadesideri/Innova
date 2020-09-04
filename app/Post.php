<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

class Post extends Model implements ReactableContract
{
    /**
     * @var mixed
     */

    use Reactable;

    protected $fillable=['title','body'];
    protected $guarded=[];

    public  function user(){
        return $this->belongsTo('App\User');
    }
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
    public function channel(){
        return $this->belongsTo('App\Channel');
    }
    public function comments(){
        //return $this->hasMany('App\Comment');
        return $this->morphMany('App\Comment','commentable')->orderBy('created_at','desc');

    }
    public function reports(){
        return $this->morphMany(Report::class,'reportable');
    }
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }


}
