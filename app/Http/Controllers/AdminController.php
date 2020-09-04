<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Notifications\NewChannel;
use App\Notifications\NewSection;
use App\Report;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard(){
            $report=[];
            foreach (Auth::user()->permissions as $permission){
                $reports=Report::where('channel',$permission->name)->get();
                if(!empty($reports->all())) {
                    array_push($report, $reports);
                }
            }
        return view('administration.dashboard',['reports'=>$report]);
    }
    public function newAdmin(){
        $this->validateAdmin();
        $user=User::where('email',\request('email'))->first();
        if(!$user){
            return redirect('/admin/dashboard')->withErrors('email','user not found');
        }
        $channel=Channel::where('name',\request('channel'))->first();
        if(!$channel){
            return redirect('/admin/dashboard')->withErrors('channel','channel not found');

        }
        $user->assignRole('admin');


        if(DB::table('permissions')->where('name',\request('channel'))->first()==null){

            $permission=Permission::create(['name'=>\request('channel')]);

        }
        $user->givePermissionTo(\request('channel'));


        return redirect('/admin/dashboard')->with('message','admin created');

    }
    public function newChannel(){
        $this->validateChannel();
        if(!DB::table('channels')->where('name',\request('channel-create'))->first()){
            $channel=new Channel();
            $channel->name=\request('channel-create');
            $channel->description=\request('desc');
            $channel->save();
            $permission=Permission::create(['name'=>\request('channel-create')]);
            $users=User::all();
            \Illuminate\Support\Facades\Notification::send($users,new NewChannel($channel));

            return redirect('/admin/dashboard');

        }
        return view('administration.dashboard')->withErrors('channel-create','channel already exists');
    }
    public function validateAdmin(){
        return \request()->validate([
            'email'=>['required','min:2','max:255','email'],
            'channel'=>['required'],

        ]);
    }
    public function downgrade(){
        $user=User::find(\request('user'));
        $permission=Permission::find(\request('permission'));
        $user->revokePermissionTo($permission);
        if(empty($user->getDirectPermissions()->all())) {
            $user->syncRoles('');
        }
        return redirect('/admin/dashboard');

    }
    public function newSection(){
        $this->validateSection();
        $section=Section::where('name',\request('section'))->first();
        if($section!=null){
            return redirect('/admin/dashboard')->withErrors('section','section already exists');

        }
        else{

            $section=new Section();
            $section->name=\request('section');
            $channel=Channel::where('name',\request('for-channel'))->first();
            if(!$channel){
                return view('administration.dashboard')->withErrors('for-channel','channel not found');

            }
            $section->channel_id=$channel->id;
            $section->save();
            $users=$channel->users;
            \Illuminate\Support\Facades\Notification::send($users,new NewSection($section));
            return redirect('/admin/dashboard');
        }



    }
    public function deleteChannel(){
        $channel=Channel::find(\request('channel'));
        $permission=Permission::findByName($channel->name);
        $permission->delete();
        Channel::destroy(\request('channel'));


        return redirect('/admin/dashboard');
    }
    public function deleteSection(){
        $section=Section::find(\request('section'));

        $section->delete();

        return redirect('/admin/dashboard');
    }
    public function validateChannel(){
        return \request()->validate([

            'channel-create'=>['required','min:5','max:30'],
            'desc'=>['required','min:5','max:255']

        ]);
    }

    public function validateSection(){
        return \request()->validate([

            'section'=>['required','min:1','max:30'],
            'for-channel'=>['required']

        ]);
    }
}

