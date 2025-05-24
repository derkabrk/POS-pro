@extends('layouts.web.master')

@section('title')
    {{ __(env('APP_NAME')) }}
@endsection

@section('content')
    <section class="home-banner-section bg-custom-primary bg-opacity-10 py-5">
        <div class="container">
            <div class="row align-items-center pb-5 py-lg-5">
                <div class="col-lg-6 order-2 order-lg-1 mt-5 mt-lg-0">
                    <div class="banner-content">
                        <h1 class="fw-bold display-3 custom-clr-dark mb-4 lh-sm">
                            {{ $page_data['headings']['slider_title'] ?? '' }}
                            <span class="d-block mt-3 fs-2 fw-medium text-primary"
                                data-typer-targets='{"targets": [
                                @foreach ($page_data['headings']['silder_shop_text'] ?? [] as $key => $shop)
                                    "{{ $shop }}"@if (!$loop->last),@endif @endforeach
                            ]}'>
                            </span>
                        </h1>
                        <p class="lead custom-clr-secondary mb-4 fs-5">
                            {{ $page_data['headings']['slider_description'] ?? '' }}
                        </p>
                        <div class="demo-btn-group mb-4 d-flex gap-3 flex-wrap">
                            <a href="{{ url($page_data['headings']['slider_btn1_link'] ?? '') }}"
                                class="btn btn-lg btn-primary custom-primary-btn px-5 py-2 fw-semibold shadow rounded-pill">
                                {{ $page_data['headings']['slider_btn1'] ?? '' }}<i class="ri-arrow-right-line ms-2"></i>
                            </a>
                            <a href="#" class="btn btn-lg btn-outline-light d-flex align-items-center gap-2 px-4 py-2 rounded-pill border-2"
                                data-bs-toggle="modal" data-bs-target="#watch-video-modal">
                                <span class="play-button bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="ri-play-fill text-white fs-5"></i></span>
                                <span class="custom-clr-light ms-2 fs-6">{{ $page_data['headings']['slider_btn2'] ?? '' }}</span>
                            </a>
                        </div>
                        <div class="banner-scan mt-4">
                            <img src="{{ asset($page_data['scanner_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                alt="" class="rounded-4 shadow-sm bg-white p-2 mb-2" style="max-width: 120px;" />
                            <p class="mt-2 custom-clr-secondary small fw-medium">
                                {{ $page_data['headings']['slider_scanner_text'] ?? '' }}
                            </p>
                        </div>
                        <div class="play-store mt-4 d-flex gap-3">
                            <a href="{{ $page_data['headings']['footer_apple_app_link'] ?? '' }}" target="_blank">
                                <img src="{{ asset($page_data['footer_apple_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                    alt="Apple App" class="rounded-2 shadow-sm bg-white p-2" style="max-width: 120px;" />
                            </a>
                            <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}" target="_blank">
                                <img src="{{ asset($page_data['footer_google_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                    alt="Google Play" class="rounded-2 shadow-sm bg-white p-2" style="max-width: 120px;" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="banner-img text-center">
                        <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="banner-img" class="move-image rounded-4 shadow bg-white p-3" style="max-width: 480px;" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal modal-custom-design" id="watch-video-modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe width="100%" height="400px" src="{{ $page_data['headings']['slider_btn2_link'] ?? '' }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Feature Code Start --}}
    @include('web.components.feature')

    {{-- Interface Code Start --}}
    <section class="slick-slider-section bg-custom-light py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['interface_title'] ?? '' }}</h2>
                <p class="max-w-600 mx-auto section-description custom-clr-secondary">
                    {{ $page_data['headings']['interface_description'] ?? '' }}
                </p>
            </div>
            <div class="row app-slide">
                @foreach ($interfaces as $interface)
                    <div class="image d-flex align-items-center justify-content-center p-2">
                        <img src="{{ asset($interface->image) }}" alt="phone" class="rounded-4 shadow-sm bg-white p-2" style="max-width: 180px;" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Watch demo Code Start --}}
    <section class="watch-demo-section watch-demo-two bg-custom-light py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['watch_title'] ?? '' }}</h2>
                <p class="section-description custom-clr-secondary">
                    {{ $page_data['headings']['watch_description'] ?? '' }}
                </p>
            </div>
            <div class="video-wrapper shadow rounded-4 overflow-hidden bg-white p-2">
                <img src="{{ asset($page_data['watch_image'] ?? 'assets/images/icons/img-upload.png') }}" alt="watch" class="img-fluid w-100 rounded-4" style="max-height: 340px; object-fit: cover;" />
                <a class="play-btn" data-bs-toggle="modal" data-bs-target="#play-video-modal"><i class="ri-play-fill" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>

    <div class="modal modal-custom-design" id="play-video-modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe width="100%" height="400px" src="{{ $page_data['headings']['watch_btn_link'] ?? '' }}"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Pricing-Plan-section demo Code Start --}}
    @include('web.components.plan')

    {{-- Testimonial Section Start --}}
    <section class="customer-section bg-custom-light py-5">
        <div class="container mb-4">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['testimonial_title'] ?? '' }}</h2>
            </div>
            <div class="customer-slider-section">
                <div class="row">
                    @foreach ($testimonials as $testimonial)
                        <div>
                            <div class="customer-card rounded-4 shadow-sm bg-white p-4">
                                <img src="{{ asset($testimonial->client_image) }}" alt="" class="rounded-circle mb-3" style="width: 70px; height: 70px; object-fit: cover;" />
                                <p class="custom-clr-secondary">{{ $testimonial->text }}</p>
                                <div class="w-100 pt-3 d-flex align-items-center flex-column border-top">
                                    <h5 class="m-0 fw-bold custom-clr-dark">{{ $testimonial->client_name }}</h5>
                                    <small class="custom-clr-light">{{ $testimonial->work_at }}</small>
                                    <ul class="d-flex align-items-center justify-content-center gap-2 list-unstyled mb-0 mt-2">
                                        @for ($i = 0; $i < 5; $i++)
                                            <li><i class="ri-star-fill custom-clr-warning" aria-hidden="true"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Blogs Section Code Start --}}
    <section class="blogs-section py-5 bg-custom-light">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between flex-wrap mb-4">
                <h2 class="fw-bold custom-clr-dark mb-0">{{ $page_data['headings']['blog_title'] ?? '' }}</h2>
                <a href="{{ url($page_data['headings']['blog_view_all_btn_link'] ?? '') }}"
                    class="btn btn-outline-primary custom-outline-btn bg-white px-4 fw-semibold">
                    {{ $page_data['headings']['blog_view_all_btn_text'] ?? '' }}<i class="ri-arrow-right-line ms-1"></i>
                </a>
            </div>
        </div>
        @include('web.components.blog')
    </section>

    @include('web.components.signup')
@endsection

@push('js')
    <script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush
