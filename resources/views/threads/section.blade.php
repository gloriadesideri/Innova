@extends('layouts.app')
@section('content')
    <div class="flex mb-4 gap-4">
        <div class="w-1/4 " >
            <div class=" font-nunito w-full text-3xl ml-3 text-black mb-5 mt-3">Your channels</div>

            <ul class=" list-reset flex flex-col ml-3 shadow-2xl rounded py-3 px-3 bg-white font-nunito">
                @forelse(\Illuminate\Support\Facades\Auth::user()->channels as $channel)
                    <li class=" rounded-t relative -mb-px block border border-red-500 text-red-500  p-4 "><a href="/channels/{{$channel->name}}">{{$channel->name}}</a></li>
                @empty
                    <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">No comments yet, go subscribe!</div>
                @endforelse
            </ul>
        </div>
        <div class="  w-1/2 ">

            <div class="flex w-full">
                <div class="max-w-sm mr-2">
                        <button class="bg-red-400 hover:bg-red-300 mr-1 rounded text-white p-2 pl-4 pr-4 max-w-sm font-weight-bold font-nunito"><a href="/{{$section->channel->name}}/{{$section->name}}/createThread">New Thread</a></button>
                    </div>
                    <div class="bg-white shadow p-4 flex rounded w-full font-nunito">
                <form method="GET" action="/{{$section->channel->name}}/{{$section->name}}/threads">
                <input class="w-full rounded p-2" type="text" name="search" placeholder="Try {{$section->name}}">
                <button class="bg-red-400 hover:bg-red-300 rounded text-white p-2 pl-4 pr-4">
                    <p class="font-semibold text-xs">Search</p>
                </button>
                </form>
            </div>
            </div>
        @forelse($threads as $thread)
                <div class="shadow  bg-white mt-3 font-nunito flex " id="thread-{{$thread->id}}">
                    <div class="flex max-w-sm {{$thread->solved ? 'bg-green-400':''}} ">
                        <div class="{{$thread->solved ? 'border-white text-white': 'border-gray-200'}} border-3 p-3 text-lg">{{count($thread->solutions)}}</div>
                    </div>
                    <div>
                    <div class="text-left p-4 w-full">
                        <h3 class="mb-2 text-gray-700 font-weight-bold" style="text-overflow: ellipsis; overflow: hidden ; white-space: nowrap;">{{$thread->title}}</h3>
                        <p class="text-grey-600 text-sm ">{{$thread->body}}</p>
                    </div>

                        <div class="p-4">

                        @foreach($thread->arguments as $argument)
                            <span class="inline-block rounded text-white bg-red-500 px-2 py-1 text-xs font-bold mr-3"><a href="/{{$section->channel->name}}/{{$section->name}}/threads/?argument={{$argument->name}}">#{{$argument->name}}</a></span>
                        @endforeach
                        </div>
                    ​
                    <div class=" p-4">
                        <a href="/{{$channel->name}}/{{$section->name}}/threads/{{$thread->id}}" class="no-underline mr-4 text-blue-500 hover:text-blue-400">Keep reading</a>
                    </div>
                        </div>
                </div>
                    @empty
                        <div class=" font-nunito text-3xl text-red-500 mb-5 mt-3">No threads yet</div>

                    @endforelse
        </div>
        <div class="w-1/4">
            <div class=" font-nunito w-full text-3xl mr-3 text-black mb-5 mt-3">Your admins</div>

            <div class=" list-reset flex flex-col  shadow-2xl rounded py-3 px-3 bg-white font-nunito mr-3">
                @forelse(\App\User::permission($section->channel->name)->get() as $user)
                    <div class="w-full flex items-start px-4 py-6 ">
                        <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="{{!$user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$user->image->url)}}" alt="avatar">
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 -mt-1"><a href="/user/profile/{{$user->id}}">{{$user->name.' '.$user->last_name}}</a></h2>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">This channel has no admins yet</div>
                    <form action="/candidate/{{$section->channel->name}}/{{$section->channel->id}}" method="POST">
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
                @forelse($section->channel->sections as $section)
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
