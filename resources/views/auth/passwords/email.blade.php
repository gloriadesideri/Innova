@extends('layouts.app')

@section('content')

<div class="container  align-items-center flex justify-content-between">
    <div class=" col background h-screen w-2/3 ">
        <div class="row justify-content-center  w-3/4">

            <div class="card-header font-nunito text-3xl ml-16 mb-16 mt-3">{{ __('Reset Password') }}</div>


            <div class="card font-nunito ml-16 rounded w-3/4">

                <div class="card-body rounded">
                    <div class="w-full max-w-lg rounded" >
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                    {{ __('E-Mail Address') }}
                                </label>
                                <input name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="shadow appearance-none border @error('email')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <div class="flex items-center justify-between">
                                <button type='submit' class="bg-red-500 hover:bg-white hover:text-red-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-4" type="button">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <div class="col h-screen w-1/3 reg-col">
        @if (session('status'))
            <div class="text-red-500 text-lg font-nunito font-italic" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>
@endsection
@push('styles')
    <link  href="{{ URL::asset('css/login.css') }}" rel="stylesheet">
@endpush
