@extends('layouts.app')

@section('content')

    <div class="flex mb-4 gap-4">
        <div class="w-1/4 " >
            <div class=" font-nunito w-full text-3xl ml-3 text-black mb-5 mt-3">Your channels</div>

            <ul class=" list-reset flex flex-col ml-3 shadow-2xl rounded py-3 px-3 bg-white font-nunito">
                @forelse(\Illuminate\Support\Facades\Auth::user()->channels as $channel)
                    <li class=" rounded-t relative -mb-px block border border-red-500 text-red-500  p-4 "><a href="/channels/{{$channel->name}}">{{$channel->name}}</a></li>
                @empty
                    <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">No channels yet, go subscribe!</div>
                @endforelse
            </ul>
        </div>
        <div class="  w-1/2 ">
            <div class=" font-nunito w-full text-3xl text-red-500 mb-5 mt-3">{{$thread->title}}</div>
            <!-- post card -->
                <div class="w-full flex bg-white shadow-lg  rounded-lg mt-6 mb-2 font-nunito" id="thread-{{$thread->id}}"><!--horizantil margin is just for display-->

                    <div class=" w-full flex items-start px-4 py-6 post-container" id="{{$thread->id}}">

                        <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="{{!$thread->user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$thread->user->image->url)}}" alt="avatar">
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 -mt-1"><a href="/{{$thread->user->id}}/profile">{{$thread->user->name.' '.$thread->user->last_name}}</a></h2>
                            </div>
                            <p class="text-gray-700">{{$thread->created_at}}</p>

                            <p class="mt-3 text-gray-700 text-sm" id="thread-body">
                                {{$thread->body}}
                            </p>

                            <div class="mt-4 flex items-center w-full">

                                @can('delete',$thread)
                                    <a href="/{{$thread->channel->name}}/threads/delete/{{$thread->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.083,8.25H5.917v7h1.167V8.25z M18.75,3h-5.834V1.25c0-0.323-0.262-0.583-0.582-0.583H7.667
                                                        c-0.322,0-0.583,0.261-0.583,0.583V3H1.25C0.928,3,0.667,3.261,0.667,3.583c0,0.323,0.261,0.583,0.583,0.583h1.167v14
                                                        c0,0.644,0.522,1.166,1.167,1.166h12.833c0.645,0,1.168-0.522,1.168-1.166v-14h1.166c0.322,0,0.584-0.261,0.584-0.583
                                                        C19.334,3.261,19.072,3,18.75,3z M8.25,1.833h3.5V3h-3.5V1.833z M16.416,17.584c0,0.322-0.262,0.583-0.582,0.583H4.167
                                                        c-0.322,0-0.583-0.261-0.583-0.583V4.167h12.833V17.584z M14.084,8.25h-1.168v7h1.168V8.25z M10.583,7.083H9.417v8.167h1.167V7.083
                                                        z"/>
                                        </svg></a>
                                @endcan
                                    @can('update',$thread)
                                        <button class="hover:underline mx-1"><a href="/{{$thread->channel->name}}/{{$thread->id}}/edit">Edit</a> </button>
                                    @endcan


                                <div class="flex mr-2 text-gray-700 text-sm ">
                                    <button class="comments" id="comments"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                        </svg></button>
                                </div>
                                @can('report',$thread)
                                    <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 report-button " id="report-{{$thread->id}}" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z M13.388,9.624H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h6.775c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z"/>
                                    </svg>
                                    <div class="inline-block relative  hidden report-form mr-1" id="report-form-{{$thread->id}}">
                                        <form action="/{{$thread->channel->name}}/report/thread/{{$thread->id}}" method="POST">
                                            @csrf
                                            <div class="flex items-center w-full">
                                                <select class="block appearance-none mr-2 w-3/4 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-sm" name="reason">
                                                    @foreach(\App\Reason::all() as $reason)
                                                        <option value="{{$reason->id}}">{{$reason->name}}</option>

                                                    @endforeach
                                                </select>
                                                <button type='submit' class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white h-6 mr-2 py-2 px-2 rounded" >
                                                    Send
                                                </button>
                                            </div>
                                        </form>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                @endcan
                                <div class="flex mr-2 text-gray-700 text-sm mr-4">
                                    @foreach($thread->arguments as $argument)
                                        <span class="inline-block rounded text-white bg-red-500 px-2 py-1 text-xs font-bold mr-3"><a href="/{{$thread->section->name}}/threads/?argument={{$argument->name}}">#{{$argument->name}}</a></span>
                                    @endforeach
                                </div>
                            </div>
                            <form class="w-full " action="/{{$thread->channel->name}}/comment/thread/{{$thread->id}}" method="POST">
                                @csrf
                                <div class="flex items-center border-b border-red-500 py-2">
                                    <input name='comment-body' required class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Same problem, you might..." aria-label="Full name">
                                    <button type="submit" class="flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-xs border-4 text-white py-1 px-2 rounded" type="button">
                                        Comment
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form class="w-full  shadow-2xl rounded py-3 bg-white" action="{{'/'.$thread->channel->name.'/threads/solve/'.$thread->id}}" method="POST">
                    @csrf
                    <div class="flex flex-wrap  -mx-3 mb-6 font-nunito justify-center ">

                        <div class="w-11/12 px-3">

                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-body" >
                                Try to solve
                            </label>
                            <textarea  required class="appearance-none block w-full bg-gray-200 text-gray-700 border @error('solution-body')border-red-500 @enderror  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-body" name="solution-body" placeholder="Body"></textarea>
                            @error('solution-body')
                            <p class="text-red-500 text-xs italic">{{$message}}</p>
                            @enderror



                            <button class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white py-1 px-2 rounded" >
                                Try to solve
                            </button>

                        </div>
                    </div>
                </form>

            <div class="w-full  shadow-2xl rounded py-3 px-3 bg-white mt-2  hidden" id="thread-comment-box">
                    @forelse($thread->comments as $comment)
                        <div class="flex flex-wrap  -mx-3 mb-4 font-nunito  px-3 justify-start comment-container" id="{{$comment->id}}">
                            <div class="w-full">

                                <div class="w-full flex items-start">
                                    <h2 class="text-xs font-semibold text-gray-900 -mt-1 mr-3"><a href="/{{$comment->user->id}}/profile">{{$comment->user->name.' '.$comment->user->last_name}}</a></h2>

                                    @can('delete-comment',$comment)
                                        <a href="/{{$thread->channel->name}}/delete/thread/{{$comment->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 -mt-1" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.083,8.25H5.917v7h1.167V8.25z M18.75,3h-5.834V1.25c0-0.323-0.262-0.583-0.582-0.583H7.667
                                                        c-0.322,0-0.583,0.261-0.583,0.583V3H1.25C0.928,3,0.667,3.261,0.667,3.583c0,0.323,0.261,0.583,0.583,0.583h1.167v14
                                                        c0,0.644,0.522,1.166,1.167,1.166h12.833c0.645,0,1.168-0.522,1.168-1.166v-14h1.166c0.322,0,0.584-0.261,0.584-0.583
                                                        C19.334,3.261,19.072,3,18.75,3z M8.25,1.833h3.5V3h-3.5V1.833z M16.416,17.584c0,0.322-0.262,0.583-0.582,0.583H4.167
                                                        c-0.322,0-0.583-0.261-0.583-0.583V4.167h12.833V17.584z M14.084,8.25h-1.168v7h1.168V8.25z M10.583,7.083H9.417v8.167h1.167V7.083
                                                        z"/>
                                            </svg></a>
                                    @endcan


                                    @can('report',$comment)
                                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 report-button-comment  -mt-1" id="report-comment-{{$comment->id}}" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z M13.388,9.624H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h6.775c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z"/>
                                        </svg>
                                        <div class="inline-block relative  hidden report-form mr-1" id="report-form-comment-{{$comment->id}}">
                                            <form action="/{{$thread->channel->name}}/report/comment/{{$comment->id}}" method="POST">
                                                @csrf
                                                <div class="flex items-center w-full">
                                                    <select class="block appearance-none mr-2 w-3/4 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-sm" name="reason">
                                                        @foreach(\App\Reason::all() as $reason)
                                                            <option value="{{$reason->id}}">{{$reason->name}}</option>

                                                        @endforeach
                                                    </select>
                                                    <button type='submit' class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white h-6 mr-2 py-2 px-2 rounded" >
                                                        Send
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 ">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    @endcan

                                </div>
                                <p class="text-gray-700 text-xs" id="comment-{{$comment->id}}">{{$comment->body}}</p>

                            </div>
                            <div class="mr-3 w-full p-2 font-nunito text-xs hidden" id="replies-box-{{$comment->id}}">

                            </div>
                        </div>
                    @empty
                        <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">No comments yet</div>

                    @endforelse
                </div>

            @foreach($thread->solutions as $solution)
                <div class="w-full flex bg-white shadow-lg  rounded-lg mt-6 mb-2 font-nunito" id="solution-{{$solution->id}}"><!--horizantil margin is just for display-->

                    <div class=" w-full flex items-start px-4 py-6 solution-container" id="{{$solution->id}}">
                        <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="{{!$solution->user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$solution->user->image->url)}}" alt="avatar">
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 -mt-1"><a href="/{{$solution->user->id}}/profile"> {{$solution->user->name.' '.$solution->user->last_name}}</a></h2>
                                @can('solve', $thread)
                                    <button class="flex-shrink-0   {{$solution->best ?'text-white bg-green-400':'text-green-400 border-green-400'}} text-xs border-4  py-1 px-2 rounded"><a href="/{{$thread->channel->name}}/{{$solution->id}}/isBest">Best</a></button>

                                @endcan
                            </div>
                            <p class="text-gray-700">{{$solution->created_at}}</p>

                            <p class="mt-3 text-gray-700 text-sm">
                                {{$solution->body}}
                            </p>
                            <div class="mt-4 flex items-center w-full">

                                @can('delete-solution',$solution)
                                    <a href="/{{$solution->channel->name}}/solutions/delete/{{$solution->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.083,8.25H5.917v7h1.167V8.25z M18.75,3h-5.834V1.25c0-0.323-0.262-0.583-0.582-0.583H7.667
                                                        c-0.322,0-0.583,0.261-0.583,0.583V3H1.25C0.928,3,0.667,3.261,0.667,3.583c0,0.323,0.261,0.583,0.583,0.583h1.167v14
                                                        c0,0.644,0.522,1.166,1.167,1.166h12.833c0.645,0,1.168-0.522,1.168-1.166v-14h1.166c0.322,0,0.584-0.261,0.584-0.583
                                                        C19.334,3.261,19.072,3,18.75,3z M8.25,1.833h3.5V3h-3.5V1.833z M16.416,17.584c0,0.322-0.262,0.583-0.582,0.583H4.167
                                                        c-0.322,0-0.583-0.261-0.583-0.583V4.167h12.833V17.584z M14.084,8.25h-1.168v7h1.168V8.25z M10.583,7.083H9.417v8.167h1.167V7.083
                                                        z"/>
                                        </svg></a>
                                @endcan

                                <div class="flex mr-2 text-gray-700 text-sm ">
                                    <button class="comments" id="comments-{{$solution->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                        </svg></button>
                                </div>
                                @can('report',$solution)
                                    <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 report-button " id="report-solution-{{$solution->id}}" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z M13.388,9.624H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h6.775c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z"/>
                                    </svg>
                                    <div class="inline-block relative  hidden report-form mr-1" id="report-form-solution-{{$solution->id}}">
                                        <form action="/{{$thread->channel->name}}/report/solution/{{$solution->id}}" method="POST">
                                            @csrf
                                            <div class="flex items-center w-full">
                                                <select class="block appearance-none mr-2 w-3/4 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-sm" name="reason">
                                                    @foreach(\App\Reason::all() as $reason)
                                                        <option value="{{$reason->id}}">{{$reason->name}}</option>

                                                    @endforeach
                                                </select>
                                                <button type='submit' class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white h-6 mr-2 py-2 px-2 rounded" >
                                                    Send
                                                </button>
                                            </div>
                                        </form>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                        </div>
                                    </div>
                                @endcan

                            </div>
                            <form class="w-full " action="/{{$thread->channel->name}}/comment/solution/{{$solution->id}}" method="POST">
                                @csrf
                                <div class="flex items-center border-b border-red-500 py-2">
                                    <input name='comment-body' required class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Nice post" aria-label="Full name">
                                    <button type="submit" class="flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-xs border-4 text-white py-1 px-2 rounded" type="button">
                                        Comment
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="w-full  shadow-2xl rounded py-3 px-3 bg-white  hidden" id="comment-box-{{$solution->id}}">
                    @forelse($solution->comments as $comment)
                        <div class="flex flex-wrap  -mx-3 mb-4 font-nunito  px-3 justify-start comment-container" id="{{$comment->id}}">
                            <div class="w-full">

                                <div class="w-full flex items-start">
                                    <h2 class="text-xs font-semibold text-gray-900 -mt-1 mr-3"><a href="/{{$comment->user->id}}/profile"> {{$comment->user->name.' '.$comment->user->last_name}}</a></h2>

                                    @can('delete-comment',$comment)
                                        <a href="/{{$thread->channel->name}}/delete/solution/{{$comment->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 -mt-1" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.083,8.25H5.917v7h1.167V8.25z M18.75,3h-5.834V1.25c0-0.323-0.262-0.583-0.582-0.583H7.667
                                                        c-0.322,0-0.583,0.261-0.583,0.583V3H1.25C0.928,3,0.667,3.261,0.667,3.583c0,0.323,0.261,0.583,0.583,0.583h1.167v14
                                                        c0,0.644,0.522,1.166,1.167,1.166h12.833c0.645,0,1.168-0.522,1.168-1.166v-14h1.166c0.322,0,0.584-0.261,0.584-0.583
                                                        C19.334,3.261,19.072,3,18.75,3z M8.25,1.833h3.5V3h-3.5V1.833z M16.416,17.584c0,0.322-0.262,0.583-0.582,0.583H4.167
                                                        c-0.322,0-0.583-0.261-0.583-0.583V4.167h12.833V17.584z M14.084,8.25h-1.168v7h1.168V8.25z M10.583,7.083H9.417v8.167h1.167V7.083
                                                        z"/>
                                            </svg></a>
                                    @endcan
                                    @can('report',$comment)
                                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 report-button-comment  -mt-1" id="report-comment-{{$comment->id}}" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z M13.388,9.624H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h6.775c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z"/>
                                        </svg>
                                        <div class="inline-block relative  hidden report-form mr-1" id="report-form-comment-{{$comment->id}}">
                                            <form action="/{{$thread->channel->name}}/report/comment/{{$comment->id}}" method="POST">
                                                @csrf
                                                <div class="flex items-center w-full">
                                                    <select class="block appearance-none mr-2 w-3/4 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-sm" name="reason">
                                                        @foreach(\App\Reason::all() as $reason)
                                                            <option value="{{$reason->id}}">{{$reason->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type='submit' class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white h-6 mr-2 py-2 px-2 rounded" >
                                                        Send
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 ">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    @endcan

                                </div>
                                <p class="text-gray-700 text-xs" id="comment-{{$comment->id}}">{{$comment->body}}</p>
                            </div>

                        </div>
                    @empty
                        <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">No comments yet</div>

                    @endforelse
                </div>
            @endforeach


        </div>
        <div class="w-1/4">
            <div class=" font-nunito w-full text-3xl mr-3 text-black mb-5 mt-3">Your admins</div>

            <div class=" list-reset flex flex-col  shadow-2xl rounded py-3 px-3 bg-white font-nunito mr-3">
                @forelse(\App\User::permission($thread->channel->name)->get() as $user)
                    <div class="w-full flex items-start px-4 py-6 ">
                        <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="{{!$user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$user->image->url)}}" alt="avatar">
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 -mt-1"><a href="/{{$user->id}}/profile">{{$user->name.' '.$user->last_name}}</a></h2>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">This channel has no admins yet</div>
                    <form action="/candidate/{{$thread->channel->name}}/{{$thread->channel->id}}" method="POST">
                        @csrf
                        <button class="bg-red-500  text-white font-bold py-2 px-4 rounded" type="submit">Candidate</button>
                    </form>
                    @if(session()->has('candidation'))
                        <p class="text-red-500 text-xs italic">{{session('candidation')}}</p>
                    @endif
                @endforelse
            </div>

            <div class=" font-nunito w-full text-3xl mr-3 text-black mb-5 mt-3">Sections</div>

            <div class=" list-reset flex flex-col  shadow-2xl rounded py-3 px-3 bg-white font-nunito mr-3">
                @forelse($thread->channel->sections as $section)
                    <div class="w-full flex items-start px-4 py-6 ">
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 -mt-1"><a href="/{{$section->channel->name}}/{{$section->name}}/threads">{{$section->name}}</a></h2>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">There are no sections yet</div>
                @endforelse
            </div>

        </div>

    </div>


@endsection
@prepend('channel-scripts')
    <script type="text/javascript" src="{{ URL::asset('js/thread_display.js') }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/comments.js') }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/solutions.js') }}" defer></script>

@endprepend
@push('styles')
    <link  href="{{ URL::asset('css/feed.css') }}" rel="stylesheet">
@endpush
