@php
    $likeCount = $comment->likes->count();
    $userLiked = false;
    if (auth()->check()) {
        $userLiked = $comment->likes->where('user_id', auth()->id())->count() > 0;
    } else {
        $userLiked = $comment->likes->where('ip_address', request()->ip())->count() > 0;
    }
@endphp
<div class="d-flex align-items-start mb-4 p-3 bg-light rounded-3">
    <div class="avatar-sm me-3">
        <div class="avatar-title bg-primary text-white rounded-circle fs-16 fw-medium">
            {{ strtoupper(substr($comment->name, 0, 1)) }}
        </div>
    </div>
    <div class="flex-grow-1">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0 fw-semibold text-dark">{{ $comment->name }}</h6>
            <small class="text-muted">
                <i class="ri-time-line me-1"></i>
                {{ $comment->updated_at->format('M d, Y \a\t g:i a') }}
            </small>
        </div>
        <p class="mb-2 text-muted">{{ $comment->comment }}</p>
        <div class="d-flex align-items-center gap-3 mb-2">
            <button class="btn btn-sm btn-outline-primary like-btn" data-comment-id="{{ $comment->id }}">
                <i class="ri-thumb-up-line me-1"></i>
                <span class="like-count">{{ $likeCount }}</span>
                <span class="like-label">Like</span>
            </button>
            <button class="btn btn-sm btn-outline-secondary reply-toggle-btn" data-id="{{ $comment->id }}">
                <i class="ri-reply-line me-1"></i>Reply
            </button>
        </div>
        <!-- Reply Form (hidden by default) -->
        <form action="{{ route('blogs.store') }}" method="post" class="reply-form d-none mt-2 ajaxform_instant_reload">
            @csrf
            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
            <input type="hidden" name="blog_slug" value="{{ $blog->slug }}">
            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            <div class="row g-2 mb-2">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control form-control-sm border-light bg-light" required placeholder="Name">
                </div>
                <div class="col-md-4">
                    <input type="email" name="email" class="form-control form-control-sm border-light bg-light" required placeholder="Email">
                </div>
                <div class="col-md-4">
                    <input type="text" name="comment" class="form-control form-control-sm border-light bg-light" required placeholder="Reply...">
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-sm submit-btn">
                    <i class="ri-send-plane-line label-icon align-middle rounded-pill fs-14 me-1"></i>Reply
                </button>
            </div>
        </form>
        <!-- Nested Replies -->
        @if ($comment->replies && $comment->replies->count())
            <div class="ms-4 mt-3">
                @foreach ($comment->replies as $reply)
                    @include('web.blog.partials.comment', ['comment' => $reply, 'blog' => $blog])
                @endforeach
            </div>
        @endif
    </div>
</div>
