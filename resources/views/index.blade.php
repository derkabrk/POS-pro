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
                        <!-- card -->
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{ __('Subscription Plan') }}</h4>
                                <div class="flex-shrink-0">
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
                        <!-- end card -->
                    </div>
                    <!-- end col -->
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
        // Initialize and load dashboard data
        document.addEventListener("DOMContentLoaded", function() {
            // Get the URLs from hidden fields
            var dashboardURL = document.getElementById('get-dashboard').value;
            var plansOverviewURL = document.getElementById('get-plans-overview').value;
            var subscriptionsURL = document.getElementById('yearly-subscriptions-url').value;

            // Get currency information
            var currencySymbol = document.getElementById('currency_symbol').value;
            var currencyPosition = document.getElementById('currency_position').value;
            
            // Load dashboard stats
            fetch(dashboardURL)
                .then(response => response.json())
                .then(data => {
                    // Update dashboard statistics
                    document.getElementById('total_businesses').textContent = data.total_businesses || '0';
                    document.getElementById('expired_businesses').textContent = data.expired_businesses || '0';
                    document.getElementById('plan_subscribes').textContent = data.plan_subscribes || '0';
                    document.getElementById('business_categories').textContent = data.business_categories || '0';
                    document.getElementById('total_plans').textContent = data.total_plans || '0';
                    
                    // Add animation effect to the counters
                    animateCounters();
                })
                .catch(error => console.error('Error loading dashboard data:', error));
                
            // Initialize both charts with current year
            const currentYear = new Date().getFullYear();
            loadYearlyStatistics(currentYear);
            loadPlansOverview(currentYear);
            
            // Add event listeners for year selection
            document.querySelector('.yearly-statistics').addEventListener('change', function() {
                loadYearlyStatistics(this.value);
            });
            
            document.querySelector('.overview-year').addEventListener('change', function() {
                loadPlansOverview(this.value);
            });
            
            // Function to load yearly statistics
            function loadYearlyStatistics(year) {
                fetch(`${subscriptionsURL}?year=${year}`)
                    .then(response => response.json())
                    .then(data => {
                        // Set income value
                        let incomeElements = document.querySelectorAll('.income-value');
                        incomeElements.forEach(element => {
                            let amount = formatCurrency(data.total, currencySymbol, currencyPosition);
                            element.textContent = amount;
                        });
                        
                        // Initialize chart
                        initMonthlyChart(data.months, data.values);
                    })
                    .catch(error => console.error('Error loading yearly statistics:', error));
            }
            
            // Function to load plans overview
            function loadPlansOverview(year) {
                fetch(`${plansOverviewURL}?year=${year}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Plans data:", data); // Debug: log the data
                        // Use either the new API format or fallback to original format
                        const plans = data.plans || data.labels || [];
                        const values = data.values || data.data || [];
                        const colors = data.colors || null;
                        
                        // Force data if none returned (for testing)
                        if (plans.length === 0 || values.length === 0) {
                            console.warn("No plan data found, using test data");
                            initPlansChart(
                                ['Free', 'Standard', 'Premium'], 
                                [30, 50, 20],
                                ['#8b5cf6', '#10b981', '#f97316']
                            );
                        } else {
                            initPlansChart(plans, values, colors);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading plans overview:', error);
                        // Fallback to test data on error
                        initPlansChart(
                            ['Free', 'Standard', 'Premium'], 
                            [30, 50, 20],
                            ['#8b5cf6', '#10b981', '#f97316']
                        );
                    });
            }
            
            // Initialize monthly statistics chart
            function initMonthlyChart(months, values) {
                const ctx = document.getElementById('monthly-statistics').getContext('2d');
                
                // Destroy existing chart if it exists
                if (window.monthlyChart instanceof Chart) {
                    window.monthlyChart.destroy();
                }
                
                window.monthlyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Monthly Subscription',
                            data: values,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // Initialize plans chart
            function initPlansChart(plans, values, colors) {
                const ctx = document.getElementById('plans-chart').getContext('2d');
                
                // Destroy existing chart if it exists
                if (window.plansChart instanceof Chart) {
                    window.plansChart.destroy();
                }
                
                // Default colors if none provided
                const defaultColors = [
                    'rgba(59, 130, 246, 0.7)',  // Blue
                    'rgba(16, 185, 129, 0.7)',  // Green
                    'rgba(249, 115, 22, 0.7)',  // Orange
                    'rgba(236, 72, 153, 0.7)',  // Pink
                    'rgba(139, 92, 246, 0.7)'   // Purple
                ];
                
                console.log("Initializing plans chart with:", {plans, values, colors}); // Debug
                
                window.plansChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: plans,
                        datasets: [{
                            data: values,
                            backgroundColor: colors || defaultColors.slice(0, plans.length),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Format currency based on position
            function formatCurrency(amount, symbol, position) {
                if (position === 'left') {
                    return `${symbol}${amount}`;
                } else {
                    return `${amount}${symbol}`;
                }
            }
            
            // Counter animation function
            function animateCounters() {
                var counterElements = document.querySelectorAll('.fs-22.fw-semibold');
                counterElements.forEach(function(element) {
                    var current = 0;
                    var target = parseInt(element.innerText);
                    if (isNaN(target) || target === 0) return;
                    
                    var increment = target > 1000 ? 25 : (target > 100 ? 5 : 1);
                    var duration = 1000;
                    var steps = Math.ceil(duration / 30);
                    var step = Math.ceil(target / steps);
                    
                    var initialValue = element.innerText;
                    element.innerText = '0';
                    
                    var timer = setInterval(function() {
                        current += step;
                        if (current >= target) {
                            element.innerText = initialValue;
                            clearInterval(timer);
                        } else {
                            element.innerText = current;
                        }
                    }, 30);
                });
            }
        });
    </script>
@endsection