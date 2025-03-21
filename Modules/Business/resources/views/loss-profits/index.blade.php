@extends('business::layouts.master')

@section('title')
    {{ __('Loss Profit') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">

            <div class="card">

                <div class="card-bodys">
                    <div class="table-header p-16 d-print-none">
                        <h4>{{ __('Loss Profit List') }}</h4>
                    </div>
                    {{-- search bar --}}


                    <div class="loss-profit-container d-print-none">
                        <div class="row">
                            <div class="col-lg-2 col-md-12 ">
                                <div class="loss-card p-3 m-2 text-white">
                                    <p class="stat-title">{{ __('Loss') }}</p>
                                    <p class="stat-value">{{ currency_format($loss, 'icon', 2, business_currency()) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 ">
                                <div class="profit-card p-3 m-2 text-white">
                                    <p class="stat-title">{{ __('Profit') }}</p>
                                    <p class="stat-value">{{ currency_format($profit, 'icon', 2, business_currency()) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 ">
                                <div class="sales-card p-3 m-2 text-white">
                                    <p class="stat-title">{{ __('Total Sale') }}</p>
                                    <p class="stat-value">{{ $total_sale }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
                        @include('business::print.header')
                        <h4 class="mt-2">{{ __('Product List') }}</h4>
                    </div>

                    <div class="table-top-form p-16">
                        <div class="loss-profit-form-container d-print-none">

                            <form action="{{ route('business.loss-profits.filter') }}" method="post" class="filter-form"
                                table="#loss-profit-data">
                                @csrf
                                <div class="table-top-left d-flex gap-3">
                                    <div class="gpt-up-down-arrow position-relative d-print-none">
                                        <select name="per_page" class="form-control">
                                            <option value="10">{{ __('Show- 10') }}</option>
                                            <option value="25">{{ __('Show- 25') }}</option>
                                            <option value="50">{{ __('Show- 50') }}</option>
                                            <option value="100">{{ __('Show- 100') }}</option>
                                        </select>
                                        <span></span>
                                    </div>
                                    <div class="table-search position-relative d-print-none">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="{{ __('Search...') }}">
                                        <span class="position-absolute">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                                </svg>

                                        </span>
                                    </div>
                                </div>
                            </form>

                            <div class="m-0 p-0">
                                <form action="{{ route('business.loss-profits.filter') }}" method="post"
                                    class="filter-form" table="#loss-profit-data">
                                    @csrf
                                    <div class="d-flex align-items-center justify-items-center mt-0 gap-3 loss-profit-date-range">
                                        <div class="input-wrapper align-items-center ">
                                            <label class="header-label">{{ __('From Date') }}</label>
                                            <input type="date" name="from_date"
                                                value="{{ \Carbon\Carbon::now()->startOfYear()->format('Y-m-d') }}"
                                                class="form-control">
                                        </div>
                                        <div class="input-wrapper align-items-center ">
                                            <label class="header-label">{{ __('To Date') }}</label>
                                            <input type="date" name="to_date"
                                                value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-top-btn-group d-print-none">
                            <ul>

                                <li>
                                    <a href="{{ route('business.loss-profits.csv') }}">
                                        <img src="{{ asset('assets/images/logo/csv.svg') }}" alt="">
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('business.loss-profits.excel') }}">
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
                                <th class="text-start">{{ __('Invoice') }}</th>
                                <th class="text-start">{{ __('Name') }}</th>
                                <th class="text-start">{{ __('Total') }}</th>
                                <th class="text-start">{{ __('Loss/Profit') }}</th>
                                <th class="text-start">{{ __('Date') }}</th>
                                <th class="text-start">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody id="loss-profit-data">
                            @include('business::loss-profits.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $loss_profits->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
