@extends('layouts.master')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('section')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __('Dashboard') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light rounded-circle text-primary">
                                            <img src="{{ asset('assets/images/dashboard/01.png') }}" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title mb-1" id="total_businesses">0</h5>
                                        <p class="text-muted mb-0">{{ __('Total Shop') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light rounded-circle text-warning">
                                            <img src="{{ asset('assets/images/dashboard/02.png') }}" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title mb-1" id="expired_businesses">0</h5>
                                        <p class="text-muted mb-0">{{ __('Expired Businesses') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light rounded-circle text-success">
                                            <img src="{{ asset('assets/images/dashboard/03.png') }}" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title mb-1" id="plan_subscribes">0</h5>
                                        <p class="text-muted mb-0">{{ __('Plan Subscribes') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light rounded-circle text-info">
                                            <img src="{{ asset('assets/images/dashboard/04.png') }}" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title mb-1" id="business_categories">0</h5>
                                        <p class="text-muted mb-0">{{ __('Total Categories') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light rounded-circle text-danger">
                                            <img src="{{ asset('assets/images/dashboard/05.png') }}" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title mb-1" id="total_plans">0</h5>
                                        <p class="text-muted mb-0">{{ __('Total Plans') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-8">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('Finance Overview') }}</h4>
                        <div>
                            <select class="form-select form-select-sm yearly-statistics">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-2">
                        <div class="w-100">
                            <div class="d-flex mb-2 ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-1">
                                        <div class="fs-14 text-info">
                                            <i class="ri-checkbox-blank-circle-fill"></i>
                                        </div>
                                    </div>
                                    <div>Total Subscription: <span class="text-success fw-semibold income-value"></span></div>
                                </div>
                            </div>
                            <div>
                                <canvas id="monthly-statistics" height="290" class="apex-charts"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4">
                <div class="card card-height-100">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('Subscription Plan') }}</h4>
                        <div>
                            <select class="form-select form-select-sm overview-year">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="px-3 py-3">
                            <canvas id="plans-chart" class="pie-chart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('Recent Register') }}</h4>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.business.index') }}" class="btn btn-soft-primary btn-sm">
                                <i class="ri-list-check me-1 align-bottom"></i> {{ __('View All') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                    <tr>
                                        <th scope="col" class="ps-4">{{ __('SL') }}.</th>
                                        <th>{{ __('Date & Time') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th class="text-center">{{ __('Subscription Plan') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($businesses as $business)
                                        <tr>
                                            <td class="ps-4">{{ $loop->index + 1 }}</td>
                                            <td>{{ formatted_date($business->created_at) }}</td>
                                            <td>{{ $business->companyName }}</td>
                                            <td>{{ $business->category->name }}</td>
                                            <td>{{ $business->phoneNumber }}</td>
                                            <td class="text-center">
                                                @if ($business->enrolled_plan?->plan?->subscriptionName == 'Free')
                                                    <span class="badge badge-soft-secondary">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
                                                @elseif($business->enrolled_plan?->plan?->subscriptionName == 'Premium')
                                                    <span class="badge badge-soft-success">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
                                                @elseif($business->enrolled_plan?->plan?->subscriptionName == 'Standard')
                                                    <span class="badge badge-soft-warning">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
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