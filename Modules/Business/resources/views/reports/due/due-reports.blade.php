@extends('business::layouts.master')

@section('title')
{{ __('Customer Due Reports') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Customer Due List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4 d-flex gap-3 d-print-none">
                    <div class="profit-card p-3 text-white">
                        <p class="stat-title">{{ __("Total Due") }}</p>
                        <p class="stat-value">{{ currency_format($total_due, 'icon', 2, business_currency()) }}</p>
                    </div>
                </div>
                <form action="{{ route('business.due-reports.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3 flex-wrap" table="#due-reports-data">
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
                    </div>
                </form>
                <div class="table-top-btn-group d-flex gap-2 my-3 d-print-none">
                    <a href="{{ route('business.due-reports.csv') }}" class="btn btn-secondary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                        <i class="ri-file-list-2-line me-1"></i> CSV
                    </a>
                    <a href="{{ route('business.due-reports.excel') }}" class="btn btn-success btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                        <i class="ri-file-excel-2-line me-1"></i> Excel
                    </a>
                    <a onclick="window.print()" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm print-window">
                        <i class="ri-printer-line me-1"></i> Print
                    </a>
                </div>
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="dueReportsTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th>{{ __('SL') }}.</th>
                                <th class="text-start">{{ __('Name') }}</th>
                                <th class="text-start">{{ __('Email') }}</th>
                                <th class="text-start">{{ __('Phone') }}</th>
                                <th class="text-start">{{ __('Type') }}</th>
                                <th class="text-start">{{ __('Due Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody id="due-reports-data">
                            @include('business::reports.due.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $due_lists->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



