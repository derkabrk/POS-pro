@extends('business::layouts.master')

@section('title')
{{ __('Due List') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="mb-4 d-flex loss-flex gap-3 loss-profit-container d-print-none">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <div class="profit-card p-3 text-white">
                    <p class="stat-title">{{ __('Supplier Due') }}</p>
                    <p class="stat-value">{{ currency_format($total_supplier_due, 'icon', 2, business_currency()) }}</p>
                </div>
                <div class="loss-card p-3 text-white">
                    <p class="stat-title">{{ __('Customer Due') }}</p>
                    <p class="stat-value">{{ currency_format($total_customer_due, 'icon', 2, business_currency()) }}</p>
                </div>
            </div>
        </div>
        <div class="card" id="dueList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Due List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.dues.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3 mb-3" table="#due-reports-data">
                    @csrf
                    <div class="row g-3 w-100">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select name="per_page" class="form-control">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card mb-1">
                    <table class="table table-nowrap align-middle" id="dueTable">
                        <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                            <th>{{ __('SL') }}.</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Due Amount') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody id="due-reports-data">
                            @include('business::dues.datas')
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="pagination-wrap hstack gap-2">
                        {{ $dues->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



