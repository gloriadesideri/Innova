@extends('layouts.app')

@section('content')
    <div class="container  align-items-center flex justify-content-between">
<div class=" col background h-screen w-2/3 ">
    <div class="row justify-content-center  w-3/4">

        <div class="card-header font-nunito text-3xl ml-16 mb-16 mt-3">{{ __('Login') }}</div>


        <div class="card font-nunito ml-16 rounded w-3/4">

                <div class="card-body rounded">
                        <div class="w-full max-w-lg rounded" >
                            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('login') }}">
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
                                <div class="mb-6">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                        {{ __('Password') }}
                                    </label>
                                    <input autocomplete="current-password" required name='password' class="shadow appearance-none border @error('password')border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                                    @error('password')
                                    <p class="text-red-500 text-xs italic" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>



                                <div class="flex items-center justify-between">
                                    <button type='submit' class="bg-red-500 hover:bg-white hover:text-red-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-4" type="button">
                                        {{ __('Login') }}
                                    </button>
                                    <label class="md:w-2/3 block text-gray-500 font-bold" for="remember">
                                        <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="text-sm">
                                             {{ __('Remember Me') }}
                                        </span>
                                    </label>
                                    @if (Route::has('password.request'))
                                        <a class="inline-block align-baseline font-bold text-sm text-red-500 hover:text-red-800" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                </div>
            </div>

    </div>


</div>
        <div class="col h-screen w-1/3 reg-col">
            <p><a class="font-nunito text-3xl ml-16 text-black hover:underline "  href="{{ route('register') }}">Registrati</a></p>
        </div>
    </div>
@endsection
@push('styles')
    <link  href="{{ URL::asset('css/login.css') }}" rel="stylesheet">
    @endpush
