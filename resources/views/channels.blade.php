@extends('layouts.app')

@section('content')
   <div class="flex w-full h-screen align-center justify-center m-4 mx-auto p-16 sm:p-24 lg:p-48 bg-gray-200">



       <div class="relative rounded-lg block md:flex items-center mb-0 bg-gray-100 shadow-xl" style="min-height: 19rem;">

           @foreach($channels as $channel)
               @if($channel->name!='home')

           <div class=" slides-1 fade relative w-full md:w-2/5 h-full overflow-hidden rounded-t-lg md:rounded-t-none font-nunito md:rounded-l-lg" style="min-height: 19rem;">
               <div class="absolute inset-0 w-full h-full bg-red-500 opacity-75"></div>
               <div class="absolute inset-0 w-full h-full flex items-center p-2 justify-center fill-current text-white">
                   <h2 class="text-3xl hover:underline w-full "><a href="/channels/{{$channel->name}}"> {{$channel->name}}</a></h2>
               </div>
           </div>
           <div class="w-full md:w-3/5 h-full flex items-center bg-gray-100 rounded-lg slides-2 fade">
               <div class="p-12 md:pr-24 md:pl-16 md:py-12">
                   <p class="text-gray-600"><span class="text-gray-900 hover:underline"><a href="/channels/{{$channel->name}}"> {{$channel->name}}</a></span> {{$channel->description}}</p>
                   @if($user->isSubscribed($channel->id))

                           <form method="POST" action="/{{$channel->id}}/unsubscribe">
                               @csrf
                               <button type="submit" class="flex items-baseline mt-3 text-indigo-600 hover:text-indigo-900 focus:text-indigo-900"><span>Unsubscribe</span>
                                   <span class="text-xs ml-1">&#x279c;</span></button>
                           </form>
                       @else
                       <form method="POST" action="/{{$channel->id}}/subscribe">
                           @csrf
                           <button type="submit" class="flex items-baseline mt-3 text-indigo-600 hover:text-indigo-900 focus:text-indigo-900"><span>Subscribe</span>
                               <span class="text-xs ml-1">&#x279c;</span></button>
                       </form>
                       @endif
               </div>
               <svg class="hidden md:block absolute inset-y-0 h-full w-24 fill-current text-gray-100 -ml-12" viewBox="0 0 100 100" preserveAspectRatio="none">
                   <polygon points="50,0 100,0 50,100 0,100" />
               </svg>
           </div>

               @endif
           @endforeach


           <button onclick="plusSlides(-1)" class="absolute top-0 mt-32 left-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl text-indigo-600 hover:text-indigo-400 focus:text-indigo-400 -ml-6 focus:outline-none focus:shadow-outline" >
               <span class="block" style="transform: scale(-1);">&#x279c;</span>
           </button>
           <button onclick="plusSlides(1)" class="absolute top-0 mt-32 right-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl text-indigo-600 hover:text-indigo-400 focus:text-indigo-400 -mr-6 focus:outline-none focus:shadow-outline">
               <span class="block" style="transform: scale(1);">&#x279c;</span>
           </button>
       </div>
   </div>

   <div class="flex flex-col  mt-0 items-center justify-center bg-gray-200 py-6">

   @if(session()->has('message'))
       <div class="alert flex flex-row items-center bg-green-200 p-5 rounded border-b-2 font-nunito border-green-300">
           <div class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
				<span class="text-green-500">
					<svg fill="currentColor"
                         viewBox="0 0 20 20"
                         class="h-6 w-6">
						<path fill-rule="evenodd"
                              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                              clip-rule="evenodd"></path>
					</svg>
				</span>
           </div>
           <div class="alert-content ml-4">
               <div class="alert-title font-semibold text-lg text-green-800">
                   Subscribed
               </div>
               <div class="alert-description text-sm text-green-600">
                   {{session('message')}}
               </div>
           </div>
       </div>
   @elseif(session()->has('error'))

       <div class="alert flex flex-row items-center bg-red-200 p-5 rounded border-b-2 border-red-300 font-nunito">
           <div class="alert-icon flex items-center bg-red-100 border-2 border-red-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
				<span class="text-red-500">
					<svg fill="currentColor"
                         viewBox="0 0 20 20"
                         class="h-6 w-6">
						<path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
					</svg>
				</span>
           </div>
           <div class="alert-content ml-4">
               <div class="alert-title font-semibold text-lg text-red-800">
                   Unsubscribed
               </div>
               <div class="alert-description text-sm text-red-600">
                   {{session('error')}}
               </div>
           </div>
       </div>
   @endif
       </div>

@endsection
@push('styles')
    <link  href="{{ URL::asset('css/channels.css') }}" rel="stylesheet">
@endpush
@prepend('channel-scripts')
    <script type="text/javascript" src="{{ URL::asset('js/channels.js') }}" defer></script>

@endprepend
