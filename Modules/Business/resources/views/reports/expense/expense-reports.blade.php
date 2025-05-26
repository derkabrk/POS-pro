@extends('business::layouts.master')

@section('title')
{{ __('Expense Reports') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Expense Report List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4 d-flex gap-3 d-print-none">
                    <div class="profit-card p-3 text-white">
                        <p class="stat-title">{{ __('Total Amount') }}</p>
                        <p class="stat-value" id="total_expense">{{ currency_format($total_expense, 'icon', 2, business_currency()) }}</p>
                    </div>
                </div>
                <form action="{{ route('business.expense-reports.filter') }}" method="post" class="report-filter-form d-flex align-items-center gap-3 flex-wrap" table="#expense-reports-data">
                    @csrf
                    <div class="row g-3 w-100">
                        <div class="col-xxl-2 col-sm-6">
                            <select name="per_page" class="form-control">
                                <option value="10">{{__('Show- 10')}}</option>
                                <option value="25">{{__('Show- 25')}}</option>
                                <option value="50">{{__('Show- 50')}}</option>
                                <option value="100">{{__('Show- 100')}}</option>
                            </select>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <!-- Add more filters if needed -->
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <select name="custom_days" class="form-control custom-days">
                                <option value="today">{{__('Today')}}</option>
                                <option value="yesterday">{{__('Yesterday')}}</option>
                                <option value="last_seven_days">{{__('Last 7 Days')}}</option>
                                <option value="last_thirty_days">{{__('Last 30 Days')}}</option>
                                <option value="current_month">{{__('Current Month')}}</option>
                                <option value="last_month">{{__('Last Month')}}</option>
                                <option value="current_year">{{__('Current Year')}}</option>
                                <option value="custom_date">{{__('Custom Date')}}</option>
                            </select>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <input type="date" name="from_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <input type="date" name="to_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
                        </div>
                    </div>
                </form>
                <div class="table-top-btn-group d-flex gap-2 my-3 d-print-none">
                    <a href="{{ route('business.expense-reports.csv') }}" class="btn btn-secondary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                        <i class="ri-file-list-2-line me-1"></i> CSV
                    </a>
                    <a href="{{ route('business.expense-reports.excel') }}" class="btn btn-success btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                        <i class="ri-file-excel-2-line me-1"></i> Excel
                    </a>
                    <a onclick="window.print()" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm print-window">
                        <i class="ri-printer-line me-1"></i> Print
                    </a>
                </div>
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="expenseReportsTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th>{{ __('SL') }}.</th>
                                <th class="text-start">{{ __('Amount') }}</th>
                                <th class="text-start">{{ __('Category') }}</th>
                                <th class="text-start">{{ __('Expense For') }}</th>
                                <th class="text-start">{{ __('Payment Type') }}</th>
                                <th class="text-start">{{ __('Reference Number') }}</th>
                                <th class="text-start">{{ __('Expense Date') }}</th>
                            </tr>
                        </thead>
                        <tbody id="expense-reports-data">
                            @include('business::reports.expense.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $expense_reports->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



