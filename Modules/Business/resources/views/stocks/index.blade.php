@extends('business::layouts.master')

@section('title')
{{ __('Stock List') }}
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex gap-3 flex-wrap justify-content-center">
            <div class="card shadow-sm rounded-3 text-center bg-success text-white px-4 py-3 mb-2" style="min-width:200px;">
                <div class="fs-6 fw-semibold">{{ __('Total Quantity') }}</div>
                <div class="fs-4 fw-bold mt-1">{{ $total_qty }}</div>
            </div>
            <div class="card shadow-sm rounded-3 text-center bg-primary text-white px-4 py-3 mb-2" style="min-width:200px;">
                <div class="fs-6 fw-semibold">{{ __('Total Stock Value') }}</div>
                <div class="fs-4 fw-bold mt-1">{{ currency_format($total_stock_value, currency : business_currency()) }}</div>
            </div>
        </div>
    </div>
    <div class="card" id="stockList">
        <div class="card-header border-0">
            <div class="row align-items-center gy-3">
                <div class="col-sm">
                    <h5 class="card-title mb-0">{{ __('Stock List') }}</h5>
                </div>
                <div class="col-sm-auto">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('business.stocks.excel') }}" class="btn btn-success btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-file-excel-2-line me-1"></i> <span>{{ __('Export Excel') }}</span>
                        </a>
                        <a href="{{ route('business.stocks.csv') }}" class="btn btn-secondary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-file-list-2-line me-1"></i> <span>{{ __('Export CSV') }}</span>
                        </a>
                        <a onclick="window.print()" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm print-window">
                            <i class="ri-printer-line me-1"></i> <span>{{ __('Print') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border border-dashed border-end-0 border-start-0">
            <form action="{{ route('business.stocks.filter', ['alert_qty' => request('alert_qty')]) }}" method="post" class="filter-form" table="#stock-data" id="stock-search-form">
                @csrf
                <div class="row g-3">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="search-box">
                            <input type="text" class="form-control search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}" id="stock-search-input">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-sm-6">
                        <div>
                            <select class="form-control" name="per_page" id="stock_per_page">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>{{__('Show- 10')}}</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>{{__('Show- 25')}}</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>{{__('Show- 50')}}</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>{{__('Show- 100')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-sm-4">
                        <div>
                            <!-- Removed filter/search button for real-time search -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive table-card" style="margin-top:20px;">
                <table class="table table-nowrap mb-0" id="stockTable">
                    <thead class="table-light">
                        <tr class="text-uppercase">
                            <th>{{ __('SL') }}.</th>
                            <th class="text-start">{{ __('Product') }}</th>
                            <th class="text-start">{{ __('Cost') }}</th>
                            <th class="text-start">{{ __('Qty') }}</th>
                            <th class="text-center">{{ __('Sale') }}</th>
                            <th class="text-end">{{ __('Stock Value') }}</th>
                        </tr>
                    </thead>
                    <tbody id="stock-data">
                        @include('business::stocks.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $stocks->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection



