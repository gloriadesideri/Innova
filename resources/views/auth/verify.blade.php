@extends('layouts.app')

@section('content')
<div class="flex w-full h-screen justify-center align-center">
    {{--<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>--}}
    <section class="py-24 px-4 text-center grid  grid-cols-1 lg:grid-cols-3 items-center justify-center font-nunito">
        <div class="col-auto lg:col-start-2 bg-white shadow-2xl rounded p-6">
            @if (session('resent'))
            <h2 class="font-serif text-3xl text-red-500 md:text-4xl font-normal mb-6 md:mb-6 leading-tight tracking-tight">{{ __('A fresh verification link has been sent to your email address.') }}</h2>
            @endif
                <p class="text-primary font-semibold text-base mb-2">{{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},</p>

                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn p-4 rounded bg-red-500 text-white hover:bg-white hover:text-red-500 btn-primary btn-lg w-full sm:w-auto shadow-xl">{{ __('click here to request another') }}</button>.
                </form>

        </div>
    </section>
</div>
@endsection
