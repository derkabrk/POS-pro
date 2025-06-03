{{-- resources/views/web/blog/partials/comment.blade.php --}}
<div class="comment-item mb-4 p-4 bg-light rounded-3" data-comment-id="{{ $comment->id }}">
    <div class="d-flex align-items-start">
        <!-- User Avatar -->
        <div class="avatar-sm me-3 flex-shrink-0">
            <div class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle fw-semibold">
                {{ strtoupper(substr($comment->name ?? 'U', 0, 1)) }}
            </div>
        </div>
        
        <!-- Comment Content -->
        <div class="flex-grow-1">
            <!-- Comment Header -->
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h6 class="mb-1 fw-semibold text-dark">{{ $comment->name ?? 'Anonymous' }}</h6>
                    <div class="d-flex align-items-center text-muted small">
                        <i class="ri-time-line me-1"></i>
                        <span>{{ $comment->created_at->diffForHumans() ?? 'Just now' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Comment Text -->
            <div class="comment-text mb-3 text-muted lh-lg">
                {{ $comment->comment ?? '' }}
            </div>
            
            <!-- Comment Actions -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <!-- Like Button -->
                <button type="button" 
                        class="btn btn-sm btn-outline-primary like-btn d-flex align-items-center gap-1" 
                        data-comment-id="{{ $comment->id }}"
                        data-blog-id="{{ $blog->id }}">
                    <i class="ri-thumb-up-line"></i>
                    <span class="like-count">{{ $comment->likes_count ?? 0 }}</span>
                    <span class="ms-1">{{ __('Like') }}</span>
                </button>
                
                <!-- Reply Button -->
                <button type="button" 
                        class="btn btn-sm btn-outline-secondary reply-toggle-btn d-flex align-items-center gap-1">
                    <i class="ri-reply-line"></i>
                    <span>{{ __('Reply') }}</span>
                </button>
            </div>
            
            <!-- Reply Form (Initially Hidden) -->
            <div class="reply-form d-none mt-3">
                <div class="card border-0 bg-white">
                    <div class="card-body p-3">
                        <h6 class="mb-3 fw-semibold">
                            <i class="ri-reply-line text-primary me-2"></i>
                            {{ __('Reply to') }} {{ $comment->name ?? 'this comment' }}
                        </h6>
                        
                        <form action="{{ route('blogs.reply.store') }}" method="post" class="reply-form-ajax">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                            <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                            <input type="hidden" name="blog_slug" value="{{ $blog->slug }}">
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="reply-name-{{ $comment->id }}" class="form-label fw-medium small">
                                        <i class="ri-user-line me-1"></i>{{ __('Your Name') }} *
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control form-control-sm border-light" 
                                           id="reply-name-{{ $comment->id }}" 
                                           required 
                                           placeholder="{{ __('Enter your name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="reply-email-{{ $comment->id }}" class="form-label fw-medium small">
                                        <i class="ri-mail-line me-1"></i>{{ __('Your Email') }} *
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control form-control-sm border-light" 
                                           id="reply-email-{{ $comment->id }}" 
                                           required 
                                           placeholder="{{ __('Enter your email') }}">
                                </div>
                                <div class="col-12">
                                    <label for="reply-comment-{{ $comment->id }}" class="form-label fw-medium small">
                                        <i class="ri-message-line me-1"></i>{{ __('Your Reply') }} *
                                    </label>
                                    <textarea class="form-control form-control-sm border-light" 
                                              name="comment" 
                                              id="reply-comment-{{ $comment->id }}" 
                                              rows="3" 
                                              required 
                                              placeholder="{{ __('Write your reply...') }}"></textarea>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-sm btn-light reply-cancel-btn">
                                    {{ __('Cancel') }}
                                </button>
                                <button type="submit" class="btn btn-sm btn-primary reply-submit-btn">
                                    <i class="ri-send-plane-line me-1"></i>
                                    {{ __('Post Reply') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Replies (if any) -->
            @if(isset($comment->replies) && $comment->replies->count() > 0)
                <div class="replies-section mt-4 ps-3 border-start border-2 border-primary border-opacity-25">
                    @foreach($comment->replies as $reply)
                        <div class="reply-item mb-3 p-3 bg-white rounded-2">
                            <div class="d-flex align-items-start">
                                <div class="avatar-xs me-2 flex-shrink-0">
                                    <div class="avatar-title bg-secondary bg-opacity-10 text-secondary rounded-circle small fw-semibold">
                                        {{ strtoupper(substr($reply->name ?? 'U', 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <h6 class="mb-0 fw-semibold small text-dark">{{ $reply->name ?? 'Anonymous' }}</h6>
                                        <small class="text-muted">{{ $reply->created_at->diffForHumans() ?? 'Just now' }}</small>
                                    </div>
                                    <p class="mb-2 text-muted small lh-base">{{ $reply->comment ?? '' }}</p>
                                    <button type="button" 
                                            class="btn btn-xs btn-outline-primary like-btn d-flex align-items-center gap-1" 
                                            data-comment-id="{{ $reply->id }}"
                                            data-blog-id="{{ $blog->id }}">
                                        <i class="ri-thumb-up-line"></i>
                                        <span class="like-count">{{ $reply->likes_count ?? 0 }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
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
        $(this).css({transform: 'translateY(-2px)', boxShadow: '0 4px 12px rgba(0,0,0,0.1)', transition: 'all 0.3s ease'});
    }).on('mouseleave', function() {
        $(this).css({transform: 'translateY(0)', boxShadow: 'none'});
    });

    // Like button AJAX - Fixed
    $(document).on('click', '.like-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var commentId = btn.attr('data-comment-id') || btn.data('comment-id');
        var blogId = btn.attr('data-blog-id') || btn.data('blog-id');
        
        if (!commentId) {
            console.error('No commentId found on like button');
            return;
        }
        
        btn.prop('disabled', true);
        var originalHtml = btn.html();
        btn.html('<i class="ri-loader-2-line spin"></i> Liking...');
        
        $.ajax({
            url: '{{ route("blogs.like-comment") }}',
            type: 'POST',
            data: {
                comment_id: commentId,
                blog_id: blogId,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if (res.success) {
                    btn.find('.like-count').text(res.count || res.likes_count || 0);
                    
                    // Toggle button appearance
                    if (res.liked) {
                        btn.removeClass('btn-outline-primary').addClass('btn-primary');
                        btn.find('i').removeClass('ri-thumb-up-line').addClass('ri-thumb-up-fill');
                    } else {
                        btn.removeClass('btn-primary').addClass('btn-outline-primary');
                        btn.find('i').removeClass('ri-thumb-up-fill').addClass('ri-thumb-up-line');
                    }
                    
                    // Show success message
                    showNotification('success', res.message || 'Action completed successfully!');
                } else {
                    showNotification('error', res.message || 'Something went wrong!');
                }
            },
            error: function(xhr) {
                console.error('Like error:', xhr.responseText);
                var errorMsg = 'Failed to like comment. Please try again.';
                
                if (xhr.status === 422) {
                    try {
                        var errors = JSON.parse(xhr.responseText);
                        errorMsg = errors.message || errorMsg;
                    } catch(e) {}
                } else if (xhr.status === 401) {
                    errorMsg = 'Please log in to like comments.';
                }
                
                showNotification('error', errorMsg);
            },
            complete: function() {
                btn.prop('disabled', false);
                btn.html(originalHtml);
            }
        });
    });

    // Reply form toggle - Fixed
    $(document).on('click', '.reply-toggle-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var replyForm = btn.closest('.flex-grow-1').find('.reply-form');
        
        // Toggle form visibility
        replyForm.toggleClass('d-none');
        
        // Update button text
        if (replyForm.hasClass('d-none')) {
            btn.html('<i class="ri-reply-line"></i> <span>{{ __("Reply") }}</span>');
        } else {
            btn.html('<i class="ri-close-line"></i> <span>{{ __("Cancel") }}</span>');
            // Focus on the first input
            replyForm.find('input[name="name"]').focus();
        }
    });

    // Reply form cancel button
    $(document).on('click', '.reply-cancel-btn', function(e) {
        e.preventDefault();
        var form = $(this).closest('.reply-form');
        var toggleBtn = form.closest('.flex-grow-1').find('.reply-toggle-btn');
        
        form.addClass('d-none');
        form.find('form')[0].reset(); // Reset form
        toggleBtn.html('<i class="ri-reply-line"></i> <span>{{ __("Reply") }}</span>');
    });

    // AJAX for reply forms - Fixed
    $(document).on('submit', '.reply-form-ajax', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('.reply-submit-btn');
        var originalHtml = btn.html();
        
        btn.html('<i class="ri-loader-2-line spin"></i> {{ __("Replying...") }}');
        btn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(res) {
                if (res.success) {
                    showNotification('success', res.message || 'Reply posted successfully!');
                    
                    // Reset and hide form
                    form[0].reset();
                    form.closest('.reply-form').addClass('d-none');
                    
                    // Reset toggle button
                    var toggleBtn = form.closest('.flex-grow-1').find('.reply-toggle-btn');
                    toggleBtn.html('<i class="ri-reply-line"></i> <span>{{ __("Reply") }}</span>');
                    
                    // Reload page after short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('error', res.message || 'Failed to post reply.');
                }
            },
            error: function(xhr) {
                console.error('Reply error:', xhr.responseText);
                var errorMsg = 'Failed to post reply. Please check your input.';
                
                if (xhr.status === 422) {
                    try {
                        var errors = JSON.parse(xhr.responseText);
                        if (errors.errors) {
                            var firstError = Object.values(errors.errors)[0];
                            errorMsg = Array.isArray(firstError) ? firstError[0] : firstError;
                        } else if (errors.message) {
                            errorMsg = errors.message;
                        }
                    } catch(e) {}
                }
                
                showNotification('error', errorMsg);
            },
            complete: function() {
                btn.html(originalHtml);
                btn.prop('disabled', false);
            }
        });
    });

    // Main comment form instant reload - Fixed
    $(document).on('submit', '.ajaxform_instant_reload', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('.submit-btn');
        var originalHtml = btn.html();
        
        btn.html('<i class="ri-loader-2-line spin"></i> {{ __("Posting...") }}');
        btn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(res) {
                if (res.success) {
                    showNotification('success', res.message || 'Comment posted successfully!');
                    form[0].reset();
                    
                    // Reload page after short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('error', res.message || 'Failed to post comment.');
                }
            },
            error: function(xhr) {
                console.error('Comment error:', xhr.responseText);
                var errorMsg = 'Failed to post comment. Please check your input.';
                
                if (xhr.status === 422) {
                    try {
                        var errors = JSON.parse(xhr.responseText);
                        if (errors.errors) {
                            var firstError = Object.values(errors.errors)[0];
                            errorMsg = Array.isArray(firstError) ? firstError[0] : firstError;
                        } else if (errors.message) {
                            errorMsg = errors.message;
                        }
                    } catch(e) {}
                }
                
                showNotification('error', errorMsg);
            },
            complete: function() {
                btn.html(originalHtml);
                btn.prop('disabled', false);
            }
        });
    });

    // Notification function
    function showNotification(type, message) {
        // Remove existing notifications
        $('.custom-notification').remove();
        
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var iconClass = type === 'success' ? 'ri-check-line' : 'ri-error-warning-line';
        
        var notification = $(`
            <div class="custom-notification alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            notification.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        .spin { 
            animation: spin 1s linear infinite; 
        }
        @keyframes spin { 
            from { transform: rotate(0deg); } 
            to { transform: rotate(360deg); } 
        }
        .hover-primary:hover { 
            color: var(--bs-primary) !important; 
        }
        .custom-notification {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: none;
        }
        .reply-form {
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection

{{-- Usage in the main comments section --}}
<div class="comments-list mb-5">
    @foreach ($comments as $comment)
        @include('web.blog.partials.comment', ['comment' => $comment, 'blog' => $blog])
    @endforeach
</div>