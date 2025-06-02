@extends('layouts.web.master')

@section('title')
    {{ __('About Us') }}
@endsection

@section('content')
<!-- Enhanced Banner Section -->
<section class="section pb-0 hero-section bg-primary bg-opacity-10 position-relative" id="hero">
    <div class="bg-overlay bg-overlay-pattern opacity-25"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="/" class="text-decoration-none text-primary fw-medium">
                                <i class="ri-home-4-line me-1"></i>{{ __('Home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">
                            {{ __('About Us') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Hero Shape -->
    <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
            <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z" fill="rgba(255,255,255,1)"></path>
            </g>
        </svg>
    </div>
</section>

<!-- Enhanced About Section -->
<section class="section py-5 bg-light position-relative">
    <div class="container">
        <div class="row align-items-center mb-5 g-4">
            <div class="col-lg-6">
                <div class="text-muted">
                    <div class="avatar-sm icon-effect mb-4">
                        <div class="avatar-title bg-transparent rounded-circle text-primary h1">
                            <i class="ri-information-line fs-36"></i>
                        </div>
                    </div>
                    <h6 class="text-uppercase fw-bold text-primary mb-2 fs-12">
                        {{ $page_data['headings']['about_short_title'] ?? 'ABOUT COMPANY' }}
                    </h6>
                    <h2 class="mb-3 fw-semibold lh-base display-6">
                        {{ $page_data['headings']['about_title'] ?? 'Learn About Our Company' }}
                    </h2>
                    <p class="lead text-muted mb-4 ff-secondary fs-16">
                        {{ $page_data['headings']['about_desc_one'] ?? 'We are a team of passionate professionals dedicated to delivering exceptional results.' }}
                    </p>
                    
                    <!-- Enhanced Features List -->
                    <div class="vstack gap-2 mb-4">
                        @foreach ($page_data['headings']['about_us_options_text'] ?? [] as $key => $about_us_options_text)
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar-xs icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                            <i class="ri-checkbox-circle-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-medium text-dark">{{ $about_us_options_text ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Call to Action Button -->
                    <div class="mt-4">
                        <a href="#features" class="btn btn-primary btn-label rounded-pill">
                            <i class="ri-arrow-right-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-sm-7 col-10 ms-auto">
                <div class="position-relative">
                    <div class="position-relative d-inline-block rounded-4 overflow-hidden shadow-lg bg-white p-3">
                        <img
                            src="{{ asset($page_data['about_image'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="About Us Image"
                            class="img-fluid rounded-4 about-img"
                            style="max-width: 100%; min-height: 300px; object-fit: cover; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"
                        />
                        
                        <!-- Floating Badge -->
                        <div class="position-absolute top-0 start-0 m-3">
                            <div class="badge bg-primary bg-opacity-90 text-white px-3 py-2 rounded-pill">
                                <i class="ri-star-fill me-1"></i>
                                Trusted Company
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="position-absolute top-0 end-0 translate-middle">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-warning rounded-circle">
                                <i class="ri-award-line fs-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Description Section -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <div class="bg-white rounded-4 p-4 p-lg-5 shadow-sm border">
                        <p class="fs-5 text-muted mb-4 ff-secondary lh-base">
                            {{ $page_data['headings']['about_desc_two'] ?? 'Our commitment to excellence drives everything we do. We believe in building lasting relationships with our clients through transparency, innovation, and exceptional service delivery.' }}
                        </p>
                        
                        <!-- Stats Row -->
                        <div class="row text-center gy-3 mt-4">
                            <div class="col-lg-3 col-6">
                                <div class="py-3">
                                    <h3 class="mb-1 text-primary"><span class="counter-value" data-target="100">100</span>+</h3>
                                    <p class="text-muted mb-0 fs-13 text-uppercase">Projects</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="py-3">
                                    <h3 class="mb-1 text-primary"><span class="counter-value" data-target="50">50</span>+</h3>
                                    <p class="text-muted mb-0 fs-13 text-uppercase">Clients</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="py-3">
                                    <h3 class="mb-1 text-primary"><span class="counter-value" data-target="24">24</span>/7</h3>
                                    <p class="text-muted mb-0 fs-13 text-uppercase">Support</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="py-3">
                                    <h3 class="mb-1 text-primary"><span class="counter-value" data-target="5">5</span>+</h3>
                                    <p class="text-muted mb-0 fs-13 text-uppercase">Years</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 bg-primary position-relative bg-opacity-50">
    <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-sm">
                <div>
                    <h4 class="text-white mb-2 fw-semibold">Ready to work with us?</h4>
                    <p class="text-white-50 mb-0">Let's discuss your project and see how we can help you achieve your goals.</p>
                </div>
            </div>
            <div class="col-sm-auto">
                <div>
                    <a href="#contact" class="btn bg-gradient btn-light">
                        <i class="ri-phone-line align-middle me-1"></i> Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Components with Enhanced Styling -->
<div id="features">
    @include('web.components.feature')
</div>

<div id="plans" class="bg-light">
    @include('web.components.plan')
</div>

@endsection

@section('script')
<script>
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter-value');
    const speed = 200;

    counters.forEach(counter => {
        const animate = () => {
            const value = +counter.getAttribute('data-target');
            const data = +counter.innerText;
            const time = value / speed;
            if (data < value) {
                counter.innerText = Math.ceil(data + time);
                setTimeout(animate, 1);
            } else {
                counter.innerText = value;
            }
        }
        animate();
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection