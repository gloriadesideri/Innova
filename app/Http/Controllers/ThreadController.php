<?php

namespace App\Http\Controllers;

use App\Argument;
use App\Section;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    public function show(){
        $thread=Thread::find(\request('thread'));
        $solutions=$thread->solutions();

        return view('threads.thread',['thread'=>$thread,'solutions'=>$solutions]);
    }

    public function create(){
        return view('threads.create');
    }


    public function store(){
        $this->validateThread();
        $section=Section::where('name',\request('section'))->firstOrFail();

        $thread =new Thread();
        $thread->body=\request('body');
        $thread->user_id=Auth::user()->id;
        $thread->section_id=$section->id;
        $thread->title=\request('title');
        $thread->save();

        $thread->arguments()->attach($this->convert_tags_to_array());
        return redirect('/'.$thread->channel->name.'/'.$section->name.'/threads');
    }
    public function update(){
        //remember that in frontend there will be no tag output form
        $thread=Thread::find(\request('thread'));
        $thread->update($this->validateUpdate());
        return redirect('/'.$thread->channel->name.'/'.$thread->section->name.'/threads/'.\request('thread'));
    }


    public function delete(){
        $thread=Thread::find(\request('thread'));
        $thread->comments()->delete();
        $thread->reports()->delete();
        $thread->solutions()->delete();
        $section=$thread->section;
        if(Auth::user()->can('delete',$thread)){
        Thread::destroy(\request('thread'));}

        return redirect('/'.$section->channel->name.'/'.$section->name.'/threads');

    }
    public function edit(){
        $thread=Thread::find(\request('thread'));
        return view('threads.edit',['thread'=>$thread]);
    }

    public function validateThread(){
        return \request()->validate([
            'title'=>['required','min:2','max:255'],
            'body'=>['required','min:100'],
            'tags'=>['required','min:2','max:255']
        ]);
    }
    public function  validateUpdate(){
        return \request()->validate([
            'title'=>['required','min:2','max:255'],
            'body'=>['required','min:100'],

        ]);
    }
    public function convert_tags_to_array(){

        $tags=trim(substr(\request('tags'), 0, -1)," ");
        $tag_array=explode(",",$tags);
        $id_array=[];
        foreach ($tag_array as $tag){
            if(Argument::where('name',$tag)->get()->isEmpty() && $tag!='') {
                $new_tag=new Argument();
                $new_tag->name=$tag;
                $new_tag->save();

            }
            array_push($id_array,Argument::where('name',$tag)->firstOrFail()->id);

        }
        return $id_array;
    }
}
