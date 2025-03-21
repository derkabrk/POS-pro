@extends('business::layouts.master')

@section('title')
   {{ __('Purchase Return Reports') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="mb-4 d-flex loss-flex  gap-3 loss-profit-container d-print-none">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <div class="profit-card p-3 text-white">
                    <p class="stat-title">{{ __('Total Purchase Return') }}</p>
                    <p class="stat-value" id="total_purchase_return">{{ currency_format($total_purchase_return, 'icon', 2, business_currency()) }}</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16 d-print-none">
                    <h4>{{ __('Purchase Return Report List') }}</h4>
                </div>
                <div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
                    @include('business::print.header')
                    <h4 class="mt-2">{{ __('Purchase Return Report List') }}</h4>
                </div>
                <div class="table-top-form p-16">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <form action="{{ route('business.purchase-return-reports.filter') }}" method="post" class="report-filter-form" table="#purchase-return-report-data">
                            @csrf
                            <div class="table-top-left d-flex gap-3 d-print-none">
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="per_page" class="form-control">
                                        <option value="10">{{__('Show- 10')}}</option>
                                        <option value="25">{{__('Show- 25')}}</option>
                                        <option value="50">{{__('Show- 50')}}</option>
                                        <option value="100">{{__('Show- 100')}}</option>
                                    </select>
                                    <span></span>
                                </div>
                                <div class="table-search position-relative">
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
                        <div class="m-0 p-0 d-print-none">
                            <form action="{{ route('business.purchase-return-reports.filter') }}" method="post" class="report-filter-form" table="#purchase-return-report-data">
                                @csrf
                                <div class="date-filters-container">
                                    <div class="input-wrapper align-items-center date-filters d-none">
                                        <label class="header-label">{{ __('From Date') }}</label>
                                        <input type="date" name="from_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
                                    </div>
                                    <div class="input-wrapper align-items-center date-filters d-none">
                                        <label class="header-label">{{ __('To Date') }}</label>
                                        <input type="date" name="to_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control">
                                    </div>
                                    <div class="gpt-up-down-arrow position-relative d-print-none custom-date-filter">
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
                                        <span></span>
                                        <div class="calendar-icon">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.6667 2.66797H3.33333C2.59695 2.66797 2 3.26492 2 4.0013V13.3346C2 14.071 2.59695 14.668 3.33333 14.668H12.6667C13.403 14.668 14 14.071 14 13.3346V4.0013C14 3.26492 13.403 2.66797 12.6667 2.66797Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10.666 1.33203V3.9987" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M5.33398 1.33203V3.9987" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M2 6.66797H14" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-top-btn-group d-print-none">
                        <ul>

                            <li>
                                <a href="{{ route('business.purchase-reports.csv') }}">
                                    <img src="{{ asset('assets/images/logo/csv.svg') }}" alt="">

                                </a>
                            </li>

                            <li>
                                <a href="{{ route('business.purchase-reports.excel') }}">
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
                            <th>{{ __('Invoice No') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Paid') }}</th>
                            <th>{{ __('Return Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody id="purchase-return-report-data">
                        @include('business::reports.purchase-return.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $purchases->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection



