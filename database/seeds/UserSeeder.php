<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'home']);
        Role::create(['name' => 'superAdmin']);
        Role::create(['name' => 'admin']);
        \App\Reason::create(['name'=>'bad language']);
        \App\Reason::create(['name'=>'inappropriate']);
        \App\Reason::create(['name'=>'spam']);




        \App\User::create([
            'name' => 'root',
            'email' => 'admin@innova.com',
            'password' => bcrypt('toor'),
            'last_name'=>'admin',
            'email_verified_at'=>now()
        ]);
        DB::table('channels')->insert([
            'name' => 'home',
            'description'=>'this is the main channel on Innova, enjoy chatting about anything you want'
        ]);
        \App\User::find(1)->channels()->attach(1);
        \App\User::find(1)->assignRole('superAdmin');
        \App\User::find(1)->assignRole('admin');

    }
}
