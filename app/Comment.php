<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;

class Comment extends Model implements ReactableContract
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    use Reactable;

    protected $guarded=[];


    public function user(){
        return $this->belongsTo('App\User');
    }
    public function replies(){
        return $this->hasMany('App\Reply')->orderBy('created_at','desc');;
    }

    public function commentable(){
        return $this->morphTo();
    }

    public function reports(){
        return $this->morphMany('App\Report','reportable');
    }


}
