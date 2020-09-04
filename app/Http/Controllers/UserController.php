<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Notifications\ProfileDeleted;
use App\Post;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(){
        $user=\App\User::find(\request('user'));
        $posts=Post::where('user_id',$user->id);
        return view('user.profile',['user'=>$user,'posts'=>$posts]);
    }
    public function subscribe(){
        $channel=Channel::find(\request('channel'));
        $user=Auth::user();
        $user->channels()->attach($channel->id);
        return redirect('/channels')->with('message','ti sei iscritto al canale');

    }
    public function unsubscribe(){
        $channel=Channel::find(\request('channel'));
        $user=Auth::user();
        $user->channels()->detach($channel->id);
        return redirect('/channels')->with('error','iscrizione cancellata');

    }
    public function delete(){
        $user=Auth::user();
        $user->image()->delete();
        Notification::send($user, new ProfileDeleted());
        $user->notifications()->delete();

        $user->delete();
        return redirect('/');
    }

    public function reset(){
        $this->validateEmail();
        $user=\App\User::find(\request('user'));
        $user->email=\request('email');
        $user->email_verified_at=null;
        $user->save();
        $user->sendEmailVerificationNotification();
        return redirect('email/verify');
    }
    public function image(){
        $this->validateImage();
        $user=\App\User::find(\request('user'));
        $path=\request('avatar')->store('avatars','public');

        if($user->image){
            $image=$user->image;
            $image->url=$path;
            $image->save();
        }else{
            $user->image()->create(['url'=>$path]);

        }
        return redirect('/'.$user->id.'/profile');

    }


    public function validateEmail(){
        return \request()->validate([
            'email'=>['required','email']
        ]);
    }
    public function validateImage(){
        return \request()->validate([
            'avatar'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    }
}
