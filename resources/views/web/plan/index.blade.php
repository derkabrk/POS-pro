@extends('layouts.web.master')

@section('title')
    {{ __('Plan') }}
@endsection

@section('content')
<section class="banner-bg p-4 bg-primary bg-opacity-10 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none custom-clr-primary">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active custom-clr-dark" aria-current="page">{{ __('Pricing Plan') }}</li>
            </ol>
        </nav>
    </div>
</section>

@include('web.components.plan')
@include('web.components.signup')

@endsection
