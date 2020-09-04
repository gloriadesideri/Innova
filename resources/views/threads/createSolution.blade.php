@extends('layouts.app')
@section('content')
    <form class="w-full max-w-lg" action="{{'/store/'.Request::path()}}" method="POST">
        @csrf
        <div class="flex flex-wrap -mx-3 mb-6 font-nunito">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                    condividi la tua soluzione
                </label>

                <textarea  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" name="body" placeholder="Testo"></textarea>
                @error('body')
                <p class="text-red-500 text-xs italic">Niente post muti ci spiace</p>
                @enderror
                <button class="flex-shrink-0 bg-red-500 hover:bg-red-500 border-red-500 hover:border-red-500 text-sm border-4 text-white py-1 px-2 rounded" >
                    Condividi
                </button>

            </div>
        </div>
    </form>
@endsection
@prepend('channel-scripts')
    <script type="text/javascript" src="{{ URL::asset('js/posts.js') }}" defer></script>
@endprepend
