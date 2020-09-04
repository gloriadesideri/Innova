<?php

namespace App\Providers;

use App\Policies\ThreadPolicy;
use App\Thread;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
        Thread::class=>ThreadPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superAdmin') ? true : null;
        });

        Gate::define('delete-post',function ($user,$post){

            $permission=$post->channel->name;
            try {
                return $user->hasPermissionTo($permission) || $user->id==$post->user_id;
            }
            catch (PermissionDoesNotExist $e){
                return ($user->id==$post->user_id);

            }

        });
        Gate::define('delete-comment',function ($user,$comment){
            $permission=$comment->commentable->channel->name;
            try {
                return $user->hasPermissionTo($permission) ||$user->id == $comment->user_id ;
            }
            catch (PermissionDoesNotExist $e) {
                return $user->id == $comment->user_id;
            }
        });

        Gate::define('delete-reply',function ($user,$reply){
            $permission=$reply->comment->commentable->channel->name;
            try {
                return $user->hasPermissionTo($permission) ||$user->id == $reply->user_id;
            }
            catch (PermissionDoesNotExist $e) {
                return $user->id == $reply->user_id;
            }

        });
        Gate::define('delete-solution',function ($user,$solution){
            $permission=$solution->channel->name;
            try {
                return $user->hasPermissionTo($permission) ||$user->id == $solution->user_id;
            }
            catch (PermissionDoesNotExist $e) {
                return $user->id == $solution->user_id;
            }

        });
        Gate::define('pin-post',function ($user,$post){
            $permission=$post->channel->name;
            try {
                return $user->hasPermissionTo($permission);
            }
            catch (PermissionDoesNotExist $e) {
                return false;
            }

        });


        Gate::define('report', function ($user,$model){
            return $model->user_id!=$user->id;
        });

        Gate::define('edit-profile',function ($user,$viewer){
            return $user->id==$viewer->id;
        });


        //
    }
}
