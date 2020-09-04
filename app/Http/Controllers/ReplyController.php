<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notifications\CommentReplied;
use App\Notifications\Like;
use App\Reply;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReplyController extends Controller
{
    public function create(){
        $this->validateReply();
        $comment=Comment::find(\request('comment'));
        $channel=$comment->commentable->channel;
        $reply=new Reply();
        $reply->body=\request('reply-body');
        $reply->user_id=Auth::user()->id;
        $reply->comment_id=\request('comment');
        $reply->save();
        $user=$comment->user;
        $user->notify(new CommentReplied($reply));
        return redirect('/channels/'.$channel->name);
    }

    public function like(){
        $user=Auth::user();
        $reply=Reply::find(\request('reply'));
        $channel=$reply->comment->commentable->channel;

        $reacter=$user->getLoveReacter();
        $reactant=$reply->getLoveReactant();
        $reaction=ReactionType::fromName('Like');
        if($reacter->hasReactedTo($reactant)){

            $reacter->unReactTo($reactant,$reaction);
            $reply->like_count=$reply->like_count-1;

        }
        else{

            $reacter->reactTo($reactant,$reaction);
            $reply->like_count=$reply->like_count+1;

            $receiver=$reply->user;

            Notification::send($receiver,new Like($user,$reply,'reply',$channel));
        }
        $reply->save();
        return redirect('/channels/'.$channel->name);

//        return response()->json(['result'=>'success'],200);

    }
    public function delete(){
        $reply=Reply::find(\request('reply'));

        $reply->reports()->delete();
        $channel=$reply->comment->commentable->channel->name;
        Reply::destroy(\request('reply'));

        return redirect('/channels/'.$channel);

    }
    public function validateReply(){
        return \request()->validate([
            'reply-body'=>'required',
            //'tags'=>['required','min:2','max:255']
        ]);
    }
}
