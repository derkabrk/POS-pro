@extends('business::layouts.master')

@section('title')
    {{ __('Product List') }}
@endsection

@section('content')
    <div class="admin-table-section">
        <div class="container-fluid">
            <div class="card" id="productList">
                <div class="card-header border-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">{{ __('Product List') }}</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('business.products.create') }}" class="btn btn-primary add-btn"><i class="ri-add-line align-bottom me-1"></i> {{ __('Add new Product') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form action="{{ route('business.products.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3" table="#product-data" id="product-search-form">
                        @csrf
                        <div class="row g-3 w-100">
                            <div class="col-xxl-3 col-sm-6">
                                <div class="search-box">
                                    <input class="form-control search" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}" id="product-search-input">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <select class="form-control" name="per_page" id="product_per_page">
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
                    <div class="table-top-btn-group d-flex gap-2 mb-3">
                        <a href="{{ route('business.products.csv') }}" class="btn btn-secondary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-file-list-2-line me-1"></i> <span>{{ __('Export CSV') }}</span>
                        </a>
                        <a href="{{ route('business.products.excel') }}" class="btn btn-success btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-file-excel-2-line me-1"></i> <span>{{ __('Export Excel') }}</span>
                        </a>
                        <a onclick="window.print()" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm print-window">
                            <i class="ri-printer-line me-1"></i> <span>{{ __('Print') }}</span>
                        </a>
                    </div>
                    <div class="table-responsive table-card" style="margin-top:20px;">
                        <table class="table table-nowrap mb-0" id="productTable">
                            <thead class="table-light">
                                <tr class="text-uppercase">
                                    <th class="w-60 d-print-none">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input select-all-delete multi-delete">
                                        </div>
                                    </th>
                                    <th> {{ __('SL') }}. </th>
                                    <th> {{ __('Image') }} </th>
                                    <th> {{ __('Product Name') }} </th>
                                    <th> {{ __('Code') }} </th>
                                    <th> {{ __('Brand') }} </th>
                                    <th> {{ __('Category') }} </th>
                                    <th> {{ __('Supplier') }} </th>
                                    <th> {{ __('Unit') }} </th>
                                    <th> {{ __('Purchase price') }}</th>
                                    <th> {{ __('Sale price') }}</th>
                                    <th> {{ __('Stock') }}</th>
                                    <th> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                            <tbody id="product-data">
                                @include('business::products.datas')
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $products->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::products.view')
@endpush

