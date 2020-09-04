@extends('layouts.app')

@section('content')
{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
<div class="container  align-items-center flex justify-content-between">
    <div class=" col background h-screen w-2/3 ">
        <div class="row justify-content-center  w-3/4">

            <div class="card-header font-nunito text-3xl ml-16 mb-16 mt-3">{{ __('Confirm Password') }}</div>


            <div class="card font-nunito ml-16 rounded w-3/4">

                <div class="card-body rounded">
                    <div class="w-full max-w-lg rounded" >
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('password.confirm') }}">
                            @csrf
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
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password-confirm">
                                    {{ __('Confirm Password') }}
                                </label>
                                <input autocomplete="new-password" id="password-confirm" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="password_confirmation" type="password" placeholder="******************">

                            </div>
                            <div class="flex items-center justify-between">
                                <button type='submit' class="bg-red-500 hover:bg-white hover:text-red-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-4" type="button">
                                    {{ __('Confirm Password') }}
                                </button>

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
