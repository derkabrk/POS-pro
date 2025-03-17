@extends('layouts.web.master')

@section('title')
    {{ __('Term And Condition') }}
@endsection

@section('main_content')
<section class="banner-bg p-4">
    <div class="container">
      <p class="mb-0 fw-bolder custom-clr-dark">
        {{ __('Home') }} <span class="font-monospace">></span> {{ __('Terms And Conditions') }}
      </p>
    </div>
  </section>
  @include('web.components.term')

@endsection
