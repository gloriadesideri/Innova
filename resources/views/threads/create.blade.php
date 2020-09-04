@extends('layouts.app')
@section('content')
    <div class="flex mb-4 gap-4">
        <div class="mx-3 w-2/3 ">
            <div class=" font-nunito w-full text-3xl text-red-500 mb-5 mt-3">New Thread</div>

            <form class="w-full  shadow-2xl  rounded py-3 bg-white" action="{{'/store/'.Request::path()}}" method="POST">
                @csrf
                <div class="flex flex-wrap  -mx-3 mb-6  font-nunito justify-center ">

                    <div class="w-11/12  px-3">
                        <div class="w-full">
                            <div class="w-8/12">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-title">
                                    Title
                                </label>
                                <input  required value="{{ old('title') }}" class="appearance-none block w-full bg-gray-200 text-gray-700 border @error('title')border-red-500 @enderror  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-title" name="title" placeholder="Title"/>
                                @error('title')
                                <p class="text-red-500 text-xs italic">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-body" >
                            Body
                        </label>
                        <textarea  required class="appearance-none block w-full   bg-gray-200 text-gray-700 border @error('body')border-red-500 @enderror  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-body" name="body" placeholder="Body">{{old('body')}}</textarea>
                        @error('body')
                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                        @enderror

                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-tag">
                            Arguments
                        </label>

                        <div id="tag-output"></div>
                        @error('tags')
                        <p class="text-red-500 text-xs italic">{{$message}}</p>
                        @enderror
                        <input  id='tag-input' class="appearance-none block w-full bg-gray-200 text-gray-700 border @error('tags')border-red-500 @enderror  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"  placeholder="Arguments"/>
                        <input  id='tag-value'   style="display: none" name="tags" placeholder="Tags"/>


                        <button class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white py-1 px-2 rounded" >
                            Share
                        </button>

                    </div>
                </div>
            </form>

        </div>
        <div class="w-1/3 mr-3">

            <div class=" font-nunito w-full text-3xl mr-3 text-black mb-5 mt-3">Instructions</div>

            <div class=" flex flex-col ml-3 shadow-2xl rounded py-3 px-3 bg-white font-nunito">
                <div class="mb-2">
                <div class="font-weight-bold text-black ">Describe your problem</div>
                <p class="ml-1">Describe your problem in a detailed way, specify what you are expecting and what the result actually is</p>
                </div>
                <div class="mb-2">
                    <div class="font-weight-bold">Tell wath you tried</div>
                    <p class="ml-1 ">If you already tried some solutions please explain providing the outcome</p>
                </div>

            </div>
        </div>

        </div>

    </div>
@endsection
@prepend('channel-scripts')
    <script type="text/javascript" src="{{ URL::asset('js/threads.js') }}" defer></script>
@endprepend
