@extends('layouts.app')

@section('content')
<div class="flex mb-4 gap-4">
   <div class="w-1/4 font-nunito">
       @can('edit-profile',$user)
           <div class=" font-nunito w-full text-3xl ml-3 text-black mb-5 mt-3">Notifications</div>


       @foreach($user->notifications as $notification)
               <div class="flex max-w-xs w-3/4 m-2 bg-white shadow-md rounded-lg overflow-hidden mx-auto">
                   <div class="w-2 {{$notification->read_at ? 'bg-gray-800' : 'bg-red-500'}}"></div>

                   <div class="flex items-center px-2 py-3">
                       <img class="w-10 h-10 object-cover rounded-full" alt="User avatar" src="{{!\App\User::find($notification->data['user_id'])->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.\App\User::find($notification->data['user_id'])->image->url)}}">

                       <div class="mx-3">
                           <p class="text-gray-600"><a class="text-blue-500 hover:text-blue-400 hover:underline" href="/{{$notification->data['user_id']}}/profile">{{$notification->data['user_name']}} </a>{{$notification->data['text']}}<a href="{{$notification->data['action']}}" onclick="{{$notification->markAsRead()}}" class="text-blue-500 hover:text-blue-400 hover:underline"> view</a>.</p>
                       </div>
                   </div>
               </div>
           @endforeach

       @endcan
   </div>
    <div class="w-1/2 font-nunito">
        <!-- component -->
        <div class="py-6 w-full">
            <div class="flex  bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="w-1/3 rounded mt-3">
                <img class= " rounded-full bg-cover" src="{{!$user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$user->image->url)}}">
                </div>
                <div class="w-2/3 p-4">
                    <h1 class="text-gray-900 font-bold text-2xl">{{$user->name.' '.$user->last_name}}</h1>
                    <p class="mt-2 text-gray-600 text-sm">{{$user->email}}</p>
                    <p class="mt-2 text-gray-600 text-sm">Joined: {{$user->created_at}}</p>

                    <div class="flex item-center justify-center mt-3">
                        <h1 class="text-gray-700 font-bold text-xl mr-3">{{count($user->posts)}} post{{count($user->posts)>1 ? 's' :''}}</h1>
                        @can('edit-profile',$user)
                        <form action="/{{$user->id}}/image" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="avatar">
                        <button class="px-3 mt-2 py-2 bg-red-500 text-white text-xs font-bold uppercase rounded">Update image</button>

                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class=" font-nunito w-full text-3xl text-red-500 mb-5 mt-3">Your posts</div>

    @forelse(\Illuminate\Support\Facades\Auth::user()->posts as $post)
        <!-- post card -->
            <div class="w-full flex bg-white shadow-lg  rounded-lg mt-6 mb-2 font-nunito" id="post-{{$post->id}}"><!--horizantil margin is just for display-->

                <div class=" w-full flex items-start px-4 py-6 post-container" id="{{$post->id}}">
                    <img class="w-12 h-12 rounded-full object-cover mr-4 shadow" src="{{!$user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$user->image->url)}}" alt="avatar">
                    <div class="w-full">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900 -mt-1">{{$post->user->name.' '.$post->user->last_name}}</h2>
                        </div>
                        <p class="text-gray-700">{{$post->created_at}}</p>
                        <p class="text-gray-700 text-lg font-bold mb-0">{{$post->title}}</p>

                        <p class="mt-3 text-gray-700 text-sm">
                            {{$post->body}}
                        </p>
                        @if($post->image)
                            <div class="w-full  mr-5 h-48 bg-cover bg-no-repeat bg-center rounded " style="background-image: url({{asset('storage/'.$post->image->url)}})">

                            </div>
                        @endif

                        <div class="mt-4 flex items-center w-full">
                            <div class="flex mr-2 text-gray-700 text-sm mr-3">
                                <a href="{{'/'.$post->channel->name.'/posts/like/'.$post->id}}"><svg fill="{{\Illuminate\Support\Facades\Auth::user()->getLoveReacter()->hasReactedTo($post->getLoveReactant()) ? 'red' : 'none'}}" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg></a>
                                <span>{{$post->like_count}}</span>
                            </div>
                            @can('delete-post',$post)
                                <a href="/{{$post->channel->name}}/delete/posts/{{$post->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.083,8.25H5.917v7h1.167V8.25z M18.75,3h-5.834V1.25c0-0.323-0.262-0.583-0.582-0.583H7.667
                                                        c-0.322,0-0.583,0.261-0.583,0.583V3H1.25C0.928,3,0.667,3.261,0.667,3.583c0,0.323,0.261,0.583,0.583,0.583h1.167v14
                                                        c0,0.644,0.522,1.166,1.167,1.166h12.833c0.645,0,1.168-0.522,1.168-1.166v-14h1.166c0.322,0,0.584-0.261,0.584-0.583
                                                        C19.334,3.261,19.072,3,18.75,3z M8.25,1.833h3.5V3h-3.5V1.833z M16.416,17.584c0,0.322-0.262,0.583-0.582,0.583H4.167
                                                        c-0.322,0-0.583-0.261-0.583-0.583V4.167h12.833V17.584z M14.084,8.25h-1.168v7h1.168V8.25z M10.583,7.083H9.417v8.167h1.167V7.083
                                                        z"/>
                                    </svg></a>
                            @endcan

                            <div class="flex mr-2 text-gray-700 text-sm ">
                                <button class="comments" id="comments-{{$post->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                    </svg></button>
                            </div>
                            <div class="flex mr-2 text-gray-700 text-sm mr-4">
                                @foreach($post->tags as $tag)
                                    <span class="inline-block rounded text-white bg-red-500 px-2 py-1 text-xs font-bold mr-3"><a href="/{{$post->channel->name}}?tag={{$tag->name}}">#{{$tag->name}}</a></span>
                                @endforeach
                            </div>
                        </div>
                        <form class="w-full " action="/{{$post->channel->name}}/comment/post/{{$post->id}}" method="POST">
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
            <div class="w-full  shadow-2xl rounded py-3 px-3 bg-white comment-box hidden" id="comment-box-{{$post->id}}">
                @forelse($post->comments as $comment)
                    <div class="flex flex-wrap  -mx-3 mb-4 font-nunito  px-3 justify-start comment-container" id="{{$comment->id}}">
                        <div class="w-full">

                            <div class="w-full flex items-start">
                                <h2 class="text-xs font-semibold text-gray-900 -mt-1 mr-3">{{$comment->user->name.' '.$comment->user->last_name}}</h2>
                                <div class="flex mr-2 text-gray-700 text-sm mr-3 -mt-1">
                                    <a href="{{'/'.$post->channel->name.'/comments/like/'.$comment->id}}"><svg fill="{{\Illuminate\Support\Facades\Auth::user()->getLoveReacter()->hasReactedTo($comment->getLoveReactant()) ? 'red' : 'none'}}" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg></a>
                                    <span>{{$comment->like_count}}</span>
                                </div>
                                @can('delete-comment',$comment)
                                    <a href="/{{$post->channel->name}}/delete/post/{{$comment->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 -mt-1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.083,8.25H5.917v7h1.167V8.25z M18.75,3h-5.834V1.25c0-0.323-0.262-0.583-0.582-0.583H7.667
                                                        c-0.322,0-0.583,0.261-0.583,0.583V3H1.25C0.928,3,0.667,3.261,0.667,3.583c0,0.323,0.261,0.583,0.583,0.583h1.167v14
                                                        c0,0.644,0.522,1.166,1.167,1.166h12.833c0.645,0,1.168-0.522,1.168-1.166v-14h1.166c0.322,0,0.584-0.261,0.584-0.583
                                                        C19.334,3.261,19.072,3,18.75,3z M8.25,1.833h3.5V3h-3.5V1.833z M16.416,17.584c0,0.322-0.262,0.583-0.582,0.583H4.167
                                                        c-0.322,0-0.583-0.261-0.583-0.583V4.167h12.833V17.584z M14.084,8.25h-1.168v7h1.168V8.25z M10.583,7.083H9.417v8.167h1.167V7.083
                                                        z"/>
                                        </svg></a>
                                @endcan

                                <div class="flex mr-2 text-gray-700 text-sm -mt-1 " id="replies-{{$comment->id}}">
                                    <button><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                        </svg></button>
                                </div>
                                @can('report',$comment)
                                    <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 report-button-comment  -mt-1" id="report-comment-{{$comment->id}}" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z M13.388,9.624H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h6.775c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z"/>
                                    </svg>
                                    <div class="inline-block relative  hidden report-form mr-1" id="report-form-comment-{{$comment->id}}">
                                        <form action="/{{$post->channel->name}}/report/comment/{{$comment->id}}" method="POST">
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
                            <div class="flex mr-2 text-gray-700 text-sm -mt-1 ">
                                <form class="w-full " action="/{{$post->channel->name}}/reply/{{$comment->id}}" method="POST">
                                    @csrf
                                    <div class="flex items-center border-b border-red-500 py-1">
                                        <input name='reply-body' required class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Nice post" aria-label="Full name">
                                        <button type="submit" class="flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-xs border-4 text-white py-1 px-1 max-w-xs rounded" >
                                            Reply
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mr-3 w-full p-2 font-nunito text-xs hidden" id="replies-box-{{$comment->id}}">
                            @forelse($comment->replies as $reply)
                                <div class="flex flex-wrap   font-nunito mb-1  px-3 justify-start reply-container" id="{{$reply->id}}">
                                    <div class="w-full">

                                        <div class="w-full flex items-start">
                                            <h2 class="text-xs font-semibold text-gray-900  mr-3">{{$reply->user->name.' '.$reply->user->last_name}}</h2>
                                            <div class="flex mr-2 text-gray-700 text-sm mr-3 -mt-1">
                                                <a href="{{'/'.$post->channel->name.'/replies/like/'.$reply->id}}"><svg fill="{{\Illuminate\Support\Facades\Auth::user()->getLoveReacter()->hasReactedTo($reply->getLoveReactant()) ? 'red' : 'none'}}" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg></a>
                                                <span>{{$reply->like_count}}</span>
                                            </div>
                                            @can('delete-reply',$reply)
                                                <a href="/{{$post->channel->name}}/delete/replies/{{$reply->id}}"><svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 -mt-1" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.083,8.25H5.917v7h1.167V8.25z M18.75,3h-5.834V1.25c0-0.323-0.262-0.583-0.582-0.583H7.667
                                                        c-0.322,0-0.583,0.261-0.583,0.583V3H1.25C0.928,3,0.667,3.261,0.667,3.583c0,0.323,0.261,0.583,0.583,0.583h1.167v14
                                                        c0,0.644,0.522,1.166,1.167,1.166h12.833c0.645,0,1.168-0.522,1.168-1.166v-14h1.166c0.322,0,0.584-0.261,0.584-0.583
                                                        C19.334,3.261,19.072,3,18.75,3z M8.25,1.833h3.5V3h-3.5V1.833z M16.416,17.584c0,0.322-0.262,0.583-0.582,0.583H4.167
                                                        c-0.322,0-0.583-0.261-0.583-0.583V4.167h12.833V17.584z M14.084,8.25h-1.168v7h1.168V8.25z M10.583,7.083H9.417v8.167h1.167V7.083
                                                        z"/>
                                                    </svg></a>
                                            @endcan
                                            @can('report',$reply)
                                                <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1 report-button-comment -mt-1" id="report-reply-{{$reply->id}}" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10,1.344c-4.781,0-8.656,3.875-8.656,8.656c0,4.781,3.875,8.656,8.656,8.656c4.781,0,8.656-3.875,8.656-8.656C18.656,5.219,14.781,1.344,10,1.344z M10,17.903c-4.365,0-7.904-3.538-7.904-7.903S5.635,2.096,10,2.096S17.903,5.635,17.903,10S14.365,17.903,10,17.903z M13.388,9.624H6.613c-0.208,0-0.376,0.168-0.376,0.376s0.168,0.376,0.376,0.376h6.775c0.207,0,0.377-0.168,0.377-0.376S13.595,9.624,13.388,9.624z"/>
                                                </svg>
                                                <div class="inline-block relative  hidden report-form mr-1" id="report-form-reply-{{$reply->id}}">
                                                    <form action="/{{$post->channel->name}}/report/reply/{{$reply->id}}" method="POST">
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
                                        <p class="text-gray-700 text-xs" id="reply-{{$reply->id}}">{{$reply->body}}</p>
                                    </div></div>
                            @empty
                                <div class=" font-nunito text-sm text-red-500 mb-5 mt-3">No replies yet</div>

                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class=" font-nunito text-lg text-red-500 mb-5 mt-3">No comments yet</div>

                @endforelse
            </div>
        @empty
            <div class=" font-nunito text-3xl text-red-500 mb-5 mt-3">No posts yet</div>
        @endforelse
    </div>
    <div class="w-1/4">
        @can('edit-profile',$user)
            <div class=" font-nunito w-full  text-3xl ml-3 text-black mb-5 mt-3">Edit</div>
            <a class="inline-block font-nunito rounded bg-white shadow-2xl p-2 mb-2 align-baseline font-bold text-sm text-red-500 hover:text-red-800" href="{{ route('password.request') }}">
            Reset password
        </a>
            <form class="w-full   rounded py-3 bg-white" action="/{{\Illuminate\Support\Facades\Auth::user()->id}}/resetEmail" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap  -mx-3 mb-6 font-nunito justify-center ">

                    <div class="w-11/12 px-3">

                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-tag">
                            Change email
                        </label>
                        <input required type="email" id='tag-input' name="email" class=" block w-full bg-gray-200 text-gray-700 border @error('email')border-red-500 @enderror  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-tag" placeholder="Email"/>
                        @error('email')
                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                        @enderror

                        <button class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white py-1 px-2 rounded" >
                            Update
                        </button>

                    </div>
                </div>
            </form>
            @role('admin')
            <a class="inline-block font-nunito rounded bg-white shadow-2xl p-2 mt-2 align-baseline font-bold text-sm text-red-500 hover:text-red-800" href="/admin/dashboard">
                Admin dashboard
            </a>
            @endrole


            <a class="inline-block font-nunito rounded bg-white shadow-2xl p-2 mt-2 align-baseline font-bold text-sm text-red-500 hover:text-red-800" href="/confirm/delete">
                Delete Profile
            </a>


        @endcan
    </div>
</div>
@endsection
@prepend('channel-scripts')
    <script type="text/javascript" src="{{ URL::asset('js/posts.js') }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/replies.js') }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/comments.js') }}" defer></script>


@endprepend
@push('styles')
    <link  href="{{ URL::asset('css/feed.css') }}" rel="stylesheet">
@endpush
