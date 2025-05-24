<section class="pricing-plan-section plans-list py-5 bg-light bg-opacity-50">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['pricing_title'] ?? '' }}</h2>
            <p class="section-description text-secondary mb-4">
                {{ $page_data['headings']['pricing_description'] ?? '' }}
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($plans as $plan)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4 bg-white">
                        <div class="card-header py-4 border-0 text-center bg-transparent">
                            <p class="mb-1 fw-semibold custom-clr-primary">{{ $plan['subscriptionName'] ?? '' }}</p>
                            <h4 class="fw-bold mb-0 custom-clr-dark">
                                @if (($plan['offerPrice'] && $plan['subscriptionPrice'] !== null) || $plan['offerPrice'] || $plan['subscriptionPrice'])
                                    @if ($plan['offerPrice'])
                                        {{ currency_format($plan['offerPrice']) }}
                                    @else
                                        {{ currency_format($plan['subscriptionPrice']) }}
                                    @endif
                                @else
                                    @if ($plan['offerPrice'] || $plan['subscriptionPrice'])
                                        {{ currency_format($plan['offerPrice'] ?? $plan['subscriptionPrice']) }}
                                    @else
                                        {{ __('Free') }}
                                    @endif
                                @endif
                                <span class="price-span fs-6 text-muted">/{{ $plan['duration'] . ' Days' }}</span>
                            </h4>
                        </div>
                        <div class="card-body text-start">
                            <p class="fw-semibold mb-2">{{ __('Features Of Free Plan') }} 👇</p>
                            <ul class="list-group list-group-flush mb-4">
                                @foreach ($plan['features'] ?? [] as $key => $item)
                                    <li class="list-group-item bg-transparent ps-0 border-0 d-flex align-items-center">
                                        <i class="fas {{ isset($item[1]) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-2"></i>
                                        <span class="fw-medium custom-clr-dark">{{ $item[0] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <a class="btn subscribe-plan d-block mt-2 fw-bold" data-bs-target="#registration-modal" data-bs-toggle="modal">{{ __("Buy Now") }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<input type="hidden" value="{{ route('get-business-categories') }}" id="get-business-categories">
