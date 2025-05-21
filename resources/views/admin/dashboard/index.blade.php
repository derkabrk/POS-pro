@extends('layouts.master')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('main_content')
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
                                <canvas id="monthly-statistics" height="290" class="gradient-line-chart"></canvas>
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
                            <canvas id="plans-chart" class="donut-chart" height="300"></canvas>
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
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
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
                    type: 'pie',
                    height: 320,
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
                        chart: { height: 260 },
                        legend: { fontSize: '13px' },
                        dataLabels: { style: { fontSize: '12px' } }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#plans-chart.donut-chart"), options);
            chart.render();

            // --- Finance Overview Chart (Gradient Line) ---
            (function() {
                // Get data from PHP variables
                var financeMonths = @json($financeMonths ?? []);
                var financeValues = @json($financeValues ?? []);
                var currencySymbol = document.getElementById('currency_symbol').value;
                var currencyPosition = document.getElementById('currency_position').value;

                // Only render if data is available and element exists
                var chartEl = document.querySelector('#monthly-statistics.gradient-line-chart');
                if (chartEl && financeMonths.length && financeValues.length) {
                    var primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--vz-primary').trim() || '#3b82f6';
                    var options = {
                        chart: {
                            type: 'line',
                            height: 290,
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
                        series: [{
                            name: 'Total Subscription',
                            data: financeValues
                        }],
                        xaxis: {
                            categories: financeMonths,
                            labels: { style: { fontSize: '13px' } }
                        },
                        yaxis: {
                            labels: {
                                formatter: function(val) {
                                    return currencyPosition === 'left' ? currencySymbol + val : val + currencySymbol;
                                },
                                style: { fontSize: '13px' }
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 4,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'light',
                                type: 'vertical',
                                shadeIntensity: 0.5,
                                gradientToColors: [primaryColor],
                                inverseColors: false,
                                opacityFrom: 0.7,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
                            }
                        },
                        markers: {
                            size: 6,
                            colors: ['#fff'],
                            strokeColors: [primaryColor],
                            strokeWidth: 3,
                            hover: { size: 8 }
                        },
                        grid: {
                            borderColor: '#e9e9e9',
                            strokeDashArray: 4,
                            yaxis: { lines: { show: true } },
                            xaxis: { lines: { show: false } }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return currencyPosition === 'left' ? currencySymbol + val : val + currencySymbol;
                                }
                            }
                        },
                        legend: { show: false },
                        responsive: [{
                            breakpoint: 600,
                            options: {
                                chart: { height: 200 },
                                xaxis: { labels: { style: { fontSize: '11px' } } },
                                yaxis: { labels: { style: { fontSize: '11px' } } }
                            }
                        }]
                    };
                    var financeChart = new ApexCharts(chartEl, options);
                    financeChart.render();
                }
            })();
        });
    </script>
@endpush