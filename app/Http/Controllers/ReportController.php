<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Notifications\ContentDeleted;
use App\Notifications\ContentNotDeleted;
use App\Notifications\ReportReceived;
use App\Post;
use App\Reply;
use App\Report;
use App\Solution;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class ReportController extends Controller
{
    public function create(){

        $this->validateReport();

        switch (\request('table')){
            case 'post':
                $model=Post::find(\request('model'));
                $action='/channels/'.$model->channel->name.'/#post-'.$model->id;
                $channel=$model->channel;

                break;
            case 'thread':
                $model=Thread::find(\request('model'));
                $action='/'.$model->channel->name.'/'.$model->section->name.'/threads/'.$model->id.'#post-'.$model->id;
                $channel=$model->channel;

                break;
            case 'solution':
                $model=Solution::find(\request('model'));
                $action='/'.$model->channel->name.'/'.$model->section->name.'/threads/'.$model->id.'#solution-'.$model->id;
                $channel=$model->channel;

                break;
            case 'reply':

                $model=Reply::find(\request('model'));
                $action='/channels/'.$model->comment->commentable->channel->name.'/#reply-'.$model->id;
                $channel=$model->comment->commentable->channel;

                break;
            case 'comment':

                $model=Comment::find(\request('model'));
                $action=$this->actionDecider($model);
                $channel=$model->commentable->channel;


                break;
            default:
                $model=null;
                $action='';
                $channel='home';
        }
        if($model){




            $model->reports()->create(['channel'=>$channel->name,'action'=>$action,'reason_id'=>\request('reason')]);

            \Illuminate\Support\Facades\Notification::send($model->user,new ReportReceived(Auth::user(),$model,\request('table'),$action));
            return redirect($action)->with('message','report created');
        }
        else{
            return redirect($action)->withErrors('model','model no longer available for report');
        }
    }
    public function delete(){
        $report=Report::find(\request('report'));

        if(!$report->reportable){
            $related=Report::where('reportable_id',$report->reportable_id)->get();
            foreach ($related as $rel){
                $rel->delete();
            }
        }
        else{
            \Illuminate\Support\Facades\Notification::send($report->reportable->user,new ContentNotDeleted($report->action));

        }
        Report::destroy(\request('report'));
        return redirect('admin/dashboard');
    }
    public function actionDecider($model){
        if(get_class($model->commentable)=='App\Post'){
            $action='/channels/'.$model->commentable->channel->name.'/#comment-'.$model->id;
        }
        else {
            $action='/'.$model->commentable->channel->name.'/'.$model->commentable->section->name.'/threads/'.$model->commentable->id.'#comment-'.$model->id;

        }

        return $action;
    }
    public function validateReport(){
        return \request()->validate([
            'reason'=>['required','exists:reasons,id']
        ]);
    }
}
