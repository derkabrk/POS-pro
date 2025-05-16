
@extends('layouts.auth.app')
@section('title')
    {{ __('Login') }}
@endsection

@section('main_content')
<div class="footer">
    <div class="footer-logo w-100 mx-4">
        <img src="{{ asset(get_option('general')['login_page_logo'] ?? '') }}" alt="">
    </div>
    <div class="mybazar-login-section">
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
</script>
@endpush



<!-- auth-page wrapper -->
<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <!-- auth-page content -->
    <div class="auth-page-content overflow-hidden pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden card-bg-fill border-0 card-border-effect-none">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="p-lg-5 p-4 auth-one-bg h-100">
                                    <div class="bg-overlay"></div>
                                    <div class="position-relative h-100 d-flex flex-column">
                                        <div class="mb-4">
                                            <a href="{{ url('/') }}" class="d-block">
                                                <img src="{{ asset('build/images/logo-light.png') }}" alt="" height="32">
                                            </a>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="mb-3">
                                                <i class="ri-double-quotes-l display-4 text-success"></i>
                                            </div>
                                            <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner text-center text-white pb-5">
                                                    <div class="carousel-item active">
                                                        <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">" The theme is really great with an amazing customer support."</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <div>
                                        <h5 class="text-primary">Welcome Back!</h5>
                                        <p class="text-muted">Sign in to continue.</p>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mt-4">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required autofocus>
                                            </div>

                                            <div class="mb-3">
                                                <div class="float-end">
                                                    <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                                                </div>
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" name="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" required>
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                                                <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <div class="signin-other-title">
                                                    <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                    <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <p class="mb-0">Don't have an account? <a href="#" class="fw-semibold text-primary text-decoration-underline">Signup</a></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->
</div>
<!-- end auth-page-wrapper -->
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection
