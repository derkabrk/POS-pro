@extends('business::layouts.master')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-lg-8">
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

                @if ($showTopRow)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            @if ($notStaff || visible_permission('salesListPermission'))
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-primary"><i class="fas fa-shopping-cart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ __('Total Sales') }}</span>
                                        <span class="info-box-number" id="total_sales"></span>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <span class="progress-description">
                                            <span id="this_month_total_sales"></span> {{ __('This Month') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($notStaff || visible_permission('purchaseListPermission'))
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-truck"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ __('Total Purchase') }}</span>
                                        <span class="info-box-number" id="total_purchase"></span>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <span class="progress-description">
                                            <span id="this_month_total_purchase"></span> {{ __('This Month') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($notStaff || visible_permission('addIncomePermission'))
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ __('Total Income') }}</span>
                                        <span class="info-box-number" id="total_income"></span>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <span class="progress-description">
                                            <span id="this_month_total_income"></span> {{ __('This Month') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($notStaff || visible_permission('addExpensePermission'))
                            <div class="col-md-3">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="fas fa-money-bill-wave"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ __('Total Expense') }}</span>
                                        <span class="info-box-number" id="total_expense"></span>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" style="width: 100%"></div>
                                        </div>
                                        <span class="progress-description">
                                            <span id="this_month_total_expense"></span> {{ __('This Month') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if ($notStaff || visible_permission('lossProfitPermission'))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Revenue Statistic') }}</h3>
                        <div class="card-tools">
                            <select class="form-control revenue-year">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="revenueChart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">{{ __('Profit') }}: <strong class="profit-value"></strong></li>
                                    <li class="list-group-item">{{ __('Loss') }}: <strong class="loss-value"></strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                @if ($notStaff || visible_permission('stockPermission'))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Low Stock') }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('business.stocks.index', ['alert_qty' => true]) }}" class="btn btn-tool">{{ __('View All') }}</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('SL') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th class="text-center">{{ __('Alert Qty') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $stock->productName }}</td>
                                    <td class="text-center {{ $stock->productStock <= $stock->alert_qty ? 'text-danger' : 'text-success' }}">{{ $stock->productStock }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if ($notStaff || visible_permission('reportsPermission'))
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Overall Reports') }}</h3>
                        <div class="card-tools">
                            <select class="form-control overview-year">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option @selected($i == date('Y')) value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="Overallreports"></canvas>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">{{ __('Purchase') }}: <strong id="overall_purchase"></strong></li>
                                    <li class="list-group-item">{{ __('Sales') }}: <strong id="overall_sale"></strong></li>
                                    <li class="list-group-item">{{ __('Income') }}: <strong id="overall_income"></strong></li>
                                    <li class="list-group-item">{{ __('Expense') }}: <strong id="overall_expense"></strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if ($showBottomRow)
        <div class="card mt-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    @if ($notStaff || visible_permission('salesListPermission'))
                    <li class="nav-item">
                        <a class="nav-link active" href="#sales" data-toggle="tab">{{ __('Recent Sales') }}</a>
                    </li>
                    @endif
                    @if ($notStaff || visible_permission('purchaseListPermission'))
                    <li class="nav-item">
                        <a class="nav-link" href="#purchase" data-toggle="tab">{{ __('Recent Purchase') }}</a>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    @if ($notStaff || visible_permission('salesListPermission'))
                    <div class="tab-pane active" id="sales">
                        <table class="table table-striped">
                            <thead>
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
                    @endif
                    @if ($notStaff || visible_permission('purchaseListPermission'))
                    <div class="tab-pane" id="purchase">
                        <table class="table table-striped">
                            <thead>
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
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    @php
        $currency = business_currency();
    @endphp
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




