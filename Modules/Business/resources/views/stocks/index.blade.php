@extends('business::layouts.master')

@section('title')
{{ __('Stock List') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="mb-4 d-flex loss-flex  gap-3 loss-profit-container d-print-none">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <div class="profit-card p-3 text-white">
                    <p class="stat-title">{{ __('Total Quantity') }}</p>
                    <p class="stat-value">{{ $total_qty }}</p>
                </div>

                <div class="loss-card p-3 text-white">
                    <p class="stat-title">{{ __('Total Stock Value') }}</p>
                    <p class="stat-value">{{ currency_format($total_stock_value, currency : business_currency()) }}</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16 d-print-none">
                    <h4>{{ __('Stock List') }}</h4>
                </div>

                <div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
                    @include('business::print.header')
                    <h4 class="mt-2">{{ __('Stock List') }}</h4>
                </div>

                <div class="table-top-form p-16">
                    <form action="{{ route('business.stocks.filter', ['alert_qty' => request('alert_qty')]) }}" method="post" class="filter-form" table="#stock-data">
                        @csrf
                        <div class="table-top-left d-flex gap-3">
                            <div class="gpt-up-down-arrow position-relative d-print-none">
                                <select name="per_page" class="form-control">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                                <span></span>
                            </div>
                            <div class="table-search position-relative d-print-none">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                                <span class="position-absolute">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                        </svg>

                                </span>
                            </div>
                        </div>
                    </form>

                    <div class="table-top-btn-group d-print-none">
                        <ul>

                            <li>
                                <a href="{{ route('business.stocks.csv') }}">
                                    <img src="{{ asset('assets/images/logo/csv.svg') }}" alt="">
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('business.stocks.excel') }}">
                                    <img src="{{ asset('assets/images/logo/excel.svg') }}" alt="">
                                </a>
                            </li>

                            <li>
                                <a onclick="window.print()" class="print-window">
                                    <img src="{{ asset('assets/images/logo/printer.svg') }}" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="responsive-table m-0">
                <table class="table" id="datatable">
                    <thead>
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



