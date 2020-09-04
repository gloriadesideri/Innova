<?php

namespace App\Http\Controllers;

use App\Argument;
use App\Section;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index(){

        $section=Section::all()->first(function($item){
            return $item->name==\request('section');
        });
        if(\request('argument')){
            $argument=Argument::where('name',\request('argument'))->first();
            $threads=collect([]);
            $tagged=$argument->threads;
            $sectioned=$section->threads;

            foreach($sectioned as $thread){
                foreach ($tagged as $tt){
                    if($thread->id == $tt->id){
                        $threads->push($thread);
                    }
                }
            }
        }
        else if(\request()->has('search')){
            $threads=Thread::search(\request('search'))->where('section_id',$section->id)->get();

            }

        else{
            $threads=$section->threads;
        }
        return view('threads.section',['section'=>$section,'threads'=>$threads]);
    }



}
