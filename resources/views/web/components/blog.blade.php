<section class="blog-section p-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="row g-4">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-6">
                            <div class="blog-shadow rounded-4 bg-white h-100 d-flex flex-column shadow-sm">
                                <div class="text-center blog-image mb-3 position-relative overflow-hidden rounded-4">
                                    <img src="{{ asset($blog->image) }}" alt="product-image"
                                        class="w-100 object-fit-cover rounded-4"
                                        style="height: 220px; min-height: 180px; background: #f8f9fa;" />
                                </div>
                                <div class="p-3 pt-0 flex-grow-1 d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="assets/web/images/icons/clock.svg" alt="" height="18" />
                                        <p class="ms-2 mb-0 text-muted small">{{ formatted_date($blog->updated_at) }}</p>
                                    </div>
                                    <h5 class="fw-bold custom-clr-dark h6-line-clamp mb-2">{{ $blog->title }}</h5>
                                    <p class="text-secondary mb-3 flex-grow-1">
                                        {!! Str::limit(strip_tags($blog->descriptions), 120) !!}
                                        @if (strpos($blog->descriptions, '<img') !== false)
                                            <span class="text-muted"></span>
                                        @endif
                                    </p>
                                    <a href="{{ route('blogs.show', $blog->slug) }}"
                                        class="custom-clr-primary fw-semibold text-decoration-none mt-auto">{{ $page_data['headings']['blog_btn_text'] ?? '' }}<span
                                        class="font-monospace">&gt;</span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4">
                @foreach ($recent_blogs as $blog)
                    <div class="blog-shadow rounded-4 mb-4 bg-white d-flex align-items-center shadow-sm p-2">
                        <img src="{{ asset($blog->image) }}"
                            class="object-fit-cover rounded-2 home-blog-small-image me-3"
                            alt="..." style="width: 70px; height: 70px; object-fit: cover;" />
                        <div>
                            <div class="d-flex align-items-center mb-1">
                                <img src="assets/web/images/icons/clock.svg" alt="" height="16" />
                                <p class="ms-2 mb-0 text-muted small">{{ formatted_date($blog->updated_at) }}</p>
                            </div>
                            <p class="p-2nd-line-clamp mb-1 fw-semibold">
                                {{ $blog->title }}
                            </p>
                            <a href="{{ route('blogs.show', $blog->slug) }}"
                                class="custom-clr-primary small text-decoration-none">{{ $page_data['headings']['blog_btn_text'] ?? '' }}<span class="font-monospace">&gt;</span></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
