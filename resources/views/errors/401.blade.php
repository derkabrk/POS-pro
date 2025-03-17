@extends('layouts.error-blank')

@section('title')
    {{ __('Unauthorized') }}
@endsection

@section('main_content')
    <div class="error-page-content">
        <img src="{{ asset('assets/images/errors/unauthorized-img.svg') }}" alt="401"/>
        <h4>{{ __('Unauthorized') }}</h4>
        <p>{{ __('You are not authorized to access this page') }}</p>
        <a href="{{ url('/') }}">
            <svg
                width="25"
                height="25"
                viewBox="0 0 25 25"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M19.4062 12.2969H5.40625"
                    stroke="#C52127"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path
                    d="M12.4062 19.2969L5.40625 12.2969L12.4062 5.29688"
                    stroke="#C52127"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
            {{ __('Back to Home') }}
        </a>
    </div>
@endsection
