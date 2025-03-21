@extends('layouts.web.master')

@section('title')
    {{ __('About Us') }}
@endsection

@section('main_content')
<section class="banner-bg p-4">
        <div class="container">
            <p class="mb-0 fw-bolder custom-clr-dark">
                {{ __('Home') }} <span class="font-monospace">></span> {{ __('About Us') }}
            </p>
        </div>
    </section>

    {{-- About Code Start --}}

    <section class="about-section">
        <div class="container">
          <div class="row mb-3">
            <div class="col-lg-6 align-self-center">
              <div>
                <h6>
                  <span class="custom-clr-primary">{{ $page_data['headings']['about_short_title'] ?? '' }}</span>
                </h6>
                <h2 class="mb-3">{{ $page_data['headings']['about_title'] ?? '' }}</h2>
                <p>
                    {{ $page_data['headings']['about_desc_one'] ?? '' }}
                </p>
              </div>
            </div>
            <div class="col-lg-6 align-self-center">
              <div class="w-90 position-relative ms-auto">
                <img
                  src="{{ asset($page_data['about_image'] ?? 'assets/images/icons/img-upload.png') }}"
                  alt="image"
                  class="about-img"
                />
              </div>
            </div>
          </div>
          <p>
            {{ $page_data['headings']['about_desc_two'] ?? '' }}
          </p>
          <ul>
            @foreach ($page_data['headings']['about_us_options_text'] ?? [] as $key => $about_us_options_text)
            <li>{{ $about_us_options_text ?? '' }}</li>
            @endforeach
          </ul>
        </div>
</section>

      {{-- Feature section Start Here --}}

      @include('web.components.feature')

      {{-- Pricing Plan --}}
      @include('web.components.plan')

@endsection
