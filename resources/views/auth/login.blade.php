@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1a2233 0%, #28416e 100%) fixed;
        background-repeat: no-repeat;
        min-height: 100vh;
    }
    .card {
        background: #22325a;
        color: #fff;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 2px 16px rgba(40,65,110,0.15);
    }
    .card-header {
        background: #28416e;
        color: #fff;
        border-bottom: none;
        font-weight: bold;
        font-size: 1.25rem;
        border-radius: 1rem 1rem 0 0;
    }
    .form-control {
        background: #1a2233;
        color: #fff;
        border: 1px solid #28416e;
    }
    .form-control:focus {
        background: #22325a;
        color: #fff;
        border-color: #4b6fae;
        box-shadow: 0 0 0 0.2rem rgba(40,65,110,0.15);
    }
    .form-check-input:checked {
        background-color: #28416e;
        border-color: #28416e;
    }
    .btn-primary {
        background-color: #28416e;
        border-color: #28416e;
        color: #fff;
        font-weight: 600;
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: #3a5a99;
        border-color: #3a5a99;
        color: #fff;
    }
    .btn-link {
        color: #4b6fae;
    }
    .btn-link:hover, .btn-link:focus {
        color: #28416e;
        text-decoration: underline;
    }
    .invalid-feedback {
        color: #ffb3b3;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
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
</div>
@endsection
