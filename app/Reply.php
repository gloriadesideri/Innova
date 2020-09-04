<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;

class Reply extends Model implements ReactableContract
{
    use Reactable;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    public function comment(){
        return $this->belongsTo('App\Comment');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function reports(){
        return $this->morphMany('App\Report','reportable');
    }



}
