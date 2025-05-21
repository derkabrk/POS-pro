@extends('layouts.master')
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Business
        @endslot
    @endcomponent

    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">{{ __('Welcome to Your Dashboard') }}</h4>
                                <p class="text-muted mb-0">{{ __("Here's what's happening with your businesses today.") }}</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text" class="form-control dash-filter-picker"
                                                    data-provider="flatpickr" data-range-date="true"
                                                    data-date-format="d M, Y">
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-soft-primary"><i
                                                    class="ri-add-circle-line align-middle me-1"></i> {{ __('Add Business') }}</button>
                                        </div>
                                        <!--end col-->
                                        <div class="col-auto">
                                            <button type="button"
                                                class="btn btn-soft-primary btn-icon waves-effect waves-light layout-rightside-btn"><i
                                                    class="ri-pulse-line"></i></button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Shop') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_businesses"></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                            <i class="bx bx-store text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Expired Businesses') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="expired_businesses"></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="bx bx-time-five text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-2 col-md-4">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Plan Subscribes') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="plan_subscribes"></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-user-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-2 col-md-4">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Categories') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="business_categories"></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-category text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-2 col-md-4">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Plans') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_plans"></h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                            <i class="bx bx-wallet text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->

                <div class="row">
                    <div class="col-xl-8">
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

                            <div class="card-header p-0 border-0 bg-light-subtle">
                                <div class="row g-0 text-center">
                                    <div class="col-12">
                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                            <div class="d-flex justify-content-center">
                                                <div>Total Subscription: <span class="text-success fw-semibold income-value"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

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
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-4">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{ __('Subscription Plan') }}</h4>
                            </div>
                            <div class="card-body">
                                <div id="simple_pie_chart"
                                    data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                                    class="apex-charts donut-chart" dir="ltr"></div>
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
                                        <i class="ri-list-check me-1 align-middle"></i> {{ __('View All') }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-nowrap mb-0 table-borderless table-centered align-middle">
                                        <thead class="table-light">
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
                                                            <span class="badge bg-secondary-subtle text-secondary">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
                                                        @elseif($business->enrolled_plan?->plan?->subscriptionName == 'Premium')
                                                            <span class="badge bg-success-subtle text-success">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
                                                        @elseif($business->enrolled_plan?->plan?->subscriptionName == 'Standard')
                                                            <span class="badge bg-warning-subtle text-warning">{{ $business->enrolled_plan?->plan?->subscriptionName }}</span>
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
        </div>

        <div class="col-auto layout-rightside-col">
            <div class="overlay"></div>
            <div class="layout-rightside">
                <div class="card h-100 rounded-0 card-border-effect-none">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <h6 class="text-muted mb-0 text-uppercase fw-semibold">{{ __('Business Activities') }}</h6>
                        </div>
                        <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                            <div class="acitivity-timeline acitivity-main">
                                <div class="acitivity-item d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                            <i class="ri-store-2-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">New business registration</h6>
                                        <p class="text-muted mb-1">A new business has been registered</p>
                                        <small class="mb-0 text-muted">10:30 AM Today</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                            <i class="ri-close-circle-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Business subscription expired</h6>
                                        <p class="text-muted mb-1">A business subscription has expired</p>
                                        <small class="mb-0 text-muted">Yesterday</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-info-subtle text-info rounded-circle">
                                            <i class="ri-award-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Premium plan subscription</h6>
                                        <p class="text-muted mb-1">A business upgraded to premium plan</p>
                                        <small class="mb-0 text-muted">2 days ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 mt-2">
                            <h6 class="text-muted mb-3 text-uppercase fw-semibold">{{ __('Top Business Categories') }}
                            </h6>

                            <ol class="ps-3 text-muted">
                                <li class="py-1">
                                    <a href="#" class="text-muted">Restaurants <span
                                            class="float-end">(14)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Retail <span
                                            class="float-end">(12)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Services <span
                                            class="float-end">(10)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Health & Wellness <span
                                            class="float-end">(7)</span></a>
                                </li>
                                <li class="py-1">
                                    <a href="#" class="text-muted">Technology <span
                                            class="float-end">(5)</span></a>
                                </li>
                            </ol>
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

@section('script')
    <!-- Chart.js and dashboard functionality -->
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/dashboard.js') }}"></script>
    
    <!-- Modern UI support scripts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var plans = @json($plans ?? []);
            var values = @json($planValues ?? []);
            var colors = [
                getComputedStyle(document.documentElement).getPropertyValue('--vz-primary').trim() || '#3b82f6',
                getComputedStyle(document.documentElement).getPropertyValue('--vz-success').trim() || '#10b981',
                getComputedStyle(document.documentElement).getPropertyValue('--vz-warning').trim() || '#f97316',
                getComputedStyle(document.documentElement).getPropertyValue('--vz-danger').trim() || '#ec4899',
                getComputedStyle(document.documentElement).getPropertyValue('--vz-info').trim() || '#8b5cf6'
            ];
            var options = {
                chart: {
                    type: 'donut',
                    height: 300,
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 2,
                        left: 2,
                        blur: 6,
                        opacity: 0.08
                    }
                },
                labels: plans,
                series: values,
                colors: colors.slice(0, plans.length),
                legend: {
                    position: 'bottom',
                    fontSize: '15px',
                    fontWeight: 500,
                    labels: { colors: '#333' },
                    itemMargin: { horizontal: 12, vertical: 6 }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '15px',
                        fontWeight: 600,
                        colors: ['#fff']
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        color: '#222',
                        opacity: 0.25
                    },
                    formatter: function (val, opts) {
                        var total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                        var percent = total ? Math.round((val / total) * 100) : 0;
                        return percent + '%';
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val, opts) {
                            var total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            var percent = total ? Math.round((val / total) * 100) : 0;
                            return val + ' (' + percent + '%)';
                        }
                    }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['#fff']
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 0.9
                        }
                    }
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: { height: 220 },
                        legend: { fontSize: '13px' },
                        dataLabels: { style: { fontSize: '12px' } }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#simple_pie_chart.donut-chart"), options);
            chart.render();
        });
    </script>
@endsection