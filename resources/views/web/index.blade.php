@extends('layouts.web.master')

@section('title')
    {{ __(env('APP_NAME')) }}
@endsection

@section('content')
    <section class="home-banner-section">
        <div class="container">
            <div class="row align-items-center pb-5 py-lg-5">
                <div class="col-lg-6 order-2 order-lg-1 mt-5 mt-lg-0">
                    <div class="banner-content">
                        <h1>
                            {{ $page_data['headings']['slider_title'] ?? '' }}
                            <span
                                data-typer-targets='{"targets": [
                                @foreach ($page_data['headings']['silder_shop_text'] ?? [] as $key => $shop)
                                    "{{ $shop }}"@if (!$loop->last),@endif @endforeach
                            ]}'>
                            </span>
                        </h1>
                        <p>
                            {{ $page_data['headings']['slider_description'] ?? '' }}
                        </p>
                        <div class="demo-btn-group mb-3">
                            <a href="{{ url($page_data['headings']['slider_btn1_link'] ?? '') }}"
                                class="btn btn-primary custom-primary-btn px-4 fw-semibold">
                                {{ $page_data['headings']['slider_btn1'] ?? '' }}<i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <a href="" class="mt-1 video-button d-flex align-items-center gap-2"
                                data-bs-toggle="modal" data-bs-target="#watch-video-modal">
                                <span class="play-button"></span>
                                <span class="text-white ms-3">{{ $page_data['headings']['slider_btn2'] ?? '' }}</span>
                            </a>
                        </div>
                        <div class="banner-scan mt-3">
                            <img src="{{ asset($page_data['scanner_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                alt="" class="rounded-4 shadow-sm bg-white p-2" style="max-width: 120px;" />
                            <p class="mt-2 text-secondary small">
                                {{ $page_data['headings']['slider_scanner_text'] ?? '' }}
                            </p>
                        </div>
                        <div class="play-store mt-3 d-flex gap-2">
                            <a href="{{ $page_data['headings']['footer_apple_app_link'] ?? '' }}" target="_blank">
                                <img src="{{ asset($page_data['footer_apple_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                    alt="image" class="rounded-2 shadow-sm" style="max-width: 120px;" />
                            </a>
                            <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}" target="_blank">
                                <img src="{{ asset($page_data['footer_google_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                    alt="image" class="rounded-2 shadow-sm" style="max-width: 120px;" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="banner-img text-center">
                        <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="banner-img" class="move-image rounded-4 shadow-sm bg-white p-2" style="max-width: 480px;" />
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
    <section class="slick-slider-section bg-pos py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['interface_title'] ?? '' }}</h2>
                <p class="max-w-600 mx-auto section-description text-secondary">
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
    <section class="watch-demo-section watch-demo-two bg-FFFFFF py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['watch_title'] ?? '' }}</h2>
                <p class="section-description text-secondary">
                    {{ $page_data['headings']['watch_description'] ?? '' }}
                </p>
            </div>
            <div class="video-wrapper shadow rounded-4 overflow-hidden bg-white p-2">
                <img src="{{ asset($page_data['watch_image'] ?? 'assets/images/icons/img-upload.png') }}" alt="watch" class="img-fluid w-100 rounded-4" style="max-height: 340px; object-fit: cover;" />
                <a class="play-btn" data-bs-toggle="modal" data-bs-target="#play-video-modal"><i class="fa fa-play" aria-hidden="true"></i></a>
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
    <section class="customer-section bg-pos py-5">
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
                                <p class="text-secondary">{{ $testimonial->text }}</p>
                                <div class="w-100 pt-3 d-flex align-items-center flex-column border-top">
                                    <h5 class="m-0 fw-bold custom-clr-dark">{{ $testimonial->client_name }}</h5>
                                    <small class="text-muted">{{ $testimonial->work_at }}</small>
                                    <ul class="d-flex align-items-center justify-content-center gap-2 list-unstyled mb-0 mt-2">
                                        @for ($i = 0; $i < 5; $i++)
                                            <li><i class="fa fa-star text-warning" aria-hidden="true"></i></li>
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
    <section class="blogs-section py-5">
        <div class="container">
            <div class="section-title d-flex align-items-center justify-content-between flex-wrap mb-4">
                <h2 class="fw-bold custom-clr-dark mb-0">{{ $page_data['headings']['blog_title'] ?? '' }}</h2>
                <a href="{{ url($page_data['headings']['blog_view_all_btn_link'] ?? '') }}"
                    class="btn btn-outline-primary custom-outline-btn bg-white px-4 fw-semibold">
                    {{ $page_data['headings']['blog_view_all_btn_text'] ?? '' }}<i class="fas fa-arrow-right ms-1"></i>
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
