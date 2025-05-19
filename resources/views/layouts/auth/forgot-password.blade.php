@extends('layouts.auth.app', [
    'title' => __('Forget Password')
])

@section('main_content')
<div class="footer">
    <div class="footer-logo w-100 mx-4">
        <img src="{{ asset('assets/images/login/footer-logo.svg') }}" alt="">
    </div>
    <div class="mybazar-login-section">
        <div class="mybazar-login-avatar">
            <img src="{{ asset('assets/images/login/login.png') }}" alt="">
        </div>
        <div class="mybazar-login-wrapper">
            <div class="login-wrapper">
                <div class="login-header">
                    <h4>{{ get_option('general')['name'] ?? '' }}</h4>
                </div>
                <div class="login-body w-100">
                    <h2>{{ __('Forgot Password') }}</h2>
                    <h6>{{ __('Enter the email address associated with your account') }}</h6>
                    <form method="POST" action="{{ route('password.email') }}" class="ajaxform">
                        @csrf
                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/envelope.png') }}" alt="img"></span>
                            <input type="email" name="email" class="form-control" placeholder="{{ __('Enter your Email') }}">
                        </div>

                        <button type="submit" class="btn login-btn submit-btn">{{ __('Continue') }}</button>
                    </form>
                    <div class="back-to-login">
                        <img src="{{ asset('assets/images/user-img/user.png') }}" alt="img">
                        <a href="{{ route('login') }}">{{ __('Back to Login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

