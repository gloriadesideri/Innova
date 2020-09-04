<?php

namespace App\Http\Controllers;

use App\Notifications\SolutionMarkedAsBest;
use App\Notifications\SolutionPosted;
use App\Solution;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    public function store(){
        $this->validateSolution();
        $thread=Thread::find(\request('thread'))->firstOrFail();

        $solution =new Solution();
        $solution->body=\request('solution-body');
        $solution->user_id=Auth::user()->id;
        $solution->thread_id=$thread->id;
        $solution->save();
        $user=$thread->user;
        $user->notify(new SolutionPosted($solution));
        return redirect('/'.$thread->channel->name.'/'.$thread->section->name.'/threads/'.$thread->id);
    }
    public function delete(){
        $solution=Solution::find(\request('solution'));

        $solution->reports()->delete();
        $solution->comments()->delete();
        $thread=$solution->thread;
        if($solution->best){
        $thread->solved=false;
        $thread->save();}
        Solution::destroy(\request('solution'));

        return redirect('/'.$thread->channel->name.'/'.$thread->section->name.'/threads/'.$thread->id);

    }
    public function best(){
        $solution=Solution::find(\request('solution'));
        $thread=$solution->thread;
        //check if thread already has a best solution
        if($thread->solved && !$solution->best){
            //if so look for the solving solution
            $oldSolution=Solution::where('thread_id',$thread->id)->where('best',true)->first();
            $oldSolution->update(['best'=>false]);
            $solution->update(['best'=>true]);
            $user=$solution->user;
            $user->notify(new SolutionMarkedAsBest($solution,Auth::user()));

        }
        elseif ($solution->best){
            $solution->update(['best'=>false]);
            $thread->update(['solved'=>false]);
        }
        else{
            $solution->update(['best'=>true]);
            $thread->update(['solved'=>true]);
            $user=$solution->user;
            $user->notify(new SolutionMarkedAsBest($solution,Auth::user()));
        }
        return redirect('/'.$thread->channel->name.'/'.$thread->section->name.'/threads/'.$thread->id);

    }

    public function validateSolution(){
        return \request()->validate([
            //'title'=>['required','min:2','max:255'],
            'solution-body'=>['required','min:100'],
            //'tags'=>['required','min:2','max:255']
        ]);
    }
}
