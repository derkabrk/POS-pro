@extends('business::layouts.master')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('main_content')
    <div class="container-fluid m-h-100">
        <div class="row gpt-dashboard-chart mb-30">
            <div class="col-md-12 col-lg-12 col-xl-8">
                @php
                    $notStaff = auth()->user()->role != 'staff';
                    $hasPermission = (
                        visible_permission('salesListPermission') ||
                        visible_permission('purchaseListPermission') ||
                        visible_permission('addIncomePermission') ||
                        visible_permission('addExpensePermission') ||
                        visible_permission('partiesPermission') ||
                        visible_permission('stockPermission')||
                        visible_permission('shippingPermission')
                    );

                    $SalePurchasePermission = (
                        visible_permission('salesListPermission') ||
                        visible_permission('purchaseListPermission')
                    );

                    $showTopRow = $notStaff || $hasPermission;
                    $showBottomRow = $notStaff || $SalePurchasePermission;
                @endphp

                @if ($showTopRow)
                <div class="business-stat-container mb-4">
                    <div class="business-stat">
                        @if ($notStaff || visible_permission('salesListPermission'))
                        <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title" >{{ __('Total Sales') }}</p>
                                    <h4 class="bus-stat-count" id="total_sales"></h4>
                                </div>
                                <div class="custom-image-bg color-1">
                                    <img src="{{ asset('assets/images/dashboard/Frame1.svg') }}" alt="" >
                                </div>

                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2" >
                                <img src="{{ asset('assets/images/dashboard/arrowProfit.svg') }}"
                                    alt="">
                               <span class="profit" id="this_month_total_sales"></span> <span class="bus-stat-title">{{ __('This Month') }} </span> </p>
                            </div>
                        </div>
                        @endif
                        @if ($notStaff || visible_permission('purchaseListPermission'))
                        <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title">{{ __('Total Purchase') }}</p>
                                    <h4 class="bus-stat-count" id="total_purchase"></h4>
                                </div>
                                <div class="custom-image-bg color-2">
                                    <img src="{{ asset('assets/images/dashboard/Frame2.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2">
                                <img src="{{ asset('assets/images/dashboard/arrowProfit.svg') }}"
                                    alt="">
                               <span class="profit" id="this_month_total_purchase"></span> <span class="bus-stat-title">{{ __('This Month') }} </span> </p>
                            </div>
                        </div>
                        @endif
                        @if ($notStaff || visible_permission('addIncomePermission'))
                            <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title">{{ __('Total Income') }}</p>
                                    <h4 class="bus-stat-count" id="total_income"></h4>
                                </div>
                                <div class="custom-image-bg color-3">
                                    <img src="{{ asset('assets/images/dashboard/Frame3.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2">
                                <img src="{{ asset('assets/images/dashboard/arrowLoss.svg') }}" alt="">
                               <span class="profit" id="this_month_total_income"></span> <span class="bus-stat-title">{{ __('This Month') }} </span> </p>
                            </div>
                        </div>
                        @endif
                        @if ($notStaff || visible_permission('addExpensePermission'))
                            <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title">{{ __('Total Expense') }}</p>
                                    <h4 class="bus-stat-count" id="total_expense"></h4>
                                </div>
                                <div class="custom-image-bg color-4">
                                    <img src="{{ asset('assets/images/dashboard/Frame4.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2">
                                <img src="{{ asset('assets/images/dashboard/arrowProfit.svg') }}"
                                    alt="">
                               <span class="profit" id="this_month_total_expense"></span> <span class="bus-stat-title">{{ __('This Month') }}</span> </p>
                            </div>
                        </div>
                        @endif
                        {{-- 2nd row --}}
                        @if ($notStaff || visible_permission('partiesPermission'))
                            <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title">{{ __('Total Customer') }}</p>
                                    <h4 class="bus-stat-count" id="total_customer"></h4>
                                </div>
                                <div class="custom-image-bg color-5">
                                    <img src="{{ asset('assets/images/dashboard/Frame5.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2" >
                                <img src="{{ asset('assets/images/dashboard/arrowProfit.svg') }}"
                                    alt="">
                               <span class="profit" id="this_month_total_customer"></span> <span class="bus-stat-title">{{ __('This Month') }}</span> </p>
                            </div>
                        </div>
                        <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title">{{ __('Total Supplier') }}</p>
                                    <h4 class="bus-stat-count" id="total_supplier"></h4>
                                </div>
                                <div class="custom-image-bg color-6">
                                    <img src="{{ asset('assets/images/dashboard/Frame6.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2" >
                                <img src="{{ asset('assets/images/dashboard/arrowProfit.svg') }}"
                                    alt="">
                               <span class="profit" id="this_month_total_supplier"></span> <span class="bus-stat-title">{{ __('This Month') }}</span> </p>
                            </div>
                        </div>
                        @endif
                        @if ($notStaff || visible_permission('salesListPermission'))
                        <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title">{{ __('Sales Returns') }}</p>
                                    <h4 class="bus-stat-count" id="total_sales_return"></h4>
                                </div>
                                <div class="custom-image-bg color-7">
                                    <img src="{{ asset('assets/images/dashboard/Frame7.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2" >
                                <img src="{{ asset('assets/images/dashboard/arrowProfit.svg') }}"
                                    alt="">
                               <span class="profit" id="this_month_total_sale_return"></span> <span class="bus-stat-title">{{ __('This Month') }}</span> </p>
                            </div>
                        </div>
                        @endif
                        @if ($notStaff || visible_permission('purchaseListPermission'))
                        <div class="business-content">
                            <div class="d-flex justify-content-between pt-2 pb-1 px-2 gap-1">
                                <div class="d-flex flex-column">
                                    <p class="bus-stat-title">{{ __('Purchase Returns') }}</p>
                                    <h4 class="bus-stat-count" id="total_purchase_return"></h4>
                                </div>
                                <div class="custom-image-bg color-8">
                                    <img src="{{ asset('assets/images/dashboard/Frame8.svg') }}" alt="">
                                </div>
                            </div>
                            <div class="bus-profit d-flex items-start justify-between gap-1 px-2 pt-2" >
                                <img src="{{ asset('assets/images/dashboard/arrowProfit.svg') }}"
                                    alt="">
                               <span class="profit" id="this_month_total_purchase_return"></span> <span class="bus-stat-title">{{ __('This Month') }}</span> </p>
                            </div>
                        </div>
                        @endif
                  </div>
                </div>
                @endif
                {{-- 2nd column --}}
                @if ($notStaff || visible_permission('lossProfitPermission'))
                <div class="card new-card dashboard-card border-0 p-0 mt-2">
                    <div class="dashboard-chart">
                        <h4>{{ __('Revenue Statistic') }}</h4>
                        <div class="gpt-up-down-arrow position-relative">
                            <select class="form-control revenue-year">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class=" d-flex align-items-center justify-content-center gap-3 pb-2">
                            <div class="d-flex align-items-center gap-1">
                                <div class="profit-bulet"></div>
                                <p>{{ __('Profit') }}: <strong class="profit-value"></strong></p>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <div class="loss-bulet"></div>
                                <p>{{ __('Loss') }}: <strong class="loss-value"></strong></p>
                            </div>
                        </div>
                        <div class="content">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-12 col-lg-12 col-xl-4">
                <div class="row mx-auto gap-3">
                    @if ($notStaff || visible_permission('stockPermission'))
                    <div class="dashborad-table-container col-lg-8 col-xl-12 mb-1 p-0 m-0 left-margin-top">
                        <div class="dashboard-table-header">
                            <h3>{{ __('Low Stock') }}</h3>
                             <a href="{{ route('business.stocks.index', ['alert_qty' => true]) }}">{{ __('View All') }}<i class="fas fa-chevron-right"></i></a>
                        </div>
                        <table class="table dashboard-table-content">
                            <thead class="thead-light business-thead">
                                <tr>
                                    <th scope="col">{{ __('SL') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col" class="text-center">{{ __('Alert Qty') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $stock->productName }}</td>
                                        @if ($stock->productStock <= $stock->alert_qty)
                                            <td class="text-danger text-center">{{ $stock->productStock }}</td>
                                        @else
                                            <td class="text-success text-center">{{ $stock->productStock }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    {{-- 2nd column --}}
                        @if ($notStaff || visible_permission('reportsPermission'))
                        <div class="card new-card sms-report border-0 p-0 mt-2 col-lg-4 col-xl-12 right-margin-top">
                        <div class="dashboard-chart">
                            <h4>{{ __('Overall Reports') }}</h4>
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
                            <div class="overallContent row">
                                <div class="col-lg-7">
                                    <canvas id="Overallreports"></canvas>
                                </div>
                                <div class="col-lg-5 overall-level-container">
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="purchase-bulet"></div>
                                        <p>{{ __('Purchase') }}: <strong id="overall_purchase"></strong></p>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <div class="sales-bulet"></div>
                                        <p>{{ __('Sales') }}: <strong id="overall_sale"></strong></p>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                    <div class="income-bulet"></div>
                                    <p>{{ __('Income') }}: <strong id="overall_income"></strong></p>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                    <div class="expense-bulet"></div>
                                    <p>{{ __('Expense') }}: <strong id="overall_expense"></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($showBottomRow)
        <div class=" tab-table-container">
            <div class="custom-tabs">
                @if ($notStaff || visible_permission('salesListPermission'))
                <button class="tab-item active" onclick="showTab('sales')">{{ __('Recent Sales') }}</button>
                @endif
                @if ($notStaff || visible_permission('purchaseListPermission'))
                <button class="tab-item" onclick="showTab('purchase')">{{ __('Recent Purchase') }}</button>
                @endif
            </div>
            @if ($notStaff || visible_permission('salesListPermission'))
            <div id="sales" class="tab-content dashboard-tab active">
                <div class="table-container">
                    <table class="table dashboard-table-content">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-start"  scope="col">{{ __('Date') }}</th>
                                <th class="text-center"  scope="col">{{ __('Invoice') }}</th>
                                <th class="text-center"  scope="col">{{ __('Customer') }}</th>
                                <th class="text-center"  scope="col">{{ __('Total') }}</th>
                                <th class="text-center"  scope="col">{{ __('Paid') }}</th>
                                <th class="text-center pr-3" scope="col">{{ __('Due') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td class="text-start">{{ formatted_date($sale->created_at) }}</td>
                                    <td class="text-center">{{ $sale->invoiceNumber }}</td>
                                    <td class="text-center">{{ $sale->party->name ?? '' }}</td>
                                    <td class="text-center">{{ currency_format($sale->totalAmount, 'icon', 2, business_currency()) }}</td>
                                    <td class="text-center">{{ currency_format($sale->paidAmount, 'icon', 2, business_currency()) }}</td>
                                    <td class="text-center pr-3">{{ currency_format($sale->dueAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @if ($notStaff || visible_permission('purchaseListPermission'))
            <div id="purchase" class="tab-content dashboard-tab">
                <div class="table-container">
                    <table class="table dashboard-table-content">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-start" scope="col">{{ __("Date") }}</th>
                                <th class="text-center" scope="col">{{ __("Invoice") }}</th>
                                <th class="text-center" scope="col">{{ __("Customer") }}</th>
                                <th class="text-center" scope="col">{{ __("Total") }}</th>
                                <th class="text-center" scope="col">{{ __("Paid") }}</th>
                                <th class="text-center pr-3" scope="col">{{ __("Due") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $purchase)
                                <tr>
                                    <td class="text-start">{{ formatted_date($purchase->created_at) }}</td>
                                    <td class="text-center">{{ $purchase->invoiceNumber }}</td>
                                    <td class="text-center">{{ $purchase->party->name ?? '' }}</td>
                                    <td class="text-center">{{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}</td>
                                    <td class="text-center">{{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
                                    <td class="text-center pr-3">{{ currency_format($purchase->dueAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        @endif
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

@push('js')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/business-dashboard.js') }}"></script>
@endpush




