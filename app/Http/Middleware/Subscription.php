<?php

namespace App\Http\Middleware;

use App\Channel;
use Closure;
use Illuminate\Support\Facades\Auth;

class Subscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $channel=Channel::where('name',$request->channel)->firstOrFail();
        if(Auth::user()->isSubscribed($channel->id)) {
            return $next($request);
        }
        else{
            return redirect('/channels');
        }
    }
}
