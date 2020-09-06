<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Comment;
use App\Notifications\CommentReplied;
use App\Notifications\Like;
use App\Notifications\ModelCommented;
use App\Notifications\PostCommented;
use App\Post;
use App\Reply;
use App\Solution;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Thread;

class CommentController extends Controller
{
    public function create(){
        $this->validateComment();

        switch (\request('table')){
            case 'post':
                $model=Post::find(\request('model'));
                $action='/channels/'.$model->channel->name.'/#post-'.$model->id;

                break;
            case 'thread':
                $model=\App\Thread::find(\request('model'));
                $action='/'.$model->channel->name.'/'.$model->section->name.'/threads/'.$model->id.'#comment-'.$model->id;

                break;
            case 'solution':
                $model=Solution::find(\request('model'));
                $action='/'.$model->channel->name.'/'.$model->section->name.'/threads/'.$model->thread->id.'#comment-'.$model->id;

                break;

            default:
                $model=null;
                $action='';
        }
        if($model){


            $model->comments()->create(['body'=>request('comment-body'),'user_id'=>Auth::user()->id]);

            \Illuminate\Support\Facades\Notification::send($model->user,new ModelCommented(Auth::user(),$model,\request('table'),$action));
            return redirect($action);
        }
        else{
            return redirect($action)->withErrors('model','model no longer available for comment');
        }
    }


    public function like(){
        $user=Auth::user();
        $comment=Comment::find(\request('comment'));
        $channel=$comment->commentable->channel;

        $reacter=$user->getLoveReacter();
        $reactant=$comment->getLoveReactant();
        $reaction=ReactionType::fromName('Like');

        if($reacter->hasReactedTo($reactant)){

            $reacter->unReactTo($reactant,$reaction);
            $comment->like_count=$comment->like_count-1;

        }
        else{

            $reacter->reactTo($reactant,$reaction);
            $receiver=$comment->user;
            $comment->like_count=$comment->like_count+1;
            Notification::send($receiver,new Like($user,$comment,'comment',$channel));
        }
        $comment->save();

        return redirect('/channels/'.$channel->name.'#comment-'.$comment->id);


    }
    public function delete(){

        $comment=Comment::find(\request('comment'));

        $comment->reports()->delete();
        $action=$this->actionFinder($comment->commentable,\request('table'));
        Comment::destroy(\request('comment'));

        return redirect($action);

    }
    public function validateComment(){
        return \request()->validate([
            'comment-body'=>'required',
            //'tags'=>['required','min:2','max:255']
        ]);
    }

    public function actionFinder($model,$type){
        switch ($type){
            case 'post':
                $action='/channels/'.$model->channel->name.'/#post-'.$model->id;

                break;
            case 'thread':
                $action='/'.$model->channel->name.'/'.$model->section->name.'/threads/'.$model->id.'#post-'.$model->id;

                break;
            case 'solution':
                $action='/'.$model->channel->name.'/'.$model->section->name.'/threads/'.$model->thread->id.'#solution-'.$model->id;

                break;

            default:
                $action='';
        }
        return $action;
    }
}
