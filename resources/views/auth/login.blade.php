@extends('layouts.auth.app')

@section('title')
    {{ __('Login') }}
@endsection

@section('main_content')
<div class="login-page-container" style="display: flex; min-height: 100vh;">
    <div class="mybazar-login-section" style="flex: 1; display: flex; align-items: center; justify-content: center;">
        <div class="mybazar-login-wrapper" style="width: 100%; max-width: 420px; margin: 0 auto;">
            <div class="login-wrapper">
                <div class="login-body w-100">
                    <h2>{{ __('Welcome to') }} <span>{{ __(env('APP_NAME')) }}</span></h2>
                    <h6>{{ __('Welcome back, Please login in to your account') }}</h6>
                    <form method="POST" action="{{ route('login') }}" class="login_form">
                        @csrf
                        <div class="input-group" style="margin-bottom: 1.2rem;">
                            <span><img src="{{ asset('assets/images/icons/user.png') }}" alt="img"></span>
                            <input type="email" name="email" class="form-control email" placeholder="{{ __('Enter your Email') }}" style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 0.8rem 1rem; font-size: 1rem; transition: border-color 0.2s;">
                        </div>
                        <div class="input-group" style="margin-bottom: 1.2rem;">
                            <span><img src="{{ asset('assets/images/icons/lock.png') }}" alt="img"></span>
                            <span class="hide-pass">
                                <img src="{{ asset('assets/images/icons/Hide.svg') }}" alt="img">
                                <img src="{{ asset('assets/images/icons/show.svg') }}" alt="img">
                            </span>
                            <input type="password" name="password" class="form-control password" placeholder="{{ __('Password') }}" style="border: 2px solid #e0e0e0; border-radius: 8px; padding: 0.8rem 1rem; font-size: 1rem; transition: border-color 0.2s;">
                        </div>
                        <div class="mt-lg-3 mb-0 forget-password">
                            <label class="custom-control-label">
                                <input type="checkbox" name="remember" class="custom-control-input">
                                <span>{{ __('Remember me') }}</span>
                            </label>
                            <a href="{{ route('password.request') }}">{{ ('Forgot Password?') }}</a>
                        </div>
                        <button type="submit" class="btn login-btn submit-btn" style="width: 100%; font-size: 1.1rem; padding: 0.8rem 0; margin-bottom: 1.2rem;">{{ __('Log In') }}</button>
                        <div class="social-login-buttons" style="display: flex; flex-direction: column; gap: 0.7rem; margin-bottom: 1.5rem;">
                            <a href="{{ url('/auth/redirect/google') }}" class="btn btn-light" style="border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.7rem; font-size: 1rem;">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" alt="Google" style="width: 22px; height: 22px;"> {{ __('Continue with Google') }}
                            </a>
                            <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-light" style="border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.7rem; font-size: 1rem;">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/facebook/facebook-original.svg" alt="Facebook" style="width: 22px; height: 22px;"> {{ __('Continue with Facebook') }}
                            </a>
                            <a href="{{ url('/auth/redirect/x') }}" class="btn btn-light" style="border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 0.7rem; font-size: 1rem;">
                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/twitter/twitter-original.svg" alt="X" style="width: 22px; height: 22px;"> {{ __('Continue with X') }}
                            </a>
                        </div>
                        <div class="row d-flex flex-wrap mt-2 justify-content-between">
                            <div class="col">
                                <a href="{{ route('home') }}">{{ __("Back to Home") }}</a>
                            </div>
                            <div class="col text-end">
                                <a class="text-primary" href="" data-bs-target="#registration-modal" data-bs-toggle="modal">{{ __("Create an account.") }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="walkthrough-section" style="flex: 1; background: #f8f9fa; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 3rem 2rem; min-width: 350px;">
        <div class="walkthrough-step" style="display: flex; align-items: center; margin-bottom: 2.5rem;">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=facearea&w=400&h=400" alt="Step 1" style="width: 70px; height: 70px; border-radius: 16px; box-shadow: 0 2px 12px #0001; margin-right: 1.2rem; object-fit: cover;">
            <div>
                <div style="font-weight: bold; font-size: 1.2rem; color: #222;">{{ __('Step 1: Sign In') }}</div>
                <div style="color: #666; font-size: 1rem;">{{ __('Access your account securely with your credentials.') }}</div>
            </div>
        </div>
        <div class="walkthrough-step" style="display: flex; align-items: center; margin-bottom: 2.5rem;">
            <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=facearea&w=400&h=400" alt="Step 2" style="width: 70px; height: 70px; border-radius: 16px; box-shadow: 0 2px 12px #0001; margin-right: 1.2rem; object-fit: cover;">
            <div>
                <div style="font-weight: bold; font-size: 1.2rem; color: #222;">{{ __('Step 2: Explore Features') }}</div>
                <div style="color: #666; font-size: 1rem;">{{ __('Discover powerful tools to manage your business.') }}</div>
            </div>
        </div>
        <div class="walkthrough-step" style="display: flex; align-items: center;">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=facearea&w=400&h=400" alt="Step 3" style="width: 70px; height: 70px; border-radius: 16px; box-shadow: 0 2px 12px #0001; margin-right: 1.2rem; object-fit: cover;">
            <div>
                <div style="font-weight: bold; font-size: 1.2rem; color: #222;">{{ __('Step 3: Grow & Succeed') }}</div>
                <div style="color: #666; font-size: 1rem;">{{ __('Track your progress and grow your business with ease!') }}</div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" data-model="Login" id="auth">
@endsection

@push('modal')
@include('web.components.signup')

<!-- Verify Modal Start -->
<div class="modal fade" id="verifymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verify-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body verify-modal-body text-center">
                <h4 class="mb-0">{{ __('Email Verification') }}</h4>
                <p class="des p-8-0 pb-3">{{ __('We sent an OTP to your email address') }} <br>
                    <span id="dynamicEmail"></span>
                </p>
                <form action="{{ route('otp-submit') }}" method="post" class="verify_form">
                    @csrf
                    <div class="code-input pin-container">
                        <input class="pin-input otp-input" id="pin-1" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-2" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-3" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-4" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-5" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-6" type="number" name="otp[]" maxlength="1">
                    </div>
                    <p class="des p-24-0 pt-2">
                        {{ __('Code sent in') }} <span id="countdown" class="countdown"></span>
                        <span class="reset text-primary cursor-pointer" id="otp-resend"
                            data-route="{{ route('otp-resend') }}">{{ __('Resend code') }}</span>
                    </p>
                    <button class="verify-btn btn btn-outline-danger submit-btn">{{ __('Verify') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Verify Modal End -->
@endpush

@push('js')
<script src="{{ asset('assets/js/auth.js') }}"></script>
<script>
document.querySelector('.login_form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.otp_required) {
                // Trigger the OTP modal
                const otpModal = new bootstrap.Modal(document.getElementById('verifymodal'));
                otpModal.show();

                // Update the email in the modal
                document.getElementById('dynamicEmail').textContent = formData.get('email');

                // Start the countdown timer
                startCountdown();
            } else if (data.redirect) {
                // Redirect if no OTP is required
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
});

// Countdown Timer for OTP Resend
let countdownElement = document.getElementById('countdown');
let countdownTime = 60; // 60 seconds

function startCountdown() {
    countdownTime = 60; // Reset countdown time
    const interval = setInterval(() => {
        if (countdownTime <= 0) {
            clearInterval(interval);
            countdownElement.textContent = '';
            document.getElementById('otp-resend').classList.remove('disabled');
        } else {
            countdownElement.textContent = `${countdownTime--}s`;
            document.getElementById('otp-resend').classList.add('disabled');
        }
    }, 1000);
}

// Resend OTP Logic
document.getElementById('otp-resend').addEventListener('click', function () {
    const route = this.getAttribute('data-route');

    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            email: document.getElementById('dynamicEmail').textContent,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            startCountdown(); // Restart the countdown timer
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
});

// OTP Verification Logic
document.querySelector('.verify_form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.redirect) {
                // Dismiss the OTP modal
                const otpModal = bootstrap.Modal.getInstance(document.getElementById('verifymodal'));
                otpModal.hide();

                // Redirect to the dashboard
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
});
</script>
@endpush



