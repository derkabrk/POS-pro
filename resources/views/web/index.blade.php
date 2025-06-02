@extends('layouts.web.master')

@section('title')
    {{ __(env('APP_NAME')) }}
@endsection

@section('content')
    <!-- start hero section -->
    <section class="section pb-0 hero-section" id="hero">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-sm-10">
                    <div class="text-center mt-lg-5 pt-5">
                        <h1 class="display-6 fw-semibold mb-3 lh-base">
                            {{ $page_data['headings']['slider_title'] ?? '' }}
                            <span class="text-primary"
                                data-typer-targets='{"targets": [
                                @foreach ($page_data['headings']['silder_shop_text'] ?? [] as $key => $shop)
                                    "{{ $shop }}"@if (!$loop->last),@endif @endforeach
                            ]}'>
                            </span>
                        </h1>
                        <p class="lead text-muted lh-base">
                            {{ $page_data['headings']['slider_description'] ?? '' }}
                        </p>

                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <a href="{{ url($page_data['headings']['slider_btn1_link'] ?? '') }}" class="btn btn-primary">
                                {{ $page_data['headings']['slider_btn1'] ?? '' }} <i class="ri-arrow-right-line align-middle ms-1"></i>
                            </a>
                            <a href="" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#watch-video-modal">
                                {{ $page_data['headings']['slider_btn2'] ?? '' }} <i class="ri-play-line align-middle ms-1"></i>
                            </a>
                        </div>

                        <div class="mt-4 d-flex align-items-center justify-content-center gap-3">
                            <img src="{{ asset($page_data['scanner_image'] ?? 'assets/images/icons/img-upload.png') }}" 
                                 alt="" class="avatar-sm" />
                            <p class="text-muted mb-0">
                                {{ $page_data['headings']['slider_scanner_text'] ?? '' }}
                            </p>
                        </div>

                        <div class="mt-4 d-flex gap-3 justify-content-center">
                            <a href="{{ $page_data['headings']['footer_apple_app_link'] ?? '' }}" target="_blank">
                                <img src="{{ asset($page_data['footer_apple_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                     alt="App Store" height="40" />
                            </a>
                            <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}" target="_blank">
                                <img src="{{ asset($page_data['footer_google_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                     alt="Google Play" height="40" />
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                        <div class="demo-img-patten-top d-none d-sm-block">
                            <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}" 
                                 class="d-block img-fluid" alt="banner-img">
                        </div>
                        <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                <div class="carousel-item active" data-bs-interval="2000">
                                    <img src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}" 
                                         class="d-block w-100" alt="banner-img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
        <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                    <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                    </path>
                </g>
            </svg>
        </div>
        <!-- end shape -->
    </section>
    <!-- end hero section -->

    <!-- Video Modal -->
    <div class="modal fade" id="watch-video-modal" data-bs-backdrop="static" data-bs-keyboard="false"
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
    <section class="section bg-light py-5" id="features">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">{{ $page_data['headings']['interface_title'] ?? '' }}</h3>
                        <p class="text-muted mb-4 ff-secondary">
                            {{ $page_data['headings']['interface_description'] ?? '' }}
                        </p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            
            <div class="row g-3 app-slide">
                @foreach ($interfaces as $interface)
                    <div class="col-lg-4 col-md-6">
                        <div class="text-center p-3">
                            <div class="avatar-xl mx-auto mb-4">
                                <img src="{{ asset($interface->image) }}" alt="interface" class="img-fluid rounded" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    {{-- Watch demo Code Start --}}
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">{{ $page_data['headings']['watch_title'] ?? '' }}</h3>
                        <p class="text-muted mb-4 ff-secondary">
                            {{ $page_data['headings']['watch_description'] ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="position-relative text-center">
                        <img src="{{ asset($page_data['watch_image'] ?? 'assets/images/icons/img-upload.png') }}" 
                             alt="watch demo" class="img-fluid rounded shadow-lg" />
                        <a class="btn btn-primary btn-lg rounded-circle position-absolute top-50 start-50 translate-middle" 
                           data-bs-toggle="modal" data-bs-target="#play-video-modal">
                            <i class="ri-play-fill fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Play Video Modal -->
    <div class="modal fade" id="play-video-modal" data-bs-backdrop="static" data-bs-keyboard="false"
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
    <section class="section bg-primary" id="reviews">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center">
                        <div>
                            <i class="ri-double-quotes-l text-success display-3"></i>
                        </div>
                        <h4 class="text-white mb-5">{{ $page_data['headings']['testimonial_title'] ?? '' }}</h4>

                        <!-- Swiper -->
                        <div class="swiper client-review-swiper rounded customer-slider-section" dir="ltr">
                            <div class="swiper-wrapper">
                                @foreach ($testimonials as $testimonial)
                                    <div class="swiper-slide">
                                        <div class="row justify-content-center">
                                            <div class="col-10">
                                                <div class="text-white-50 text-center">
                                                    <div class="avatar-lg mx-auto mb-4">
                                                        <img src="{{ asset($testimonial->client_image) }}" 
                                                             alt="{{ $testimonial->client_name }}" 
                                                             class="img-fluid rounded-circle" />
                                                    </div>
                                                    <p class="fs-20 ff-secondary mb-4">"{{ $testimonial->text }}"</p>
                                                    <div>
                                                        <h5 class="text-white">{{ $testimonial->client_name }}</h5>
                                                        <p>- {{ $testimonial->work_at }}</p>
                                                        <div class="d-flex align-items-center justify-content-center gap-1 mt-2">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <i class="ri-star-fill text-warning"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next bg-white rounded-circle"></div>
                            <div class="swiper-button-prev bg-white rounded-circle"></div>
                            <div class="swiper-pagination position-relative mt-2"></div>
                        </div>
                        <!-- end slider -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>

    {{-- Blogs Section Code Start --}}
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">{{ $page_data['headings']['blog_title'] ?? '' }}</h3>
                        <div class="mt-4">
                            <a href="{{ url($page_data['headings']['blog_view_all_btn_link'] ?? '') }}"
                                class="btn btn-primary">
                                {{ $page_data['headings']['blog_view_all_btn_text'] ?? '' }}<i class="ri-arrow-right-line align-middle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('web.components.blog')
        </div>
    </section>

    @include('web.components.signup')
@endsection

@push('js')
    <script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush