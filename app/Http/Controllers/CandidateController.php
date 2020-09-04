<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Channel;
use App\Notifications\CandidationResult;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class CandidateController extends Controller
{
    public function store(){
        $channel=Channel::find(\request('channelId'));
        $candidate=new Candidate();
        $candidate->user_id=Auth::user()->id;
        $candidate->channel_id=\request('channelId');

        $candidate->save();

        return redirect('/channels/'.$channel->name)->with('candidation','candidation received, you will be notified via mail');

    }
    public function process(){
        $candidate=Candidate::find(\request('candidate'));
        $user=$candidate->user;
        Notification::send($user,new CandidationResult($candidate,\request('exit')));

        if (\request('exit')=='accept'){
                $user->givePermissionTo($candidate->channel->name);
                $user->assignRole('admin');
        }


        Candidate::destroy(\request('candidate'));
        return redirect('/admin/dashboard');
    }

}
