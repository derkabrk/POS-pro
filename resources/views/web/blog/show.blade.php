@extends('layouts.web.master')

@section('title')
    {{ __('Blog') }}
@endsection

@section('main_content')
    {{-- Banner Code Start --}}
    <section class="banner-bg p-4">
        <div class="container">
            <p class="mb-0 fw-medium custom-clr-dark">
                {{ __('Home') }} <span class="font-monospace">></span>{{ __('Blog List') }}<span class="font-monospace">></span>
               {{ __('Blog Details') }}
            </p>
        </div>
    </section>

    {{-- Blogs Section Code Start --}}
    <section class="blogs-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="border rounded-16 blog-details-content mb-3">
                        <img src="{{ asset($blog->image) }}" alt="" class="details-img rounded-top-16" />

                        <div class="p-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/web/images/icons/clock.svg') }}" alt="" />
                                <p class="ms-1 mb-0">{{ formatted_date($blog->updated_at) }}</p>
                            </div>
                            <h6 class="mt-2">{{ $blog->title }}</h6>
                            <p>
                                {!! $blog->descriptions !!}
                            </p>

                            <div class="comments">
                                <h6>{{ $comments->count() }} {{ __('Comment') }}</h6>
                                <hr class="m-0 custom-bg-light-sm" />
                                @foreach ($comments as $comment)
                                    <div class="d-flex align-items-start justify-content-between mt-3">
                                        <div class="d-flex align-items-start">
                                            <img src="{{ asset('assets/images/profile/avatar.svg') }}" alt="user"class="user-image rounded-circle" />

                                            <div class="ms-2">
                                                <h6 class="mb-0">{{ $comment->name }}</h6>
                                                <p class="mb-2">
                                                    <small>{{ $comment->updated_at->format('F d, Y \a\t g:i a') }}</small>
                                                </p>
                                                <p>{{ $comment->comment }}</p>
                                                <hr class="mx-0 custom-bg-light-sm" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <h6>{{ __('Leave a Comment Here') }}</h6>
                            <p class="mb-2">{{ __('Your email address will not be published') }}*</p>
                            <hr class="m-0 custom-bg-light-sm" />
                            <form action="{{ route('blogs.store') }}" method="post"
                                class="form-section ajaxform_instant_reload">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <input type="hidden" name="blog_slug" value="{{ $blog->slug }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="full-name" class="col-form-label fw-medium">{{ __('Full Name') }}*</label>
                                        <input type="text" name="name" class="form-control" id="full-name" required placeholder="{{ __('Enter your name') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="col-form-label fw-medium">{{ __('Email') }}*</label>
                                        <input type="email" name="email" class="form-control" id="email" required placeholder="{{ __('Enter your email') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="message" class="col-form-label fw-medium">{{ __('Comment') }}*</label>
                                        <textarea class="form-control" name="comment" id="message" rows="4" required placeholder="{{ __('Enter your comment') }}"></textarea>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <button type="submit" class="btn theme-btn submit-btn">{{ __('Comment') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <h6>{{ __('Recent Posts') }}</h6>
                    @foreach ($recent_blogs as $blog)
                    <div class="blog-shadow rounded-16 mb-2">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('blogs.show', $blog->slug) }}">
                                <img src="{{ asset($blog->image ?? '') }}" class="object-fit-cover rounded-1  blog-small-image" alt="...">
                            </a>
                            <div class="mx-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/web/images/icons/clock.svg') }}" alt="" />
                                    <p class="ms-1 mb-0">{{ formatted_date($blog->updated_at) }}</p>
                                </div>

                                <p class="p-2nd-line-clamp mb-1">
                                    <strong>{{ Str::limit($blog->title, 60, '...') }}</strong>
                                </p>
                                <a href="{{ route('blogs.show', $blog->slug) }}" class="custom-clr-primary">
                                    {{ __('Read More') }}
                                    <span class="font-monospace">></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
