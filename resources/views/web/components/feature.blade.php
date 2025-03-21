<section class="service-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>{{ $page_data['headings']['feature_title'] ?? '' }}</h2>
        </div>
        <div class="row">
            @foreach ($features as $feature)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="text-center service-card" style="background: {{ $feature->bg_color }}">
                        <div class="image">
                            <img src="{{ asset($feature->image) }}" alt="image" />
                        </div>
                        <div class="service-content">
                            <h6>{{ $feature->title }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
