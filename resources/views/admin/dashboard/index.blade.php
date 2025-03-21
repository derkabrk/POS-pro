@extends('layouts.master')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('main_content')
    <div class="container-fluid m-h-100">
        <div class="gpt-dashboard-card counter-grid-6 mb-24">
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/images/dashboard/01.png') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="total_businesses">0</h5>
                    <p>{{ __('Total Shop') }}</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/images/dashboard/02.png') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="expired_businesses">0</h5>
                    <p>{{ __('Expired Businesses') }}</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/images/dashboard/03.png') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="plan_subscribes">0</h5>
                    <p>{{ __('Plan Subscribes') }}</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/images/dashboard/04.png') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="business_categories">0</h5>
                    <p>{{ __('Total Categories') }}</p>
                </div>
            </div>
            <div class="couter-box">
                <div class="icons">
                    <img src="{{ asset('assets/images/dashboard/05.png') }}" alt="">
                </div>
                <div class="content-side">
                    <h5 id="total_plans">0</h5>
                    <p>{{ __('Total Plans') }}</p>
                </div>
            </div>

        </div>


        <div class="row gpt-dashboard-chart">
            <div class="col-xxl-8 mb-30">
                <div class="card new-card dashboard-card border-0 p-0 h-100">
                    <div class="dashboard-chart-header">
                        <h4>{{ __('Finance Overview') }}</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control yearly-statistics">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="content">
                            <div class="income-container">
                                <div class="income-dot"></div>
                                <div>Total Subscription: <span class="income-value"></span></div>
                            </div>
                            <canvas id="monthly-statistics" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 mb-30">
                <div class="card new-card sms-report border-0 p-0 h-100">
                    <div class="dashboard-chart-header">
                        <h4>{{ __('Subscription Plan') }}</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control overview-year">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            <canvas id="plans-chart" class="chart-css"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="erp-table-section dashboard">
            <div class="card">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{ __('Recent Register') }}</h4>
                        <div>
                            <a href="{{ route('admin.business.index') }}" class="add-order-btn rounded-2"><i
                                    class="far fa-list me-1" aria-hidden="true"></i> {{ __('View All') }}</a>
                        </div>
                    </div>
                    <div class="erp-box-content">
                        <div class="top-customer-table">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="text-start"> {{ __('SL') }}. </th>
                                        <th class="text-start">{{ __('Date & Time') }}</th>
                                        <th class="text-start">{{ __('Name') }}</th>
                                        <th class="text-start">{{ __('Category') }}</th>
                                        <th class="text-start">{{ __('Phone') }}</th>
                                        <th class="text-center">{{ __('Subscription Plan') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($businesses as $business)
                                        <tr>
                                            <td class="text-start">
                                                {{ $loop->index + 1 }}
                                            </td>
                                            <td class="text-start">
                                                {{ formatted_date($business->created_at) }}
                                            </td>
                                            <td class="text-start">
                                                {{ $business->companyName }}
                                            </td>
                                            <td class="text-start">
                                                {{ $business->category->name }}
                                            </td>
                                            <td class="text-start">
                                                {{ $business->phoneNumber }}
                                            </td>
                                            <td class="text-center">

                                                @if ($business->enrolled_plan?->plan?->subscriptionName == 'Free')
                                                    <span
                                                        class="free-badge">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
                                                @elseif($business->enrolled_plan?->plan?->subscriptionName == 'Premium')
                                                    <span
                                                        class="premium-badge">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
                                                @elseif($business->enrolled_plan?->plan?->subscriptionName == 'Standard')
                                                    <span
                                                        class="standard-badge">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @php
        $currency = default_currency();
    @endphp
    {{-- Hidden input fields to store currency details --}}
    <input type="hidden" id="currency_symbol" value="{{ $currency->symbol }}">
    <input type="hidden" id="currency_position" value="{{ $currency->position }}">
    <input type="hidden" id="currency_code" value="{{ $currency->code }}">

    <input type="hidden" value="{{ route('admin.dashboard.data') }}" id="get-dashboard">
    <input type="hidden" value="{{ route('admin.dashboard.plans-overview') }}" id="get-plans-overview">
    <input type="hidden" value="{{ route('admin.dashboard.subscriptions') }}" id="yearly-subscriptions-url">
@endsection

@push('js')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/dashboard.js') }}"></script>
@endpush
