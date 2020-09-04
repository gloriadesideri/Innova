<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $channel=Channel::where('name','home')->firstOrFail();
        return view('feed.general',['channel'=>$channel]);
    }
}
