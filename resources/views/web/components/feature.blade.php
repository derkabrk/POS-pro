<section class="section bg-light" id="services">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h3 class="mb-3 fw-semibold">{{ $page_data['headings']['feature_title'] ?? '' }}</h3>
                    <p class="text-muted mb-4 ff-secondary">{{ $page_data['headings']['feature_description'] ?? 'Discover our amazing features that make your experience better' }}</p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row g-4">
            @foreach ($features as $feature)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 h-100">
                        <div class="avatar-lg icon-effect mx-auto mb-4" style="background: {{ $feature->bg_color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset($feature->image) }}" 
                                 alt="{{ $feature->title }}" 
                                 class="img-fluid" 
                                 style="max-height: 40px; max-width: 40px; object-fit: contain;" />
                        </div>
                        <div>
                            <h6 class="fs-16 fw-semibold text-dark mb-2">{{ $feature->title }}</h6>
                            @if(isset($feature->description))
                                <p class="text-muted mb-0 fs-14">{{ Str::limit($feature->description, 80) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>

<style>
/* Feature Section Custom Styles */
.icon-effect {
    transition: all 0.3s ease;
}

.icon-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Responsive adjustments for features */
@media (max-width: 768px) {
    .avatar-lg {
        width: 60px !important;
        height: 60px !important;
    }
    
    .avatar-lg img {
        max-height: 30px !important;
        max-width: 30px !important;
    }
    
    .fs-16 {
        font-size: 14px !important;
    }
}

@media (max-width: 576px) {
    .col-6 {
        margin-bottom: 1rem;
    }
    
    .avatar-lg {
        width: 50px !important;
        height: 50px !important;
    }
    
    .avatar-lg img {
        max-height: 25px !important;
        max-width: 25px !important;
    }
}
</style>