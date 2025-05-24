@extends('layouts.web.master')

@section('title')
    {{ __('Blog') }}
@endsection

@section('content')
    {{-- Banner Code Start --}}
    <section class="banner-bg p-4 bg-primary bg-opacity-10 border-bottom mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none custom-clr-primary">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}" class="text-decoration-none custom-clr-primary">{{ __('Blog List') }}</a></li>
                    <li class="breadcrumb-item active custom-clr-dark" aria-current="page">{{ __('Blog Details') }}</li>
                </ol>
            </nav>
        </div>
    </section>

    {{-- Blogs Section Code Start --}}
    <section class="blogs-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="border rounded-4 blog-details-content mb-4 shadow-sm bg-white">
                        <img src="{{ asset($blog->image) }}" alt="" class="details-img rounded-top-4 img-fluid w-100" style="max-height: 380px; object-fit: cover;" />
                        <div class="p-4">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('assets/web/images/icons/clock.svg') }}" alt="" height="18" />
                                <p class="ms-2 mb-0 text-muted small">{{ formatted_date($blog->updated_at) }}</p>
                            </div>
                            <h3 class="mt-2 mb-3 fw-bold custom-clr-dark">{{ $blog->title }}</h3>
                            <div class="mb-4 text-secondary fs-5">
                                {!! $blog->descriptions !!}
                            </div>
                            <div class="comments mt-5">
                                <h5 class="fw-bold mb-3">{{ $comments->count() }} {{ __('Comment') }}</h5>
                                <hr class="m-0 custom-bg-light-sm" />
                                @foreach ($comments as $comment)
                                    <div class="d-flex align-items-start justify-content-between mt-4">
                                        <div class="d-flex align-items-start">
                                            <img src="{{ asset('assets/images/profile/avatar.svg') }}" alt="user" class="user-image rounded-circle me-2" style="width: 44px; height: 44px; object-fit: cover;" />
                                            <div>
                                                <h6 class="mb-1 fw-semibold">{{ $comment->name }}</h6>
                                                <p class="mb-1 text-muted small">
                                                    <small>{{ $comment->updated_at->format('F d, Y \a\t g:i a') }}</small>
                                                </p>
                                                <p class="mb-2">{{ $comment->comment }}</p>
                                                <hr class="mx-0 custom-bg-light-sm" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <h5 class="mt-5 mb-2 fw-bold">{{ __('Leave a Comment Here') }}</h5>
                            <p class="mb-2 text-muted small">{{ __('Your email address will not be published') }}*</p>
                            <hr class="m-0 custom-bg-light-sm" />
                            <form action="{{ route('blogs.store') }}" method="post" class="form-section ajaxform_instant_reload mt-3">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <input type="hidden" name="blog_slug" value="{{ $blog->slug }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="full-name" class="form-label fw-medium">{{ __('Full Name') }}*</label>
                                        <input type="text" name="name" class="form-control" id="full-name" required placeholder="{{ __('Enter your name') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-medium">{{ __('Email') }}*</label>
                                        <input type="email" name="email" class="form-control" id="email" required placeholder="{{ __('Enter your email') }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label fw-medium">{{ __('Comment') }}*</label>
                                        <textarea class="form-control" name="comment" id="message" rows="4" required placeholder="{{ __('Enter your comment') }}"></textarea>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <button type="submit" class="btn theme-btn submit-btn px-4">{{ __('Comment') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <h5 class="fw-bold mb-3">{{ __('Recent Posts') }}</h5>
                    @foreach ($recent_blogs as $blog)
                    <div class="blog-shadow rounded-4 mb-3 p-2 bg-white d-flex align-items-center shadow-sm">
                        <a href="{{ route('blogs.show', $blog->slug) }}">
                            <img src="{{ asset($blog->image ?? '') }}" class="object-fit-cover rounded-2 blog-small-image me-3" alt="..." style="width: 70px; height: 70px; object-fit: cover;" />
                        </a>
                        <div>
                            <div class="d-flex align-items-center mb-1">
                                <img src="{{ asset('assets/web/images/icons/clock.svg') }}" alt="" height="16" />
                                <p class="ms-2 mb-0 text-muted small">{{ formatted_date($blog->updated_at) }}</p>
                            </div>
                            <p class="mb-1 fw-semibold p-2nd-line-clamp">
                                {{ Str::limit($blog->title, 60, '...') }}
                            </p>
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="custom-clr-primary small text-decoration-none">
                                {{ __('Read More') }} <span class="font-monospace">&gt;</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
