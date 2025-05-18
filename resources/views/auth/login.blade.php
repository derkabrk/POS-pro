@extends('layouts.auth.app')

@section('title')
    {{ __('Login') }}
@endsection

@section('main_content')
<div style="display: flex; height: 100vh; font-family: 'Segoe UI', sans-serif; background: linear-gradient(to right, #1d366f, #17316b); overflow: hidden;">
    <!-- Onboarding Left Side -->
    <div style="flex: 1; background: #f5f7fb; padding: 40px; display: flex; flex-direction: column; justify-content: space-between; border-radius: 20px 0 0 20px; position: relative;">
        <!-- Logo -->
        <div>
            <img src="{{ asset(get_option('general')['login_page_logo'] ?? '') }}" alt="Logo" style="height: 40px;">
        </div>
        <!-- Slides -->
        <div id="onboarding-wrapper" style="flex-grow: 1; display: flex; align-items: center; justify-content: center;">
            <div class="onboarding-slide active" style="text-align: center;">
                <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=facearea&w=600&h=400" style="max-height: 340px; width: 100%; border-radius: 18px; box-shadow: 0 2px 12px #0001; object-fit: cover;" alt="Step 1">
                <blockquote style="font-style: italic; color: #fff; margin-top: 20px;">
                    {{ __('Cách tốt nhất để dự đoán tương lai là tạo ra nó.') }}
                </blockquote>
                <div style="font-weight: bold; color: #ccc;">Peter Drucker</div>
            </div>
            <div class="onboarding-slide" style="text-align: center; display: none;">
                <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=facearea&w=600&h=400" style="max-height: 340px; width: 100%; border-radius: 18px; box-shadow: 0 2px 12px #0001; object-fit: cover;" alt="Step 2">
                <blockquote style="font-style: italic; color: #fff; margin-top: 20px;">
                    {{ __('Thành công không phải là điểm đến, mà là hành trình.') }}
                </blockquote>
                <div style="font-weight: bold; color: #ccc;">Zig Ziglar</div>
            </div>
            <div class="onboarding-slide" style="text-align: center; display: none;">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=facearea&w=600&h=400" style="max-height: 340px; width: 100%; border-radius: 18px; box-shadow: 0 2px 12px #0001; object-fit: cover;" alt="Step 3">
                <blockquote style="font-style: italic; color: #fff; margin-top: 20px;">
                    {{ __('Khách hàng là trung tâm của mọi quyết định.') }}
                </blockquote>
                <div style="font-weight: bold; color: #ccc;">Jeff Bezos</div>
            </div>
        </div>
        <!-- Navigation Dots -->
        <div style="text-align: center; margin-top: 10px;">
            <span class="onboarding-dot active" style="height: 6px; width: 6px; margin: 3px; background: #555; border-radius: 50%; display: inline-block;"></span>
            <span class="onboarding-dot" style="height: 6px; width: 6px; margin: 3px; background: #ccc; border-radius: 50%; display: inline-block;"></span>
            <span class="onboarding-dot" style="height: 6px; width: 6px; margin: 3px; background: #ccc; border-radius: 50%; display: inline-block;"></span>
        </div>
        <!-- Footer -->
        <div style="text-align: center; font-size: 12px; color: #777;">
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</div>
    </div>
    <!-- Login Form Right Side -->
    <div style="flex: 1; background: linear-gradient(135deg, #232526 0%, #414345 100%); padding: 50px 40px; display: flex; align-items: center; justify-content: center; border-radius: 0 20px 20px 0; position: relative;">
        <div style="width: 100%; max-width: 500px; background: rgba(255,255,255,0.92); border-radius: 16px; box-shadow: 0 2px 12px #0001; padding: 32px 28px;">
            <div style="position: absolute; top: 20px; right: 30px;">
                <img src="{{ asset('assets/images/flags/vn.png') }}" alt="Language" style="width: 24px; height: 24px;">
            </div>
            <h3 style="font-weight: bold; color: #153e90;">{{ __('Getfly xin chào') }}</h3>
            <p style="margin-bottom: 25px;">Truy cập bằng tài khoản được cung cấp</p>
            <form method="POST" action="{{ route('login') }}" class="login_form">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text"><img src="{{ asset('assets/images/icons/user.png') }}" alt="img"></span>
                    <input type="email" name="email" class="form-control email" placeholder="{{ __('Enter your Email') }}" style="border: 1px solid #e5e5e5; background: #f9f9f9; border-radius: 6px; padding: 10px 12px;">
                </div>
                <div class="input-group mb-3 position-relative">
                    <span class="input-group-text"><img src="{{ asset('assets/images/icons/lock.png') }}" alt="img"></span>
                    <input type="password" name="password" class="form-control password" placeholder="{{ __('Password') }}" style="border: 1px solid #e5e5e5; background: #f9f9f9; border-radius: 6px; padding: 10px 12px;">
                    <span class="hide-pass" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                        <img src="{{ asset('assets/images/icons/Hide.svg') }}" alt="img" class="hide-icon" style="display: block;">
                        <img src="{{ asset('assets/images/icons/show.svg') }}" alt="img" class="show-icon" style="display: none;">
                    </span>
                </div>
                <div class="mt-lg-3 mb-0 forget-password">
                    <label class="custom-control-label">
                        <input type="checkbox" name="remember" class="custom-control-input">
                        <span>{{ __('Remember me') }}</span>
                    </label>
                    <a href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                </div>
                <button type="submit" class="btn login-btn submit-btn" style="background: #153e90; color: #fff; border-radius: 6px; border: none; padding: 10px 0; font-weight: 600; width: 100%; margin-top: 18px;">{{ __('Log In') }}</button>
                <div class="row d-flex flex-wrap mt-2 justify-content-between">
                    <div class="col">
                        <a href="{{ route('home') }}">{{ __('Back to Home') }}</a>
                    </div>
                    <div class="col text-end">
                        <a class="text-primary" href="" data-bs-target="#registration-modal" data-bs-toggle="modal">{{ __('Create an account.') }}</a>
                    </div>
                </div>
                <div class="social-login mt-4">
                    <div style="text-align:center; color:#aaa; margin-bottom:10px;">{{ __('Or login with') }}</div>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ url('auth/redirect/google') }}" class="btn btn-light border" style="min-width:44px;">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" alt="Google" style="height:24px; width:24px;">
                        </a>
                        <a href="{{ url('auth/redirect/facebook') }}" class="btn btn-light border" style="min-width:44px;">
                            <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/facebook/facebook-original.svg" alt="Facebook" style="height:24px; width:24px;">
                        </a>
                        <a href="{{ url('auth/redirect/x') }}" class="btn btn-light border" style="min-width:44px;">
                            <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/x.svg" alt="X" style="height:24px; width:24px;">
                        </a>
                    </div>
                </div>
            </form>
            <script>
            // Password show/hide toggle
            const passInput = document.querySelector('.form-control.password');
            const hidePass = document.querySelector('.hide-pass');
            const hideIcon = hidePass.querySelector('.hide-icon');
            const showIcon = hidePass.querySelector('.show-icon');
            hidePass.addEventListener('click', function() {
                if (passInput.type === 'password') {
                    passInput.type = 'text';
                    hideIcon.style.display = 'none';
                    showIcon.style.display = 'block';
                } else {
                    passInput.type = 'password';
                    hideIcon.style.display = 'block';
                    showIcon.style.display = 'none';
                }
            });
            </script>
        </div>
    </div>
</div>
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
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.onboarding-slide');
    const dots = document.querySelectorAll('.onboarding-dot');
    let current = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
            dots[i].style.background = i === index ? '#555' : '#ccc';
            dots[i].classList.toggle('active', i === index);
        });
    }

    setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 4000);

    showSlide(current);
});

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



