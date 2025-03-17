@extends('layouts.web.master')

@section('title')
    {{ __('Policy') }}
@endsection

@section('main_content')
    <section class="banner-bg p-4">
        <div class="container">
            <p class="mb-0 fw-bolder custom-clr-dark">
                {{ __('Home') }} <span class="font-monospace">></span> {{ __('Privacy Policy') }}
            </p>
        </div>
    </section>

    <section class="terms-policy-section">
        <div class="container">
            <h2>{{ $privacy_policy->value['privacy_title'] ?? ''}}</h2>
            <div>
                <p>{{ $privacy_policy->value['description_one'] ?? ''}}</p>
            </div>
            <div class="mt-3">
                <p>{{ $privacy_policy->value['description_two'] ?? ''}}</p>
            </div>
        </div>
    </section>
@endsection
