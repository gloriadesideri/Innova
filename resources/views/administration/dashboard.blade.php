@extends('layouts.app')

@section('content')
    <div class="font-nunito">
        <div  class="flex h-screen bg-gray-200">
            <div class="flex-1 flex flex-col overflow-hidden">
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <div class="container mx-auto px-6 py-8">
                        <h3 class="text-gray-700 text-3xl font-medium">Dashboard</h3>
                        @role('superAdmin')
                        <div class="mt-4">
                            <div class="flex flex-wrap -mx-6">
                                <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                                    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                                        <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </div>

                                        <div class="mx-5">
                                            <h4 class="text-2xl font-semibold text-gray-700">{{\App\User::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')) )->count()}}</h4>
                                            <div class="text-gray-500">New Users</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
                                    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                                        <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </div>

                                        <div class="mx-5">
                                            <h4 class="text-2xl font-semibold text-gray-700">{{\App\Post::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')) )->count()}}</h4>
                                            <div class="text-gray-500">New posts</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full mt-6 px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
                                    <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                                        <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-6 w-6 text-white" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                        </div>

                                        <div class="mx-5">
                                            <h4 class="text-2xl font-semibold text-gray-700">{{\App\Thread::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')) )->count()}}</h4>
                                            <div class="text-gray-500">New threads</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="flex flex-col mt-8">
                            <h3 class="text-gray-700 text-xl font-medium">Admins</h3>

                            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                    <table class="min-w-full">
                                        <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Channel</th>
                                        </tr>
                                        </thead>

                                        <tbody class="bg-white">
                                        @foreach(\App\User::role('admin')->get() as $user)
                                            @if(!$user->hasRole('superAdmin'))
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="{{!$user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$user->image->url)}}" alt="" />
                                                            </div>

                                                            <div class="ml-4">
                                                                <div class="text-sm leading-5 font-medium text-gray-900"><a href="/{{$user->id}}/profile">{{$user->name.' '.$user->last_name}}</a></div>
                                                                <div class="text-sm leading-5 text-gray-500">{{$user->email}}</div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <div class="text-sm leading-5 text-gray-900">@foreach($user->getRoleNames() as $role) {{$role.', '}}@endforeach</div>
                                                    </td>



                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">@foreach($user->getDirectPermissions() as $permission)
                                                            <div class="tracking-wider text-white bg-red-500 px-4 py-1 text-sm flex  w-1/3 max-w-xs rounded leading-loose mx-2 font-semibold" title="">
                                                                <a href="/admin/{{$user->id}}/{{$permission->id}}/downgrade"><svg xmlns="http://www.w3.org/2000/svg" fill="none" class="text-white m-1 h-4 w-4" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg> </a> {{$permission->name}}
                                                            </div>
                                                        @endforeach</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col mt-8">
                            <h3 class="text-gray-700 text-xl font-medium">Admin candidations</h3>

                            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                    <table class="min-w-full">
                                        <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">User</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Channel</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody class="bg-white">
                                        @foreach(\App\Candidate::all() as $candidate)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="{{!$candidate->user->image ? asset('storage/avatars/no-user-image-icon-27.jpg') : asset('storage/'.$candidate->user->image->url)}}" alt="" />
                                                            </div>

                                                            <div class="ml-4">
                                                                <div class="text-sm leading-5 font-medium text-gray-900"><a href="/{{$candidate->user->id}}/profile">{{$candidate->user->name.' '.$candidate->user->last_name}}</a></div>
                                                                <div class="text-sm leading-5 text-gray-500">{{$candidate->user->email}}</div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <div class="text-sm leading-5 text-gray-900">{{$candidate->channel->name}}</div>
                                                    </td>



                                                    <td class="px-6 py-4 flex whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                                           <form method="POST" class="flex" action="/admin/process/{{$candidate->id}}">
                                                               @csrf
                                                               <div class="mt-2">
                                                                   <label class="inline-flex items-center">
                                                                       <input type="radio" class="form-radio" name="exit" value="accept">
                                                                       <span class="ml-2">Accept</span>
                                                                   </label>
                                                                   <label class="inline-flex items-center ml-6">
                                                                       <input type="radio" class="form-radio" name="exit" value="decline">
                                                                       <span class="ml-2">Decline</span>
                                                                   </label>
                                                               </div>
                                                               <button class="bg-red-500 ml-3 max-w-xs text-white font-bold py-2 px-4 rounded" type="submit">
                                                                   Process
                                                               </button>
                                                           </form>
                                                        </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col mt-8">
                            <h3 class="text-gray-700 text-xl font-medium">Channels</h3>
                            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                    <table class="min-w-full">
                                        <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Desc</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                        </tr>
                                        </thead>

                                        <tbody class="bg-white">
                                        @foreach(\App\Channel::all() as $channel)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="flex items-center">


                                                        <div class="ml-4">
                                                            <div class="text-sm leading-5 font-medium text-gray-900"><a href="/channels/{{$channel->name}}">{{$channel->name}}</a></div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="text-sm leading-5 text-gray-900" style="overflow: hidden; text-overflow: ellipsis">{{$channel->description}}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500 hover:underline hover:text-red-500"><a href="/admin/channels/{{$channel->id}}/delete">Delete</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="flex flex-col mt-8">
                            <h3 class="text-gray-700 text-xl font-medium">Sections</h3>

                            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                    <table class="min-w-full">
                                        <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Channel</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                        </tr>
                                        </thead>

                                        <tbody class="bg-white">
                                        @foreach(\App\Section::all() as $section)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="text-sm leading-5 font-medium text-gray-900"><a href="/{{$section->name}}/threads">{{$section->name}}</a></div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="text-sm leading-5 text-gray-900">{{$section->channel->name}}</div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                                    <a href="/admin/sections/{{$section->id}}/delete">Delete</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center align-center mt-4">
                            <div class="bg-white shadow-md rounded mr-4 px-8 pt-6 pb-8 mb-4 flex flex-col">
                                <form  action="/admin/newAdmin" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                                            Email
                                        </label>
                                        <input class="shadow appearance-none border @error('email') border-red-500 @enderror rounded w-full py-2 px-3 text-grey-darker" required id="email" type="text" placeholder="JohnDoe@foo.com" name="email">
                                        @error('email')
                                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="channel">
                                            Channel
                                        </label>
                                        <input required class="shadow appearance-none border @error('channel') border-red-500 @enderror  rounded w-full py-2 px-3 text-grey-darker mb-3" id="channel" placeholder="marketing" name="channel" >
                                        @error('channel')
                                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <button class="bg-red-500  text-white font-bold py-2 px-4 rounded" type="submit">
                                            New Admin
                                        </button>

                                    </div>
                                </form>
                            </div>
                            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mr-4 mb-4 flex flex-col">
                                <form  action="/admin/newChannel" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="channel-create">
                                            Name
                                        </label>
                                        <input required class="shadow appearance-none border @error('channel-create') border-red-500 @enderror rounded w-full py-2 px-3 text-grey-darker" id="channel-create" type="text" placeholder="Marketing" name="channel-create">
                                        @error('channel-create')
                                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="desc">
                                            Description
                                        </label>
                                        <input required class="shadow appearance-none border @error('desc') border-red-500 @enderror  rounded w-full py-2 px-3 text-grey-darker mb-3" id="desc" placeholder="a new channel just for you" name="desc" >
                                        @error('desc')
                                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <button class="bg-red-500  text-white font-bold py-2 px-4 rounded" type="submit">
                                            New Channel
                                        </button>

                                    </div>
                                </form>
                            </div>
                            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mr-4 mb-4 flex flex-col">
                                <form  action="/admin/newSection" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="section">
                                            Name
                                        </label>
                                        <input required class="shadow appearance-none border @error('section') border-red-500 @enderror rounded w-full py-2 px-3 text-grey-darker" id="section" type="text" placeholder="Social media" name="section">
                                        @error('section')
                                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="for-channel">
                                            For channel
                                        </label>
                                        <input required class="shadow appearance-none border @error('for-channel') border-red-500 @enderror  rounded w-full py-2 px-3 text-grey-darker mb-3" id="for-channel" placeholder="Marketing" name="for-channel" >
                                        @error('for-channel')
                                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <button class="bg-red-500  text-white font-bold py-2 px-4 rounded" type="submit">
                                            New Section
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                        @endrole
                        <div class="flex flex-col mt-8">
                            <h3 class="text-gray-700 text-xl font-medium">Reports</h3>

                            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                                    <table class="min-w-full">
                                        <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                                        </tr>
                                        </thead>

                                        <tbody class="bg-white">
                                        @forelse($reports as $report)
                                            @foreach($report->all() as $reported)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="flex items-center">

                                                        <div class="ml-4">
                                                            <div class="text-sm leading-5 font-medium text-gray-900">{{$reported->reason->name}}</div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                    <div class="text-sm leading-5 text-gray-900"><a href="{{$reported->action}}">{{trim($reported->reportable_type,'App\\')}}</a></div>
                                                </td>



                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                                    <div class="tracking-wider text-white bg-red-500 px-4 py-1 text-sm flex  w-1/3 max-w-xs rounded leading-loose mx-2 font-semibold" title="">
                                                        <form action="/admin/markAsResolved/{{$reported->id}}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="bg-red-500  text-white font-bold py-2 px-4 rounded" type="submit">Mark as resolved</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                </main>
            </div>
        </div>
    </div>




@endsection
@prepend('channel-scripts')
@endprepend
