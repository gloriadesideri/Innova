<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Comment;
use App\Notifications\Like;
use App\Notifications\PostCommented;
use App\Post;
use App\Tag;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    public function create(){

        $this->validatePost();
        $channel=Channel::where('name',\request('channel'))->firstOrFail();
        $post=new Post();
        $post->title=\request('title');
        $post->body=\request('body');
        $post->user_id= \request()->user()->id;
        $post->channel_id= $channel->id;

        $post->save();

        $post->tags()->attach($this->convert_tags_to_array());
        if(\request()->has('file')) {
            $path = \request('file')->store('posts', 'public');
            $post->image()->create(['url' => $path]);
        }
        return redirect('/channels/'.$channel->name);
    }


    public function like(){
        $user=Auth::user();
        $post=Post::find(\request('post'));
        $channel=$post->channel;

        $reacter=$user->getLoveReacter();
        $reactant=$post->getLoveReactant();
        $reaction=ReactionType::fromName('Like');
        if($reacter->hasReactedTo($reactant)){

            $reacter->unReactTo($reactant,$reaction);
            $post->like_count=$post->like_count-1;

        }
        else{

            $reacter->reactTo($reactant,$reaction);
            $post->like_count=$post->like_count+1;

            $receiver=$post->user;
            Notification::send($receiver,new Like($user,$post,'post',$channel));

        }
        $post->save();
        return redirect('/channels/'.$channel->name);

//        return response()->json(['result'=>'success'],200);

    }
    public function delete(){
        $post=Post::find(\request('post'));
        $channel=$post->channel->name;

        $post->comments()->delete();
        $post->reports()->delete();
        $post->image()->delete();
        Post::destroy(\request('post'));


        return redirect('/channels/'.$channel);

    }
    public function pin(){
        $post=Post::find(\request('post'));
        $post->pinned=true;
        $post->save();
        return redirect('/channels/'.$post->channel->name);
    }



    public function validatePost(){
        return \request()->validate([
            'title'=>['required','min:2','max:255'],
            'body'=>'required',
            'tags'=>['required','min:2','max:255'],
            'file'=>'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    }
    public function convert_tags_to_array(){

        $tags=trim(substr(\request('tags'), 0, -1)," ");
        $tag_array=explode(",",$tags);
        $id_array=[];
        foreach ($tag_array as $tag){
            if(Tag::where('name',$tag)->get()->isEmpty() && $tag!=''){
                $new_tag=new Tag();

                $new_tag->name=$tag;
                $new_tag->save();

            }
            array_push($id_array,Tag::where('name',$tag)->firstOrFail()->id);

        }
        return $id_array;
    }
}
