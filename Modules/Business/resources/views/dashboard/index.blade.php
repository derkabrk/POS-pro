@extends('business::layouts.master')

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
                                <h4 class="fs-16 mb-1">{{ __('Welcome to Your Business Dashboard') }}</h4>
                                <p class="text-muted mb-0">{{ __("Here's what's happening with your business today.") }}</p>
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
                                            <button type="button" class="btn btn-soft-primary btn-icon waves-effect waves-light layout-rightside-btn"><i
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

                @php
                    $notStaff = auth()->user()->role != 'staff';
                    $hasPermission = (
                        visible_permission('salesListPermission') ||
                        visible_permission('purchaseListPermission') ||
                        visible_permission('addIncomePermission') ||
                        visible_permission('addExpensePermission') ||
                        visible_permission('partiesPermission') ||
                        visible_permission('stockPermission') ||
                        visible_permission('shippingPermission')
                    );

                    $SalePurchasePermission = (
                        visible_permission('salesListPermission') ||
                        visible_permission('purchaseListPermission')
                    );

                    $showTopRow = $notStaff || $hasPermission;
                    $showBottomRow = $notStaff || $SalePurchasePermission;
                @endphp

                @php
                    // Fetch card data server-side
                    $dashboardData = app(\Modules\Business\App\Http\Controllers\DashboardController::class)->getDashboardData();
                @endphp

                @if ($showTopRow)
                <!-- First Row - Main Stats -->
                <div class="row">
                    @if ($notStaff || visible_permission('salesListPermission'))
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Sales') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_sales">
                                            {{ currency_format($dashboardData['total_sales'] ?? 0, 'icon', 2, business_currency()) }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                                            <i class="ri-shopping-cart-line text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    @endif

                    @if ($notStaff || visible_permission('purchaseListPermission'))
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Purchase') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_purchase">
                                            {{ currency_format($dashboardData['total_purchase'] ?? 0, 'icon', 2, business_currency()) }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="ri-truck-line text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if ($notStaff || visible_permission('addIncomePermission'))
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Income') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_income">
                                            {{ currency_format($dashboardData['total_income'] ?? 0, 'icon', 2, business_currency()) }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="ri-money-dollar-circle-line text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if ($notStaff || visible_permission('addExpensePermission'))
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Expense') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_expense">
                                            {{ currency_format($dashboardData['total_expense'] ?? 0, 'icon', 2, business_currency()) }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                            <i class="ri-arrow-down-line text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- end row-->
                @endif

                <!-- Second Row - Additional Stats -->
                <div class="row">
                    @if ($notStaff || visible_permission('partiesPermission'))
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Parties') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_parties">0</h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="fas fa-users text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    @endif

                    @if ($notStaff || visible_permission('stockPermission'))
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Total Products') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="total_products">0</h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-secondary-subtle rounded fs-3">
                                            <i class="fas fa-boxes text-secondary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    @endif

                    @if ($notStaff || visible_permission('stockPermission'))
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Low Stock Items') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="low_stock_count">{{ count($stocks) }}</h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                            <i class="fas fa-exclamation-triangle text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    @endif

                    @if ($notStaff || visible_permission('shippingPermission'))
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ __('Pending Orders') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-0" id="pending_orders">0</h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="fas fa-clock text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    @endif
                </div> <!-- end row-->

                <div class="row">
                    @if ($notStaff || visible_permission('lossProfitPermission'))
                    <div class="col-xl-8">
                        <div class="card card-animate card-height-100 gradient-chart">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{ __('Revenue Statistic') }}</h4>
                                <div>
                                    <select class="form-select form-select-sm revenue-year">
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="card-header p-0 border-0 bg-light-subtle">
                                <div class="row g-0 text-center">
                                    <div class="col-6">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <div class="d-flex justify-content-center">
                                                <div>{{ __('Profit') }}: <span class="text-success fw-semibold profit-value"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                            <div class="d-flex justify-content-center">
                                                <div>{{ __('Loss') }}: <span class="text-danger fw-semibold loss-value"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->
                            <div class="card-body p-0 pb-2">
                                <div class="w-100">
                                    <div class="d-flex mb-2 ps-4">
                                        <div class="d-flex align-items-center me-4">
                                            <div class="flex-shrink-0 me-1">
                                                <div class="fs-14 text-success">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </div>
                                            </div>
                                            <div>{{ __('Profit') }}: <span class="text-success fw-semibold profit-value"></span></div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-1">
                                                <div class="fs-14 text-danger">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </div>
                                            </div>
                                            <div>{{ __('Loss') }}: <span class="text-danger fw-semibold loss-value"></span></div>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Line chart container -->
                                        <div id="revenueChart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    @endif

                    @if ($notStaff || visible_permission('reportsPermission'))
                    <div class="col-xl-4">
                        <div class="card card-animate card-height-100">
                            <div class="card-header border-0 align-items-center d-flex bg-light-subtle">
                                <h4 class="card-title mb-0 flex-grow-1">{{ __('Overall Reports') }}</h4>
                                <div>
                                    <select class="form-select form-select-sm overview-year">
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <div id="Overallreports" class="apex-charts w-100" style="min-height: 300px; max-width: 100%;"></div>
                                <div class="mt-3 w-100">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            {{ __('Purchase') }}: 
                                            <strong id="overall_purchase" class="text-info"></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            {{ __('Sales') }}: 
                                            <strong id="overall_sale" class="text-primary"></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            {{ __('Income') }}: 
                                            <strong id="overall_income" class="text-success"></strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                            {{ __('Expense') }}: 
                                            <strong id="overall_expense" class="text-danger"></strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                @if ($notStaff || visible_permission('stockPermission'))
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">{{ __('Low Stock Alert') }}</h4>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('business.stocks.index', ['alert_qty' => true]) }}" class="btn btn-soft-primary btn-sm">
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
                                                <th>{{ __('Product Name') }}</th>
                                                <th class="text-center">{{ __('Current Stock') }}</th>
                                                <th class="text-center">{{ __('Alert Quantity') }}</th>
                                                <th class="text-center">{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($stocks as $stock)
                                                <tr>
                                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-xs me-3">
                                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                                    <i class="ri-product-hunt-line"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ $stock->productName ?? 'N/A' }}</h6>
                                                                <small class="text-muted">{{ $stock->productCode ?? '' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ ($stock->productStock ?? 0) <= ($stock->alert_qty ?? 0) ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} fs-12">
                                                            {{ $stock->productStock ?? 0 }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">{{ $stock->alert_qty ?? 0 }}</td>
                                                    <td class="text-center">
                                                        @if (($stock->productStock ?? 0) <= ($stock->alert_qty ?? 0))
                                                            <span class="badge bg-danger-subtle text-danger">
                                                                <i class="ri-alert-line me-1"></i>{{ __('Low Stock') }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-success-subtle text-success">
                                                                <i class="ri-checkbox-circle-line me-1"></i>{{ __('In Stock') }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="avatar-md mb-2">
                                                                <span class="avatar-title rounded-circle bg-light text-body fs-2">
                                                                    <i class="ri-inbox-line"></i>
                                                                </span>
                                                            </div>
                                                            <h5 class="mb-1">{{ __('No Low Stock Items') }}</h5>
                                                            <p class="text-muted mb-0">{{ __('All products are adequately stocked') }}</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if(count($stocks) > 0)
                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        {{ __('Showing') }} {{ count($stocks) }} {{ __('items that need attention') }}
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if ($showBottomRow)
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0 flex-grow-1" role="tablist">
                                    @if ($notStaff || visible_permission('salesListPermission'))
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#sales" role="tab">
                                            {{ __('Recent Sales') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if ($notStaff || visible_permission('purchaseListPermission'))
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#purchase" role="tab">
                                            {{ __('Recent Purchase') }}
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            
                            <div class="card-body">
                                <div class="tab-content">
                                    @if ($notStaff || visible_permission('salesListPermission'))
                                    <div class="tab-pane active" id="sales">
                                        <div class="table-responsive table-card">
                                            <table class="table table-nowrap mb-0 table-borderless table-centered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>{{ __('Date') }}</th>
                                                        <th>{{ __('Invoice') }}</th>
                                                        <th>{{ __('Customer') }}</th>
                                                        <th>{{ __('Total') }}</th>
                                                        <th>{{ __('Paid') }}</th>
                                                        <th>{{ __('Due') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sales as $sale)
                                                    <tr>
                                                        <td>{{ formatted_date($sale->created_at) }}</td>
                                                        <td>{{ $sale->invoiceNumber }}</td>
                                                        <td>{{ $sale->party->name ?? '' }}</td>
                                                        <td>{{ currency_format($sale->totalAmount, 'icon', 2, business_currency()) }}</td>
                                                        <td>{{ currency_format($sale->paidAmount, 'icon', 2, business_currency()) }}</td>
                                                        <td>{{ currency_format($sale->dueAmount, 'icon', 2, business_currency()) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($notStaff || visible_permission('purchaseListPermission'))
                                    <div class="tab-pane" id="purchase">
                                        <div class="table-responsive table-card">
                                            <table class="table table-nowrap mb-0 table-borderless table-centered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>{{ __('Date') }}</th>
                                                        <th>{{ __('Invoice') }}</th>
                                                        <th>{{ __('Customer') }}</th>
                                                        <th>{{ __('Total') }}</th>
                                                        <th>{{ __('Paid') }}</th>
                                                        <th>{{ __('Due') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($purchases as $purchase)
                                                    <tr>
                                                        <td>{{ formatted_date($purchase->created_at) }}</td>
                                                        <td>{{ $purchase->invoiceNumber }}</td>
                                                        <td>{{ $purchase->party->name ?? '' }}</td>
                                                        <td>{{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}</td>
                                                        <td>{{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
                                                        <td>{{ currency_format($purchase->dueAmount, 'icon', 2, business_currency()) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
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
                                            <i class="ri-shopping-cart-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">New sale recorded</h6>
                                        <p class="text-muted mb-1">A new sale has been recorded</p>
                                        <small class="mb-0 text-muted">10:30 AM Today</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-warning-subtle text-warning rounded-circle">
                                            <i class="ri-alert-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Low stock alert</h6>
                                        <p class="text-muted mb-1">Product stock is running low</p>
                                        <small class="mb-0 text-muted">Yesterday</small>
                                    </div>
                                </div>
                                <div class="acitivity-item py-3 d-flex">
                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                        <div class="avatar-title bg-info-subtle text-info rounded-circle">
                                            <i class="ri-truck-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 lh-base">Purchase order completed</h6>
                                        <p class="text-muted mb-1">A purchase order has been completed</p>
                                        <small class="mb-0 text-muted">2 days ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 mt-2">
                            <h6 class="text-muted mb-3 text-uppercase fw-semibold">{{ __('Quick Actions') }}
                            </h6>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-soft-primary btn-sm">
                                    <i class="ri-add-line me-1"></i> {{ __('New Sale') }}
                                </button>
                                <button type="button" class="btn btn-soft-info btn-sm">
                                    <i class="ri-truck-line me-1"></i> {{ __('New Purchase') }}
                                </button>
                                <button type="button" class="btn btn-soft-success btn-sm">
                                    <i class="ri-money-dollar-circle-line me-1"></i> {{ __('Add Income') }}
                                </button>
                                <button type="button" class="btn btn-soft-danger btn-sm">
                                    <i class="ri-money-dollar-circle-line me-1"></i> {{ __('Add Expense') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $currency = business_currency();
    @endphp
    {{-- Hidden input fields to store currency details --}}
    <input type="hidden" id="currency_symbol" value="{{ $currency->symbol }}">
    <input type="hidden" id="currency_position" value="{{ $currency->position }}">
    <input type="hidden" id="currency_code" value="{{ $currency->code }}">

    <input type="hidden" value="{{ route('business.dashboard.data') }}" id="get-dashboard">
    <input type="hidden" value="{{ route('business.dashboard.overall-report') }}" id="get-overall-report">
    <input type="hidden" value="{{ route('business.dashboard.revenue') }}" id="revenue-statistic">
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- ApexCharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Other required scripts -->
    <script src="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    
    <script>
        // Global variables to store chart instances
        let revenueChart = null;
        let overallChart = null;
        let isInitialLoad = true;
        
        // Function to format currency
        function formatCurrency(value, symbol, position) {
            if (value === undefined || value === null || isNaN(parseFloat(value))) {
                value = 0;
            }
            const formattedNumber = parseFloat(value).toLocaleString();
            return position === 'left' ? symbol + formattedNumber : formattedNumber + symbol;
        }
        
        // Function to load dashboard data
        function loadDashboardData() {
            const url = $('#get-dashboard').val();
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    const currencySymbol = $('#currency_symbol').val();
                    const currencyPosition = $('#currency_position').val();
                    
                    // Update dashboard values
                    if (data.total_sales !== undefined) {
                        $('#total_sales').text(formatCurrency(data.total_sales, currencySymbol, currencyPosition));
                    }
                    if (data.total_purchase !== undefined) {
                        $('#total_purchase').text(formatCurrency(data.total_purchase, currencySymbol, currencyPosition));
                    }
                    if (data.total_income !== undefined) {
                        $('#total_income').text(formatCurrency(data.total_income, currencySymbol, currencyPosition));
                    }
                    if (data.total_expense !== undefined) {
                        $('#total_expense').text(formatCurrency(data.total_expense, currencySymbol, currencyPosition));
                    }
                    
                    // Update this month values
                    if (data.this_month_total_sales !== undefined) {
                        $('#this_month_total_sales').text(formatCurrency(data.this_month_total_sales, currencySymbol, currencyPosition));
                    }
                    if (data.this_month_total_purchase !== undefined) {
                        $('#this_month_total_purchase').text(formatCurrency(data.this_month_total_purchase, currencySymbol, currencyPosition));
                    }
                    if (data.this_month_total_income !== undefined) {
                        $('#this_month_total_income').text(formatCurrency(data.this_month_total_income, currencySymbol, currencyPosition));
                    }
                    if (data.this_month_total_expense !== undefined) {
                        $('#this_month_total_expense').text(formatCurrency(data.this_month_total_expense, currencySymbol, currencyPosition));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading dashboard data:', error);
                }
            });
        }
        
        // Function to load revenue chart
        function loadRevenueChart(year) {
            const url = $('#revenue-statistic').val();
            $.ajax({
                type: 'GET',
                url: url,
                data: { year: year },
                dataType: 'json',
                success: function(data) {
                    // Prevent infinite re-rendering
                    if (revenueChart) {
                        revenueChart.destroy();
                        revenueChart = null;
                    }
                    
                    // Format the data for the chart
                    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    let profitData = [];
                    let lossData = [];
                    
                    if (data.profit && Array.isArray(data.profit)) {
                        for (let i = 0; i < months.length; i++) {
                            profitData.push(data.profit[i] || 0);
                        }
                    } else {
                        profitData = Array(12).fill(0);
                    }
                    
                    if (data.loss && Array.isArray(data.loss)) {
                        for (let i = 0; i < months.length; i++) {
                            lossData.push(data.loss[i] || 0);
                        }
                    } else {
                        lossData = Array(12).fill(0);
                    }
                    
                    // Format and display total values
                    const currencySymbol = $('#currency_symbol').val();
                    const currencyPosition = $('#currency_position').val();
                    const totalProfit = data.totalProfit || 0;
                    const totalLoss = data.totalLoss || 0;
                    const formattedProfit = formatCurrency(totalProfit, currencySymbol, currencyPosition);
                    const formattedLoss = formatCurrency(totalLoss, currencySymbol, currencyPosition);
                    $('.profit-value').text(formattedProfit);
                    $('.loss-value').text(formattedLoss);
                    
                    // Chart options
                    const options = {
                        series: [{
                            name: 'Profit',
                            data: profitData
                        }, {
                            name: 'Loss',
                            data: lossData
                        }],
                        chart: {
                            height: 290,
                            type: 'line',
                            toolbar: { show: false },
                            zoom: { enabled: false }
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth'
                        },
                        colors: ['#10b981', '#ef4444'],
                        xaxis: {
                            categories: months
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shade: 'dark',
                                gradientToColors: ['#3b82f6', '#f97316'],
                                shadeIntensity: 1,
                                type: 'horizontal',
                                opacityFrom: 1,
                                opacityTo: 1
                            }
                        },
                        markers: {
                            size: 4,
                            colors: ['#10b981', '#ef4444'],
                            strokeColors: "#fff",
                            strokeWidth: 2,
                            hover: { size: 7 }
                        },
                        yaxis: {
                            title: { text: 'Amount' }
                        },
                        legend: {
                            position: 'top'
                        },
                        noData: {
                            text: 'No data available',
                            align: 'center',
                            verticalAlign: 'middle',
                            style: { color: '#ccc', fontSize: '16px' }
                        }
                    };
                    
                    revenueChart = new ApexCharts(document.querySelector("#revenueChart"), options);
                    revenueChart.render();
                },
                error: function(xhr, status, error) {
                    if (revenueChart) {
                        revenueChart.destroy();
                        revenueChart = null;
                    }
                    $("#revenueChart").html('<div class="text-danger p-3">Failed to load chart data</div>');
                }
            });
        }
        
        // Function to load overall reports chart
        function loadOverallChart(year) {
            const url = $('#get-overall-report').val();
            
            $.ajax({
                type: 'GET',
                url: url,
                data: { year: year },
                dataType: 'json',
                success: function(data) {
                    const currencySymbol = $('#currency_symbol').val();
                    const currencyPosition = $('#currency_position').val();
                    
                    // Update overall report values
                    if (data.overall_purchase !== undefined) {
                        $('#overall_purchase').text(formatCurrency(data.overall_purchase, currencySymbol, currencyPosition));
                    }
                    if (data.overall_sale !== undefined) {
                        $('#overall_sale').text(formatCurrency(data.overall_sale, currencySymbol, currencyPosition));
                    }
                    if (data.overall_income !== undefined) {
                        $('#overall_income').text(formatCurrency(data.overall_income, currencySymbol, currencyPosition));
                    }
                    if (data.overall_expense !== undefined) {
                        $('#overall_expense').text(formatCurrency(data.overall_expense, currencySymbol, currencyPosition));
                    }
                    
                    const categories = ['Purchase', 'Sales', 'Income', 'Expense'];
                    const values = [
                        data.overall_purchase || 0,
                        data.overall_sale || 0,
                        data.overall_income || 0,
                        data.overall_expense || 0
                    ];
                    
                    // Default colors
                    const colors = [
                        '#3b82f6', // info (purchase)
                        '#10b981', // primary (sales)
                        '#22c55e', // success (income)
                        '#ef4444'  // danger (expense)
                    ];
                    
                    // Chart options
                    const options = {
                        series: values,
                        chart: {
                            type: 'donut',
                            height: 300,
                            zoom: { enabled: false }
                        },
                        labels: categories,
                        colors: colors,
                        legend: {
                            position: 'bottom',
                            fontSize: '14px',
                            offsetY: 5
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return Math.round(val) + '%';
                            }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '50%'
                                }
                            }
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: { height: 200 },
                                legend: { position: 'bottom' }
                            }
                        }]
                    };
                    
                    // Clear previous chart before creating a new one
                    if (overallChart) {
                        overallChart.destroy();
                    }
                    
                    // Create new chart
                    overallChart = new ApexCharts(document.querySelector("#Overallreports"), options);
                    overallChart.render();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading overall report data:', error);
                    // Clear chart if there's an error
                    if (overallChart) {
                        overallChart.destroy();
                        overallChart = null;
                    }
                    $("#Overallreports").html('<div class="text-danger p-3">Failed to load chart data</div>');
                }
            });
        }
        
        // Document ready function
        $(document).ready(function() {
            // Load initial data
            loadDashboardData();
            
            // Get current year
            const currentYear = new Date().getFullYear();
            
            // Load initial charts
            loadRevenueChart(currentYear);
            loadOverallChart(currentYear);
            
            // Event handler for revenue chart year selection
            $('.revenue-year').on('change', function() {
                const selectedYear = $(this).val();
                loadRevenueChart(selectedYear);
            });
            
            // Event handler for overall chart year selection
            $('.overview-year').on('change', function() {
                const selectedYear = $(this).val();
                loadOverallChart(selectedYear);
            });
            
            // Layout rightside button event handler
            $('.layout-rightside-btn').on('click', function() {
                $('.layout-rightside-col').toggleClass('d-block');
                $('.overlay').toggleClass('show');
            });
            
            // Close rightside when clicking overlay
            $('.overlay').on('click', function() {
                $('.layout-rightside-col').removeClass('d-block');
                $(this).removeClass('show');
            });
            
            // Bootstrap tab functionality for sales/purchase tabs
            $('[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                // Additional functionality can be added here if needed
            });
        });
    </script>
@endsection