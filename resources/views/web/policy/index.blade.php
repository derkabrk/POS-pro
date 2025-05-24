@extends('layouts.web.master')

@section('title')
    {{ __('Policy') }}
@endsection

@section('content')
    <section class="banner-bg p-4 bg-primary bg-opacity-10 border-bottom mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none custom-clr-primary">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active custom-clr-dark" aria-current="page">{{ __('Privacy Policy') }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="terms-policy-section py-5 bg-light bg-opacity-50">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold custom-clr-dark">{{ $privacy_policy->value['privacy_title'] ?? ''}}</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                        <div class="mb-3">
                            <p class="text-secondary mb-0">{{ $privacy_policy->value['description_one'] ?? ''}}</p>
                        </div>
                        <div class="mt-3">
                            <p class="text-secondary mb-0">{{ $privacy_policy->value['description_two'] ?? ''}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
