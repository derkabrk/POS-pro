@extends('business::layouts.master')

@section('title')
    {{ __('Subscriptions List') }}
@endsection

@section('content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-lg rounded-4 border-0 bg-light-subtle">
                <div class="card-body p-4">
                    <div class="subscription-header mb-4 text-center">
                        <h3 class="fw-bold text-primary">{{ __('Purchase Plan') }}</h3>
                    </div>
                    <div class="premium-plan-container">
                        <div class="row g-4 premium-plan-content justify-content-center">
                            @foreach ($plans as $plan)
                                @php
                                    $activePlan = plan_data();
                                    $isFreePlan = $plan->subscriptionPrice == 0;
                                    $isPlanActivated = $activePlan != null;
                                    $business = auth()->user()->business ?? null;
                                    $notPurchaseAble = ($activePlan && $activePlan->plan_id == $plan->id && ($business && $business->will_expire > now()->addDays(7)))
                                        || ($business && $business->will_expire >= now()->addDays($plan->duration));
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div class="plan-single-content card h-100 shadow rounded-4 border-0 p-0 position-relative bg-gradient bg-primary-subtle">
                                        @if ((plan_data() ?? false) && plan_data()->plan_id == $plan->id)
                                            <div class="recommended-banner-container position-absolute top-0 end-0 m-2">
                <span class="badge bg-gradient bg-primary text-white px-2 py-1 fs-7 rounded-pill d-flex align-items-center shadow-sm" style="font-size: 0.95rem;">
                    <i class="ri-vip-crown-2-line me-1 text-warning" style="font-size:1.1rem;"></i>
                    {{ __('Current Plan') }}
                </span>
            </div>
                                        @endif
                                        @if ($plan->offerPrice)
                                            <div class="discount-badge-content mb-2 position-absolute top-0 start-0 m-2">
                                                <span class="badge bg-warning text-dark fs-6">
                                                    <del>{{ currency_format($plan->subscriptionPrice) }}</del>
                                                    <img class="discount-arrow ms-2" src="{{ asset('assets/images/icons/discount-arrow.svg') }}" >
                                                </span>
                                            </div>
                                        @endif
                                        <div class="d-flex align-items-center justify-content-center flex-column gap-2 mb-3 pt-4">
                                            <h4 class="fw-bold text-primary-emphasis">{{ $plan->subscriptionName }}</h4>
                                            <h6 class="text-muted">{{ $plan->duration }} {{ __('Days') }}</h6>
                                            <h2 class="fw-bold text-success">{{ currency_format(convert_money($plan->offerPrice ?? $plan->subscriptionPrice, business_currency()), currency : business_currency()) }}</h2>
                                        </div>
                                        <div class="px-4 pb-4">
                                            @if ($isFreePlan && $isPlanActivated || $notPurchaseAble)
                                                <button class="btn btn-secondary w-100 plan-buy-btn rounded-pill mb-3" disabled>
                                                    {{ __('Buy Now')  }}
                                                </button>
                                            @else
                                                <a href="{{ route('payments-gateways.index', ['plan_id' => $plan->id, 'business_id' => auth()->user()->business_id]) }}" class="btn btn-primary w-100 plan-buy-btn rounded-pill mb-3">
                                                    {{ __('Buy Now') }}
                                                </a>
                                            @endif
                                            <div class="mt-2">
                                                <h6 class="fw-semibold mb-2 text-dark">{{ __('Features') }}</h6>
                                                <ul class="list-group list-group-flush mb-3">
                                                    @foreach ($plan['features'] ?? [] as $key => $item)
                                                        <li class="list-group-item d-flex align-items-center justify-content-between bg-transparent border-0 px-0 py-1">
                                                            <span>
                                                                <i class="fas {{ isset($item[1]) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-1"></i>
                                                                {{ $item[0] ?? '' }}
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
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
@endsection
