@extends('layouts.app')

@section('content')

<div class="container  align-items-center flex justify-content-between">
    <div class=" col background h-screen w-2/3 ">
        <div class="row justify-content-center  w-3/4">

            <div class="card-header font-nunito text-3xl ml-16 mb-16 mt-3">{{ __('Register') }}</div>


            <div class="card font-nunito ml-16 rounded w-3/4">

                <div class="card-body rounded">
                    <div class="w-full max-w-lg rounded" >
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                    {{ __('Name') }}
                                </label>
                                @if(empty($name))
                                <input name="name" value="{{ old('name') }}" required autocomplete="name" autofocus class="shadow appearance-none border @error('name')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Name" >
                                @else
                                    <input name="name" value="{{$name}}" required autocomplete="name" autofocus class="shadow appearance-none border @error('name')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Name" >
                                @endif

                                    @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                                    {{ __('Last name') }}
                                </label>
                                <input name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus class="shadow appearance-none border @error('last_name')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="last_name" type="text" placeholder="Last name">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                    {{ __('E-Mail Address') }}
                                </label>
                                @if(empty($email))
                                <input name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="shadow appearance-none border @error('email')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email">
                                @else
                                    <input name="email" value="{{$email}}" required autocomplete="email" autofocus class="shadow appearance-none border @error('email')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="email">
                                @endif

                                    @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                    {{ __('Password') }}
                                </label>
                                <input autocomplete="new-password" required class="shadow appearance-none border @error('password')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name='password' id="password" type="password" placeholder="******************">
                                @error('password')
                                <p class="text-red-500 text-xs italic" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password-confirm">
                                    {{ __('Confirm Password') }}
                                </label>
                                <input autocomplete="new-password" id="password-confirm" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="password_confirmation" type="password" placeholder="******************">

                            </div>

                            <div class="flex items-center justify-between">
                                <button type='submit' class="bg-red-500 hover:bg-white hover:text-red-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-4" type="button">
                                    {{ __('Register') }}
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <div class="col h-screen w-1/3 reg-col">
        <p><a class="font-nunito text-3xl ml-16 text-black hover:underline "  href="{{ route('login') }}">Login</a></p>
    </div>
</div>
@endsection
@push('styles')
    <link  href="{{ URL::asset('css/login.css') }}" rel="stylesheet">
@endpush
