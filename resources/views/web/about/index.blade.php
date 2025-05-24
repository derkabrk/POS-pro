@extends('layouts.web.master')

@section('title')
    {{ __('About Us') }}
@endsection

@section('content')
<section class="banner-bg p-4 bg-primary bg-opacity-10 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none custom-clr-primary">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item active custom-clr-dark" aria-current="page">{{ __('About Us') }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center mb-4 g-4">
            <div class="col-lg-6">
                <div>
                    <h6 class="text-uppercase fw-bold custom-clr-primary mb-2">
                        {{ $page_data['headings']['about_short_title'] ?? '' }}
                    </h6>
                    <h2 class="mb-3 fw-bolder custom-clr-dark">{{ $page_data['headings']['about_title'] ?? '' }}</h2>
                    <p class="lead text-muted mb-4">
                        {{ $page_data['headings']['about_desc_one'] ?? '' }}
                    </p>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative d-inline-block rounded-4 overflow-hidden shadow-sm bg-white p-2">
                    <img
                        src="{{ asset($page_data['about_image'] ?? 'assets/images/icons/img-upload.png') }}"
                        alt="image"
                        class="img-fluid rounded-4 about-img"
                        style="max-width: 420px; min-height: 220px; object-fit: cover; background: #f8f9fa;"
                    />
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-10 mx-auto">
                <p class="fs-5 text-secondary mb-3">
                    {{ $page_data['headings']['about_desc_two'] ?? '' }}
                </p>
                <ul class="list-group list-group-flush mb-4">
                    @foreach ($page_data['headings']['about_us_options_text'] ?? [] as $key => $about_us_options_text)
                        <li class="list-group-item bg-transparent ps-0 border-0 d-flex align-items-center">
                            <i class="ri-checkbox-circle-line text-success me-2"></i>
                            <span class="fw-semibold custom-clr-dark">{{ $about_us_options_text ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

@include('web.components.feature')
@include('web.components.plan')

@endsection
