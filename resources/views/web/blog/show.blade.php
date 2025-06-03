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
                                
                                <form action="{{ route('blogs.store') }}" method="post" class="form-section main-comment-form">
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
$(document).ready(function() {
    // Debug function
    function debugLog(message, data = null) {
        console.log('[Blog Debug]', message, data);
    }

    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        .spin { 
            animation: spin 1s linear infinite; 
            display: inline-block;
        }
        @keyframes spin { 
            from { transform: rotate(0deg); } 
            to { transform: rotate(360deg); } 
        }
        .hover-primary:hover { 
            color: var(--bs-primary) !important; 
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    `;
    document.head.appendChild(style);

    // Sticky sidebar
    var sidebar = $('.sticky-sidebar');
    if (sidebar.length) {
        var sidebarTop = sidebar.offset().top;
        $(window).on('scroll', function() {
            if ($(window).scrollTop() >= sidebarTop - 20) {
                sidebar.css({position: 'sticky', top: '20px'});
            }
        });
    }

    // Add hover effects
    $('.hover-effect').on('mouseenter', function() {
        $(this).css({
            transform: 'translateY(-2px)', 
            boxShadow: '0 4px 12px rgba(0,0,0,0.1)', 
            transition: 'all 0.3s ease'
        });
    }).on('mouseleave', function() {
        $(this).css({
            transform: 'translateY(0)', 
            boxShadow: 'none'
        });
    });

    // Like button functionality
    $(document).on('click', '.like-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var btn = $(this);
        var commentId = btn.data('comment-id') || btn.data('id') || btn.attr('data-comment-id') || btn.attr('data-id');
        
        debugLog('Like button clicked', {
            commentId: commentId,
            button: btn[0],
            dataAttributes: btn[0].dataset
        });
        
        if (!commentId) {
            console.error('No comment ID found on like button. Available data attributes:', btn[0].dataset);
            alert('Error: Comment ID not found. Please refresh the page and try again.');
            return;
        }

        // Prevent double clicks
        if (btn.prop('disabled') || btn.hasClass('processing')) {
            debugLog('Button already processing, ignoring click');
            return;
        }

        btn.addClass('processing').prop('disabled', true);
        
        // Store original content
        var originalHtml = btn.html();
        var likeCountEl = btn.find('.like-count');
        var currentCount = parseInt(likeCountEl.text()) || 0;
        
        // Show loading state
        btn.html('<i class="ri-loader-2-line spin me-1"></i> Liking...');
        
        $.ajax({
            url: '{{ route("blogs.like-comment") }}',
            type: 'POST',
            data: {
                comment_id: commentId,
                _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
            },
            timeout: 10000,
            success: function(response) {
                debugLog('Like success response', response);
                
                if (response.success || response.status === 'success') {
                    // Update like count
                    var newCount = response.count || response.likes_count || (currentCount + 1);
                    likeCountEl.text(newCount);
                    
                    // Toggle button state
                    if (response.liked !== undefined) {
                        if (response.liked) {
                            btn.removeClass('btn-outline-primary').addClass('btn-primary');
                        } else {
                            btn.removeClass('btn-primary').addClass('btn-outline-primary');
                        }
                    } else {
                        // Fallback toggle
                        btn.toggleClass('btn-outline-primary btn-primary');
                    }
                    
                    // Show success feedback
                    btn.html('<i class="ri-heart-fill me-1"></i> <span class="like-count">' + newCount + '</span>');
                    
                    // Brief success indication
                    setTimeout(function() {
                        btn.html(originalHtml.replace(/\d+/, newCount));
                    }, 1000);
                    
                } else {
                    throw new Error(response.message || 'Unknown error occurred');
                }
            },
            error: function(xhr, status, error) {
                debugLog('Like error', {xhr: xhr, status: status, error: error});
                
                var errorMessage = 'Failed to like comment. Please try again.';
                
                if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 422) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || errorMessage;
                    } catch (e) {
                        // Use default message
                    }
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again later.';
                } else if (status === 'timeout') {
                    errorMessage = 'Request timed out. Please check your connection and try again.';
                }
                
                alert(errorMessage);
                console.error('Like request failed:', xhr.responseText);
            },
            complete: function() {
                // Always restore button state
                btn.removeClass('processing').prop('disabled', false);
                
                // Restore original content if still in loading state
                if (btn.html().includes('Liking...')) {
                    btn.html(originalHtml);
                }
            }
        });
    });

    // Reply form toggle
    $(document).on('click', '.reply-toggle-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var btn = $(this);
        var replyForm = btn.closest('.comment-item, .flex-grow-1').find('.reply-form').first();
        
        debugLog('Reply toggle clicked', {
            button: btn[0],
            replyForm: replyForm[0]
        });
        
        if (replyForm.length) {
            replyForm.toggleClass('d-none');
            
            // Focus on the first input when showing
            if (!replyForm.hasClass('d-none')) {
                setTimeout(function() {
                    replyForm.find('input[name="name"], textarea').first().focus();
                }, 100);
            }
        } else {
            console.error('Reply form not found');
        }
    });

    // Reply form submission
    $(document).on('submit', '.reply-form', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var form = $(this);
        var btn = form.find('.submit-btn, button[type="submit"]');
        
        debugLog('Reply form submitted', {
            form: form[0],
            action: form.attr('action'),
            data: form.serialize()
        });
        
        // Prevent double submission
        if (btn.prop('disabled') || btn.hasClass('processing')) {
            return;
        }
        
        // Validate required fields
        var isValid = true;
        form.find('input[required], textarea[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('is-invalid').focus();
                return false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Please fill in all required fields.');
            return;
        }
        
        btn.addClass('processing').prop('disabled', true);
        var originalHtml = btn.html();
        btn.html('<i class="ri-loader-2-line spin me-2"></i>Replying...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            timeout: 15000,
            success: function(response) {
                debugLog('Reply success response', response);
                
                if (response.success || response.status === 'success') {
                    // Show success message briefly
                    btn.html('<i class="ri-check-line me-2"></i>Reply Posted!');
                    
                    // Reload page after short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    throw new Error(response.message || 'Failed to post reply');
                }
            },
            error: function(xhr, status, error) {
                debugLog('Reply error', {xhr: xhr, status: status, error: error});
                
                var errorMessage = 'Failed to post reply. Please check your input and try again.';
                
                if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 422) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            var errors = Object.values(response.errors).flat();
                            errorMessage = errors.join(', ');
                        } else {
                            errorMessage = response.message || errorMessage;
                        }
                    } catch (e) {
                        // Use default message
                    }
                } else if (status === 'timeout') {
                    errorMessage = 'Request timed out. Please check your connection and try again.';
                }
                
                alert(errorMessage);
                console.error('Reply submission failed:', xhr.responseText);
                
                // Restore button
                btn.html(originalHtml).removeClass('processing').prop('disabled', false);
            }
        });
    });

    // Main comment form submission
    $(document).on('submit', '.main-comment-form', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var form = $(this);
        var btn = form.find('.submit-btn');
        
        debugLog('Main comment form submitted', {
            form: form[0],
            action: form.attr('action'),
            data: form.serialize()
        });
        
        // Prevent double submission
        if (btn.prop('disabled') || btn.hasClass('processing')) {
            return;
        }
        
        // Validate required fields
        var isValid = true;
        form.find('input[required], textarea[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('is-invalid').focus();
                return false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Please fill in all required fields.');
            return;
        }
        
        btn.addClass('processing').prop('disabled', true);
        var originalHtml = btn.html();
        btn.html('<i class="ri-loader-2-line spin me-2"></i>Posting...');
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            timeout: 15000,
            success: function(response) {
                debugLog('Comment success response', response);
                
                if (response.success || response.status === 'success') {
                    // Show success message
                    btn.html('<i class="ri-check-line me-2"></i>Comment Posted!');
                    
                    // Reload page after short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    throw new Error(response.message || 'Failed to post comment');
                }
            },
            error: function(xhr, status, error) {
                debugLog('Comment error', {xhr: xhr, status: status, error: error});
                
                var errorMessage = 'Failed to post comment. Please check your input and try again.';
                
                if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 422) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            var errors = Object.values(response.errors).flat();
                            errorMessage = errors.join(', ');
                        } else {
                            errorMessage = response.message || errorMessage;
                        }
                    } catch (e) {
                        // Use default message
                    }
                } else if (status === 'timeout') {
                    errorMessage = 'Request timed out. Please check your connection and try again.';
                }
                
                alert(errorMessage);
                console.error('Comment submission failed:', xhr.responseText);
                
                // Restore button
                btn.html(originalHtml).removeClass('processing').prop('disabled', false);
            }
        });
    });

    // Initialize page
    debugLog('Blog page initialized');
});
</script>
@endsection