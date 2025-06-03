@extends('layouts.web.master')

@section('title')
    {{ __('Blog') }}
@endsection

@section('content')
<!-- Enhanced Hero Banner -->
<section class="section pb-0 hero-section bg-primary bg-opacity-10 position-relative" id="hero">
    <div class="bg-overlay bg-overlay-pattern opacity-25"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mt-4 pt-3 pb-2">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb mb-0 bg-transparent p-0 justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="/" class="text-decoration-none text-primary fw-medium">
                                    <i class="ri-home-4-line me-1"></i>{{ __('Home') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('blogs.index') }}" class="text-decoration-none text-primary fw-medium">
                                    <i class="ri-article-line me-1"></i>{{ __('Blog List') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">
                                {{ __('Blog Details') }}
                            </li>
                        </ol>
                    </nav>
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

<!-- Enhanced Blog Details Section -->
<section class="section bg-light py-5">
    <div class="container">
        <div class="row gy-4">
            <!-- Main Content -->
            <div class="col-xl-8">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden bg-white">
                    <!-- Featured Image -->
                    <div class="position-relative">
                        <img src="{{ asset($blog->image) }}" 
                             alt="{{ $blog->title }}" 
                             class="card-img-top img-fluid w-100" 
                             style="max-height: 400px; object-fit: cover;" />
                        
                        <!-- Floating Badge -->
                        <div class="position-absolute top-0 start-0 m-3">
                            <div class="badge bg-primary bg-opacity-90 text-white px-3 py-2 rounded-pill">
                                <i class="ri-calendar-line me-1"></i>
                                {{ formatted_date($blog->updated_at) }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Article Content -->
                    <div class="card-body p-4 p-lg-5">
                        <!-- Article Meta -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="avatar-xs me-2">
                                <div class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">
                                    <i class="ri-time-line fs-14"></i>
                                </div>
                            </div>
                            <small class="text-muted fw-medium">
                                Published {{ formatted_date($blog->updated_at) }}
                            </small>
                        </div>
                        
                        <!-- Article Title -->
                        <h1 class="mb-4 fw-bold text-dark lh-base">{{ $blog->title }}</h1>
                        
                        <!-- Article Content -->
                        <div class="article-content mb-5 text-muted lh-lg fs-16 ff-secondary">
                            {!! $blog->descriptions !!}
                        </div>
                        
                        <!-- Share Section -->
                        <div class="border-top pt-4 mb-5">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div>
                                    <h6 class="mb-0 text-muted">Share this article:</h6>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-sm btn-soft-primary rounded-circle">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-soft-primary rounded-circle">
                                        <i class="ri-twitter-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-soft-primary rounded-circle">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-soft-primary rounded-circle">
                                        <i class="ri-share-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comments Section -->
                        <div class="comments-section">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h4 class="mb-0 fw-semibold">
                                    <i class="ri-message-2-line text-primary me-2"></i>
                                    Comments ({{ $comments->count() }})
                                </h4>
                            </div>
                            
                            <!-- Comments List -->
                            <div class="comments-list mb-5">
                                @forelse ($comments as $comment)
                                    @include('web.blog.partials.comment', ['comment' => $comment, 'blog' => $blog])
                                @empty
                                    <div class="text-center py-5">
                                        <div class="avatar-lg mx-auto mb-3">
                                            <div class="avatar-title bg-light text-muted rounded-circle">
                                                <i class="ri-message-2-line fs-24"></i>
                                            </div>
                                        </div>
                                        <h6 class="text-muted">No comments yet</h6>
                                        <p class="text-muted mb-0">Be the first to share your thoughts!</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <!-- Comment Form -->
                            <div class="comment-form bg-white border rounded-4 p-4">
                                <h5 class="mb-3 fw-semibold">
                                    <i class="ri-edit-box-line text-primary me-2"></i>
                                    {{ __('Leave a Comment') }}
                                </h5>
                                <p class="text-muted mb-4">
                                    <i class="ri-information-line me-1"></i>
                                    {{ __('Your email address will not be published') }}
                                </p>
                                
                                <form action="{{ route('blogs.store') }}" method="post" class="form-section ajaxform_instant_reload">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                    <input type="hidden" name="blog_slug" value="{{ $blog->slug }}">
                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label for="full-name" class="form-label fw-medium">
                                                <i class="ri-user-line me-1"></i>{{ __('Full Name') }} *
                                            </label>
                                            <input type="text" name="name" class="form-control border-light bg-light" 
                                                   id="full-name" required placeholder="{{ __('Enter your name') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-medium">
                                                <i class="ri-mail-line me-1"></i>{{ __('Email') }} *
                                            </label>
                                            <input type="email" name="email" class="form-control border-light bg-light" 
                                                   id="email" required placeholder="{{ __('Enter your email') }}">
                                        </div>
                                        <div class="col-12">
                                            <label for="message" class="form-label fw-medium">
                                                <i class="ri-message-line me-1"></i>{{ __('Comment') }} *
                                            </label>
                                            <textarea class="form-control border-light bg-light" name="comment" 
                                                      id="message" rows="4" required 
                                                      placeholder="{{ __('Share your thoughts...') }}"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-label rounded-pill submit-btn">
                                            <i class="ri-send-plane-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                            {{ __('Post Comment') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-xl-4">
                <div class="sticky-sidebar">
                    <!-- Recent Posts Widget -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-header bg-primary bg-opacity-10 border-0 rounded-top-4 p-4">
                            <h5 class="mb-0 fw-semibold text-primary">
                                <i class="ri-article-line me-2"></i>{{ __('Recent Posts') }}
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @forelse ($recent_blogs as $recent_blog)
                                <div class="d-flex align-items-start mb-3 p-3 bg-light rounded-3 hover-effect">
                                    <a href="{{ route('blogs.show', $recent_blog->slug) }}" class="flex-shrink-0 me-3">
                                        <img src="{{ asset($recent_blog->image ?? '') }}" 
                                             class="rounded-2 object-fit-cover" 
                                             alt="{{ $recent_blog->title }}" 
                                             style="width: 60px; height: 60px; object-fit: cover;" />
                                    </a>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="avatar-xs me-1">
                                                <div class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">
                                                    <i class="ri-calendar-line fs-10"></i>
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ formatted_date($recent_blog->updated_at) }}</small>
                                        </div>
                                        <h6 class="mb-2 fw-medium lh-sm">
                                            <a href="{{ route('blogs.show', $recent_blog->slug) }}" 
                                               class="text-dark text-decoration-none hover-primary">
                                                {{ Str::limit($recent_blog->title, 50, '...') }}
                                            </a>
                                        </h6>
                                        <a href="{{ route('blogs.show', $recent_blog->slug) }}" 
                                           class="text-primary small text-decoration-none fw-medium">
                                            {{ __('Read More') }} 
                                            <i class="ri-arrow-right-line ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr class="my-3 opacity-25">
                                @endif
                            @empty
                                <div class="text-center py-4">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div class="avatar-title bg-light text-muted rounded-circle">
                                            <i class="ri-article-line fs-24"></i>
                                        </div>
                                    </div>
                                    <p class="text-muted mb-0">No recent posts available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Newsletter Widget -->
                    <div class="card shadow-sm border-0 rounded-4 bg-primary bg-opacity-10">
                        <div class="card-body p-4 text-center">
                            <div class="avatar-lg mx-auto mb-3">
                                <div class="avatar-title bg-primary text-white rounded-circle">
                                    <i class="ri-mail-line fs-24"></i>
                                </div>
                            </div>
                            <h5 class="mb-2 fw-semibold text-primary">Stay Updated</h5>
                            <p class="text-muted mb-3 small">
                                Subscribe to get our latest articles delivered to your inbox
                            </p>
                            <form class="d-grid gap-2">
                                <input type="email" class="form-control border-light" 
                                       placeholder="Enter your email">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="ri-send-plane-line me-1"></i>Subscribe
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // Sticky sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sticky-sidebar');
        if (sidebar) {
            const sidebarTop = sidebar.offsetTop;
            window.addEventListener('scroll', function() {
                if (window.pageYOffset >= sidebarTop - 20) {
                    sidebar.style.position = 'sticky';
                    sidebar.style.top = '20px';
                }
            });
        }
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

    // Add hover effects
    document.querySelectorAll('.hover-effect').forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.3s ease';
        });
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });

    // Like button AJAX
    $(document).on('click', '.like-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var commentId = btn.data('id');
        btn.prop('disabled', true);
        $.ajax({
            url: '{{ route('blogs.like-comment') }}',
            type: 'POST',
            data: {
                comment_id: commentId,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                btn.find('.like-count').text(res.count);
                btn.toggleClass('btn-outline-primary btn-primary');
            },
            error: function() {
                alert('Failed to like comment. Please try again.');
            },
            complete: function() {
                btn.prop('disabled', false);
            }
        });
    });

    // Reply form toggle
    $(document).on('click', '.reply-toggle-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        btn.closest('.flex-grow-1').find('.reply-form').toggleClass('d-none');
    });

    // AJAX instant reload for reply forms
    $(document).on('submit', '.reply-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('.submit-btn');
        btn.html('<i class="ri-loader-2-line me-2 spin"></i>Replying...');
        btn.prop('disabled', true);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(res) {
                location.reload();
            },
            error: function(xhr) {
                alert('Failed to post reply. Please check your input.');
                btn.html('<i class="ri-send-plane-line label-icon align-middle rounded-pill fs-14 me-1"></i>Reply');
                btn.prop('disabled', false);
            }
        });
    });

    // Main comment form instant reload
    $(document).on('submit', '.ajaxform_instant_reload', function(e) {
        if ($(this).hasClass('reply-form')) return; // handled above
        e.preventDefault();
        var form = $(this);
        var btn = form.find('.submit-btn');
        btn.html('<i class="ri-loader-2-line me-2 spin"></i>Posting...');
        btn.prop('disabled', true);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(res) {
                location.reload();
            },
            error: function(xhr) {
                alert('Failed to post comment. Please check your input.');
                btn.html('<i class="ri-send-plane-line label-icon align-middle rounded-pill fs-16 me-2"></i>Post Comment');
                btn.prop('disabled', false);
            }
        });
    });

    // Add CSS for spinning animation
    const style = document.createElement('style');
    style.textContent = `
        .spin { animation: spin 1s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .hover-primary:hover { color: var(--bs-primary) !important; }
    `;
    document.head.appendChild(style);
});
</script>
@endsection