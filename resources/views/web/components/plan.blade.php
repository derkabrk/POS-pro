<section class="pricing-plan-section plans-list">
    <div class="container">
        <div class="section-title text-center">
            <h2>{{ $page_data['headings']['pricing_title'] ?? '' }}</h2>
            <p class="section-description">
                {{ $page_data['headings']['pricing_description'] ?? '' }}
            </p>
            <div class="d-flex align-items-center justify-content-center gap-4">
                <div class="w-100 d-flex flex-column align-items-center">

                    <div class="tab-content w-100">
                        <div class="tab-pane fade show active" id="nav-monthly" role="tabpanel"
                            aria-labelledby="nav-monthly-tab">
                            <div class="row">
                                @foreach ($plans as $plan)
                                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <div class="card">
                                            <div class="card-header py-3 border-0 font-size-update">
                                                <p>{{ $plan['subscriptionName'] ?? '' }}</p>
                                                <h4>
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
                                                    <span
                                                        class="price-span">/{{ $plan['duration'] . ' Days' }}</span></small>
                                                </h4>

                                            </div>
                                            <div class="card-body text-start">
                                                <p>{{ __('Features Of Free Plan') }} 👇</p>

                                                <ul>
                                                    @foreach ($plan['features'] ?? [] as $key => $item)
                                                        <li>
                                                            <i class="fas {{ isset($item[1]) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-1"></i>
                                                            {{ $item[0] ?? '' }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <a class="btn subscribe-plan d-block mt-4 mb-2" data-bs-target="#registration-modal" data-bs-toggle="modal">{{ __("Buy Now") }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" value="{{ route('get-business-categories') }}" id="get-business-categories">
