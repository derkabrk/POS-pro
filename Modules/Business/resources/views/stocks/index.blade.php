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
    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-bottom-0">
            <h4 class="mb-0 fw-semibold text-dark">{{ __('Stock List') }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('business.stocks.csv') }}" class="btn btn-outline-secondary btn-sm rounded-pill"><i class="ri-file-list-2-line me-1"></i>CSV</a>
                <a href="{{ route('business.stocks.excel') }}" class="btn btn-outline-success btn-sm rounded-pill"><i class="ri-file-excel-2-line me-1"></i>Excel</a>
                <a onclick="window.print()" class="btn btn-outline-primary btn-sm rounded-pill print-window"><i class="ri-printer-line me-1"></i>{{ __('Print') }}</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('business.stocks.filter', ['alert_qty' => request('alert_qty')]) }}" method="post" class="row g-3 align-items-center mb-3 filter-form" table="#stock-data">
                @csrf
                <div class="col-auto">
                    <select name="per_page" class="form-select form-select-sm">
                        <option value="10">{{__('Show- 10')}}</option>
                        <option value="25">{{__('Show- 25')}}</option>
                        <option value="50">{{__('Show- 50')}}</option>
                        <option value="100">{{__('Show- 100')}}</option>
                    </select>
                </div>
                <div class="col-auto flex-grow-1">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                        <span class="input-group-text bg-light"><i class="ri-search-line"></i></span>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-striped" id="datatable">
                    <thead class="table-light">
                        <tr>
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



