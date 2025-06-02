@extends('layouts.web.master')

@section('title')
    {{ __('Blog') }}
@endsection

@section('content')
<!-- Enhanced Hero Section -->
<section class="section pb-0 hero-section bg-primary bg-opacity-10 position-relative" id="hero">
    <div class="bg-overlay bg-overlay-pattern opacity-25"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mt-4 pt-4 pb-2">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb mb-0 bg-transparent p-0 justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="/" class="text-decoration-none text-primary fw-medium">
                                    <i class="ri-home-4-line me-1"></i>{{ __('Home') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">
                                {{ __('Blog List') }}
                            </li>
                        </ol>
                    </nav>
                    
                    <div class="avatar-sm icon-effect mx-auto mb-4">
                        <div class="avatar-title bg-transparent rounded-circle text-primary h1">
                            <i class="ri-article-line fs-36"></i>
                        </div>
                    </div>
                    
                    <h1 class="display-6 fw-semibold mb-3 lh-base">
                        Our Latest <span class="text-primary">Insights</span>
                    </h1>
                    <p class="lead text-muted lh-base ff-secondary">
                        Stay updated with our latest thoughts, tutorials, and industry insights
                    </p>
                </div>
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

<!-- Enhanced Blog Section -->
<section class="section bg-light py-5">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="text-center">
                    <h3 class="mb-3 fw-semibold">Featured Articles</h3>
                    <p class="text-muted mb-4 ff-secondary">
                        Discover our collection of articles covering various topics and insights
                    </p>
                </div>
            </div>
        </div>
        
        @include('web.components.blog')
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary position-relative bg-opacity-50">
    <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <div class="avatar-sm icon-effect mx-auto mb-4">
                        <div class="avatar-title bg-transparent rounded-circle text-white h1">
                            <i class="ri-mail-line fs-24"></i>
                        </div>
                    </div>
                    <h4 class="text-white mb-3 fw-semibold">Stay Updated</h4>
                    <p class="text-white-50 mb-4">Subscribe to our newsletter and never miss our latest articles</p>
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <form class="d-flex gap-2">
                                <input type="email" class="form-control bg-white border-0" placeholder="Enter your email">
                                <button type="submit" class="btn btn-light">
                                    <i class="ri-send-plane-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
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

// Add fade-in animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe blog cards when they come into view
document.addEventListener('DOMContentLoaded', function() {
    const blogCards = document.querySelectorAll('.blog-card, .card');
    blogCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection