@extends('business::layouts.master')

@section('title')
    {{ __('Subscriptions List') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">
                    <div class="subscription-header">
                        <h4>{{ __('Purchase Plan') }}</h4>
                    </div>

                    <div class="premium-plan-container ">
                        <div class="premium-plan-content">
                        @foreach ($plans as $plan)
                                @php
                                    $activePlan = plan_data();
                                    $isFreePlan = $plan->subscriptionPrice == 0;
                                    $isPlanActivated = $activePlan != null;
                                    $business = auth()->user()->business ?? null;
                                    $notPurchaseAble = ($activePlan && $activePlan->plan_id == $plan->id && ($business && $business->will_expire > now()->addDays(7)))
                                        || ($business && $business->will_expire >= now()->addDays($plan->duration));
                                @endphp

                                <div class="plan-single-content">
                                    @if ((plan_data() ?? false) && plan_data()->plan_id == $plan->id)
                                    <div class="recommended-banner-container ">
                                        <div class="recommended-banner">
                                            <span>{{ __('Current Plan') }}</span>
                                          </div>
                                    </div>
                                    @endif
                                    @if ($plan->offerPrice)
                                    <div class="discount-badge-content">
                                        <div class="discount-badge">
                                            <img src="{{ asset('assets/images/icons/discount.svg') }}" >
                                            <span class="discount-text"><del>{{ currency_format($plan->subscriptionPrice) }}</del></span>
                                            <img class="discount-arrow" src="{{ asset('assets/images/icons/discount-arrow.svg') }}" >
                                        </div>
                                    </div>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-center flex-column gap-3">
                                        <h3 class="pb-2">{{ $plan->subscriptionName }}</h3>
                                        <h6 class="pb-2">{{ $plan->duration }} {{ __('Days') }}</h6>
                                        <h1 class="pb-2">{{ currency_format(convert_money($plan->offerPrice ?? $plan->subscriptionPrice, business_currency()), currency : business_currency()) }}</h1>

                                        @if ($isFreePlan && $isPlanActivated || $notPurchaseAble)
                                            <button class="btn w-100 plan-buy-btn" disabled>
                                                {{ __('Buy Now')  }}
                                            </button>
                                        @else
                                            <a href="{{ route('payments-gateways.index', ['plan_id' => $plan->id, 'business_id' => auth()->user()->business_id]) }}" class="btn w-100 plan-buy-btn">
                                                {{ __('Buy Now') }}
                                            </a>
                                        @endif
                                    </div>

                                    @foreach ($plan['features'] ?? [] as $key => $item)
                                        <div class="d-flex align-items-center justify-content-between plans">
                                            <div class="d-flex align-items-center gap-2">
                                                <p>
                                                    <i class="fas {{ isset($item[1]) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-1"></i>
                                                    {{ $item[0] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
