@extends('layouts.master-login')
@section('title', 'Login To Hotel Dashboard')

{{-- <div class="form-check">
    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

    <label class="form-check-label" for="remember">
        {{ __('Remember Me') }}
    </label>
</div> --}}


@section('content')

<div class="login-wrapper">
    <div class="container">
        <div class="loginbox">

            <div class="login-left"> <img class="img-fluid" src="{{URL::to('assets/img/logo.png')}}" alt="Logo"> </div>
            <div class="login-right">
                <div class="login-right-wrap">
                    <h1>Login</h1>
                    <p class="account-subtitle">Access to our dashboard</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email Address') }}" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Login') }}
                            </button>

                            
                        </div>
                    </form>
                        {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a> --}}

                    <div class="text-center forgotpass"><a href="{{ route('forget-password') }}">{{ __('Forgot Your Password?') }}</a> </div>

                    <div class="login-or"> <span class="or-line"></span> <span class="span-or">or</span> </div>
                    <div class="social-login"> <span>Login with</span> <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a> </div>
                    <div class="text-center dont-have">Don’t have an account? <a href="{{route("register")}}">Register</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
