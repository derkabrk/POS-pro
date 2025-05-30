@extends('layouts.error-blank')

@section('title')
    {{ __('Access Denied') }}
@endsection

@section('content')
    <div class="error-page-content">
        <img src="{{ asset('assets/images/errors/denied.svg') }}" alt="403"/>
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
                    stroke="#8c68cd"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
                <path
                    d="M12.4062 19.2969L5.40625 12.2969L12.4062 5.29688"
                    stroke="#8c68cd"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
            {{ __('Back to Home') }}
        </a>
    </div>
@endsection
