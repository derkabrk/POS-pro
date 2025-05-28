@extends('business::layouts.master')

@section('title')
    {{ __('Subscriptions List') }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Pages @endslot
        @slot('title') Pricing @endslot
    @endcomponent

    <div class="row justify-content-center mt-4">
        <div class="col-lg-5">
            <div class="text-center mb-4">
                <h4 class="fw-semibold fs-22">{{ __('Plans & Pricing') }}</h4>
                <p class="text-muted mb-4 fs-15">{{ __('Simple pricing. No hidden fees. Advanced features for your business.') }}</p>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row">
        @foreach ($plans as $plan)
            @php
                $activePlan = plan_data();
                $isFreePlan = $plan->subscriptionPrice == 0;
                $isPlanActivated = $activePlan != null;
                $business = auth()->user()->business ?? null;
                $notPurchaseAble = ($activePlan && $activePlan->plan_id == $plan->id && ($business && $business->will_expire > now()->addDays(7)))
                    || ($business && $business->will_expire >= now()->addDays($plan->duration));
                $isCurrentPlan = (plan_data() ?? false) && plan_data()->plan_id == $plan->id;
                $isPopular = $loop->iteration === 2; // Make second plan popular, adjust as needed
            @endphp
            
            <div class="col-xxl-3 col-lg-6">
                <div class="card pricing-box {{ $isPopular ? 'ribbon-box right' : '' }}">
                    @if ($isPopular)
                        <div class="ribbon-two ribbon-two-danger"><span>Popular</span></div>
                    @endif
                    
                    <div class="card-body bg-light m-2 p-4">
                        @if ($isCurrentPlan)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success text-white px-2 py-1 fs-7 rounded-pill d-flex align-items-center shadow-sm">
                                    <i class="ri-vip-crown-2-line me-1 text-warning"></i>
                                    {{ __('Current Plan') }}
                                </span>
                            </div>
                        @endif

                        @if ($plan->offerPrice)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning text-dark fs-6">
                                    <del>{{ currency_format($plan->subscriptionPrice) }}</del>
                                    <i class="ri-arrow-right-line ms-1"></i>
                                </span>
                            </div>
                        @endif

                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fw-semibold">{{ $plan->subscriptionName }}</h5>
                            </div>
                            <div class="ms-auto">
                                <h2 class="mb-0">
                                    {{ currency_format(convert_money($plan->offerPrice ?? $plan->subscriptionPrice, business_currency()), currency : business_currency()) }}
                                    <small class="fs-13 text-muted">/{{ $plan->duration }} {{ __('Days') }}</small>
                                </h2>
                            </div>
                        </div>

                        <p class="text-muted">{{ $plan->description ?? __('Perfect plan for your business needs.') }}</p>
                        
                        <ul class="list-unstyled vstack gap-3">
                            @foreach ($plan['features'] ?? [] as $key => $item)
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 {{ isset($item[1]) ? 'text-success' : 'text-danger' }} me-1">
                                            <i class="ri-{{ isset($item[1]) ? 'checkbox-circle-fill' : 'close-circle-fill' }} fs-15 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            {{ $item[0] ?? '' }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="mt-3 pt-2">
                            @if ($isFreePlan && $isPlanActivated || $notPurchaseAble)
                                @if ($isCurrentPlan)
                                    <a href="javascript:void(0);" class="btn btn-danger disabled w-100">{{ __('Your Current Plan') }}</a>
                                @else
                                    <button class="btn btn-light disabled w-100">{{ __('Not Available') }}</button>
                                @endif
                            @else
                                <a href="{{ route('payments-gateways.index', ['plan_id' => $plan->id, 'business_id' => auth()->user()->business_id]) }}" class="btn btn-primary w-100">
                                    {{ __('Change Plan') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        @endforeach
    </div>
    <!--end row-->

@endsection

@section('script')
    <script src="{{ URL::asset('build/js/pages/pricing.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection