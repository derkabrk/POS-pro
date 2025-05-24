<section class="service-section py-5 bg-light bg-opacity-50">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['feature_title'] ?? '' }}</h2>
        </div>
        <div class="row g-4">
            @foreach ($features as $feature)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 text-center p-3 rounded-4" style="background: {{ $feature->bg_color }}">
                        <div class="mb-3 d-flex justify-content-center align-items-center" style="height: 80px;">
                            <img src="{{ asset($feature->image) }}" alt="image" class="img-fluid" style="max-height: 60px; max-width: 100%; object-fit: contain;" />
                        </div>
                        <div class="service-content">
                            <h6 class="fw-semibold custom-clr-primary mb-0">{{ $feature->title }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
