@extends('layouts.auth.app')

@section('title')
    {{ __('Login') }}
@endsection

@section('content')
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
                                            <a href="{{ route('home') }}" class="d-block">
                                                <img src="{{ asset(get_option('general')['login_page_logo'] ?? 'assets/images/logo/logo.png') }}" alt="" height="32">
                                            </a>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="mb-3">
                                                <i class="ri-double-quotes-l display-4 text-success"></i>
                                            </div>
                                            <div class="carousel-inner text-center text-white pb-5">
                                                <div class="carousel-item active">
                                                    <p class="fs-15 fst-italic">" Welcome to {{ config('app.name') }}! "</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <div class="text-center mb-4">
                                        <h5 class="text-primary">{{ __('Welcome Back!') }}</h5>
                                        <p class="text-muted">{{ __('Sign in to continue to') }} {{ config('app.name') }}.</p>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}" class="login_form">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('Email') }}</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="{{ __('Enter your Email') }}" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot password?') }}</a>
                                            </div>
                                            <label class="form-label" for="password">{{ __('Password') }}</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" name="password" class="form-control pe-5 password-input" placeholder="{{ __('Enter password') }}" id="password" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">{{ __('Remember me') }}</label>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit">{{ __('Sign In') }}</button>
                                        </div>
                                    </form>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">{{ __("Don't have an account?") }}
                                            <a href="#" class="fw-semibold text-primary text-decoration-underline" data-bs-toggle="modal" data-bs-target="#registration-modal">{{ __('Signup') }}</a>
                                        </p>
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

<!-- Registration Modal -->
@include('web.components.signup')
@endsection

@push('js')
<script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush


