@extends('layouts.auth.app')

@section('title')
    {{ __('Login') }}
@endsection

@section('main_content')
<div class="footer">
    <div class="footer-logo w-100 mx-4">
        <img src="{{ asset('assets/images/login/loginlogo.png') }}" alt="">
    </div>
    <div class="mybazar-login-section">
        <div class="mybazar-login-avatar">
            <img src="{{ asset('assets/images/login/login.png') }}" alt="">
        </div>
        <div class="mybazar-login-wrapper">
            <div class="login-wrapper">
                <div class="login-body w-100">
                    <h2>{{ __('Welcome to') }}<span> {{ get_option('general')['title'] ?? env("APP_NAME") }}</span></h2>
                    <h6>{{ __('Welcome back, Please login in to your account') }}</h6>

                    <form method="POST" action="{{ route('register') }}" class="ajaxform_instant_reload">
                        @csrf

                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/user.png') }}" alt="img"></span>
                            <input type="text" name="name" class="form-control" placeholder="{{ __('Enter your name') }}">
                        </div>

                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/user.png') }}" alt="img"></span>
                            <input type="email" name="email" class="form-control email" placeholder="{{ __('Enter your Email') }}">
                        </div>

                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/user.png') }}" alt="img"></span>
                            <input type="text" name="phone" class="form-control" placeholder="{{ __('Enter your phone number') }}">
                        </div>

                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/lock.png') }}" alt="img"></span>
                            <span class="hide-pass">
                                <img src="{{ asset('assets/images/icons/Hide.svg') }}" alt="img">
                                <img src="{{ asset('assets/images/icons/show.svg') }}" alt="img">
                            </span>
                            <input type="password" name="password" class="form-control password" placeholder="{{ __('Password') }}">
                        </div>

                        <button type="submit" class="btn login-btn submit-btn">{{ __('Register') }}</button>
                        <a href="{{ route('login') }}" class="mt-1 d-block">{{ __("Already have an account?") }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <input type="hidden" data-model="Login" id="auth">
@endsection

@push('js')
<script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush



