@extends('layouts.web.master')

@section('title')
    {{ __('Blog') }}
@endsection

@section('main_content')
<section class="banner-bg p-4">
    <div class="container">
        <p class="mb-0 fw-medium custom-clr-dark">
            {{ __('Home') }} <span class="font-monospace">></span> {{ __('Blog List') }}
        </p>
    </div>
</section>


@include('web.components.blog')

@endsection
