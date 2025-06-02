@extends('business::layouts.master')

@section('title')
    {{ __('Sale Return Reports') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card" id="saleReturnList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Sale Return Report List') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.sale-return-reports.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3" table="#sale-return-reports-data">
                    @csrf
                    <div class="row g-3 w-100">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input class="form-control search" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select class="form-control" name="per_page">
                                    <option value="10">{{ __('Show- 10') }}</option>
                                    <option value="25">{{ __('Show- 25') }}</option>
                                    <option value="50">{{ __('Show- 50') }}</option>
                                    <option value="100">{{ __('Show- 100') }}</option>
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
                <div class="table-top-btn-group d-flex gap-2 mb-3">
                    <a onclick="window.print()" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm print-window">
                        <i class="ri-printer-line me-1"></i> <span>{{ __('Print') }}</span>
                    </a>
                </div>
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="saleReturnTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th> {{ __('SL') }}. </th>
                                <th> {{ __('Invoice No') }} </th>
                                <th> {{ __('Date') }} </th>
                                <th> {{ __('Name') }} </th>
                                <th> {{ __('Total') }} </th>
                                <th> {{ __('Paid') }} </th>
                                <th> {{ __('Return Amount') }} </th>
                            </tr>
                        </thead>
                        <tbody id="sale-return-reports-data">
                            @include('business::reports.sales-return.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $sales->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
