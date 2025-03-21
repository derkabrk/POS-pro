@extends('layouts.web.master')

@section('title')
    {{ __('Plan') }}
@endsection

@section('main_content')
<section class="banner-bg p-4">
    <div class="container">
      <p class="mb-0 fw-bolder custom-clr-dark">
        {{ __('Home') }} <span class="font-monospace">></span> {{ __('Pricing Plan') }}
      </p>
    </div>
</section>

@include('web.components.plan')
@include('web.components.signup')

@endsection
