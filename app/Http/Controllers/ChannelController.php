<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

class ChannelController extends Controller
{
    public function index()
    {
        $user=Auth::user();

        $channel=$user->channels->first(function ($item){
            return $item->name==\request('channel');
        });
        if($channel) //TODO CHECK IF USER IS NOT SUBSCRIBED
        {
            if(\request('tag'))
            {
                $tag=Tag::where('name',\request('tag'))->first();
                $posts=collect([]);
                $tagged=$tag->posts;
                $channeled=$channel->posts;

                foreach ($channeled as $post){
                    foreach ($tagged as $tp){
                        if($post->id==$tp->id){
                            $posts->push($post);
                        }
                    }
                }
            }
            else{
                $posts=$channel->posts;
            }
            return view('feed.general', ['channel' => $channel,'posts'=>$posts,'channelName'=>$channel->name,'channelId'=>$channel->id]);
        }
        else
            abort(404,'wooops il canale non esiste');


    }
    public function list(){
        $user=Auth::user();
        $channels=Channel::all();
        return view('channels',['channels'=>$channels,'user'=>$user]);
    }
}
