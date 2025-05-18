@extends('layouts.auth.app')

@section('title')
    {{ __('Login') }}
@endsection

@section('main_content')
<div class="footer" style="display: flex; flex-direction: row;">
    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: space-between; height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fb; padding: 40px 20px; box-sizing: border-box;">
        <!-- Top Logo -->
        <div style="align-self: flex-start;">
            <img src="{{ asset(get_option('general')['login_page_logo'] ?? '') }}" alt="Logo" style="height: 40px;">
        </div>
        <!-- Onboarding Slider -->
        <div id="onboarding-slider" style="flex-grow: 1; display: flex; align-items: center; justify-content: center; width: 100%; position: relative; min-height: 320px;">
            <div class="onboarding-slide active" style="display: flex; flex-direction: column; align-items: center; transition: opacity 0.5s;">
                <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=facearea&w=400&h=400" alt="Step 1" style="width: 120px; height: 120px; border-radius: 16px; box-shadow: 0 2px 12px #0001; object-fit: cover; margin-bottom: 1.2rem;">
                <div style="font-weight: bold; font-size: 1.2rem; color: #222;">{{ __('Step 1: Sign In') }}</div>
                <div style="color: #666; font-size: 1rem; text-align: center; max-width: 260px;">{{ __('Access your account securely with your credentials.') }}</div>
            </div>
            <div class="onboarding-slide" style="display: none; flex-direction: column; align-items: center; transition: opacity 0.5s; position: absolute; left: 0; right: 0;">
                <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=facearea&w=400&h=400" alt="Step 2" style="width: 120px; height: 120px; border-radius: 16px; box-shadow: 0 2px 12px #0001; object-fit: cover; margin-bottom: 1.2rem;">
                <div style="font-weight: bold; font-size: 1.2rem; color: #222;">{{ __('Step 2: Explore Features') }}</div>
                <div style="color: #666; font-size: 1rem; text-align: center; max-width: 260px;">{{ __('Discover powerful tools to manage your business.') }}</div>
            </div>
            <div class="onboarding-slide" style="display: none; flex-direction: column; align-items: center; transition: opacity 0.5s; position: absolute; left: 0; right: 0;">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=facearea&w=400&h=400" alt="Step 3" style="width: 120px; height: 120px; border-radius: 16px; box-shadow: 0 2px 12px #0001; object-fit: cover; margin-bottom: 1.2rem;">
                <div style="font-weight: bold; font-size: 1.2rem; color: #222;">{{ __('Step 3: Grow & Succeed') }}</div>
                <div style="color: #666; font-size: 1rem; text-align: center; max-width: 260px;">{{ __('Track your progress and grow your business with ease!') }}</div>
            </div>
            <!-- Slider Controls -->
            <button id="onboarding-prev" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 2rem; color: #bbb; cursor: pointer; z-index: 2;">&#8592;</button>
            <button id="onboarding-next" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 2rem; color: #bbb; cursor: pointer; z-index: 2;">&#8594;</button>
        </div>
        <!-- Dots for onboarding steps -->
        <div style="margin-top: 20px; text-align: center;">
            <span class="onboarding-dot active" style="height: 8px; width: 8px; margin: 0 3px; background-color: #007bff; border-radius: 50%; display: inline-block; transition: background 0.3s;"></span>
            <span class="onboarding-dot" style="height: 8px; width: 8px; margin: 0 3px; background-color: #ccc; border-radius: 50%; display: inline-block; transition: background 0.3s;"></span>
            <span class="onboarding-dot" style="height: 8px; width: 8px; margin: 0 3px; background-color: #ccc; border-radius: 50%; display: inline-block; transition: background 0.3s;"></span>
        </div>
        <!-- Footer -->
        <div style="margin-top: auto; font-size: 13px; color: #777;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
    <div class="mybazar-login-section" style="flex: 1;">
        <div class="mybazar-login-avatar">
            <img src="{{ asset(get_option('general')['login_page_image'] ?? 'assets/images/login/login.png') }}" alt="">
        </div>
        <div class="mybazar-login-wrapper">
            <div class="login-wrapper">
                <div class="login-body w-100">
                    <h2>{{ __('Welcome to') }}<span>{{ __(env('APP_NAME')) }}</span></h2>
                    <h6>{{ __('Welcome back, Please login in to your account') }}</h6>
                    <form method="POST" action="{{ route('login') }}" class="login_form">
                        @csrf
                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/user.png') }}" alt="img"></span>
                            <input type="email" name="email" class="form-control email" placeholder="{{ __('Enter your Email') }}">
                        </div>
                        <div class="input-group">
                            <span><img src="{{ asset('assets/images/icons/lock.png') }}" alt="img"></span>
                            <span class="hide-pass">
                                <img src="{{ asset('assets/images/icons/Hide.svg') }}" alt="img">
                                <img src="{{ asset('assets/images/icons/show.svg') }}" alt="img">
                            </span>
                            <input type="password" name="password" class="form-control password" placeholder="{{ __('Password') }}">
                        </div>
                        <div class="mt-lg-3 mb-0 forget-password">
                            <label class="custom-control-label">
                                <input type="checkbox" name="remember" class="custom-control-input">
                                <span>{{ __('Remember me') }}</span>
                            </label>
                            <a href="{{ route('password.request') }}">{{ ('Forgot Password?') }}</a>
                        </div>
                        <button type="submit" class="btn login-btn submit-btn">{{ __('Log In') }}</button>
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

(function() {
    const slides = document.querySelectorAll('.onboarding-slide');
    const dots = document.querySelectorAll('.onboarding-dot');
    let current = 0;
    function showSlide(idx) {
        slides.forEach((slide, i) => {
            slide.style.display = i === idx ? 'flex' : 'none';
            if (i === idx) slide.classList.add('active');
            else slide.classList.remove('active');
        });
        dots.forEach((dot, i) => {
            dot.style.backgroundColor = i === idx ? '#007bff' : '#ccc';
            if (i === idx) dot.classList.add('active');
            else dot.classList.remove('active');
        });
    }
    document.getElementById('onboarding-prev').onclick = function() {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    };
    document.getElementById('onboarding-next').onclick = function() {
        current = (current + 1) % slides.length;
        showSlide(current);
    };
    dots.forEach((dot, i) => {
        dot.onclick = function() {
            current = i;
            showSlide(current);
        };
    });
    showSlide(current);
})();
</script>
@endpush



