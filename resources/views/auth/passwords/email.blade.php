@extends('layouts.master-login')
@section('title', 'Forgot Password')

@section('content')


<div class="login-wrapper">
    <div class="container">
        <div class="loginbox">
            <div class="login-left"> <img class="img-fluid" src="{{URL::to('assets/img/logo.png')}}" alt="Logo"> </div>
            <div class="login-right">
                <div class="login-right-wrap">
                    <h1>Forgot Password?</h1>
                    <p class="account-subtitle">Enter your email to get a password reset link</p>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="/forget-password">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email"  placeholder="{{ __('Email Address') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn-primary btn-block" type="submit">{{ __('Send Password Reset Link') }}</button>
                        </div>
                    </form>
                    <div class="text-center dont-have">Remember your password? <a href="{{route('login')}}">Login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
