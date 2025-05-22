@extends('business::layouts.master')

@section('title')
    {{ __('Product List') }}
@endsection

@section('content')
    <div class="admin-table-section">
        <div class="container-fluid">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="table-header d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">{{ __('Product List') }}</h4>
                        <a href="{{ route('business.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i>{{ __('Add new Product') }}
                        </a>
                    </div>

                    <div class="table-header text-center d-none d-print-block">
                        @include('business::print.header')
                        <h4 class="mt-2">{{ __('Product List') }}</h4>
                    </div>

                    <div class="table-top-form p-3">
                        <form action="{{ route('business.products.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3" table="#product-data">
                            @csrf

                            <div class="form-group mb-0">
                                <select name="per_page" class="form-select">
                                    <option value="10">{{ __('Show- 10') }}</option>
                                    <option value="25">{{ __('Show- 25') }}</option>
                                    <option value="50">{{ __('Show- 50') }}</option>
                                    <option value="100">{{ __('Show- 100') }}</option>
                                </select>
                            </div>

                            <div class="form-group mb-0 flex-grow-1 position-relative">
                                <input class="form-control" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.582 14.582L18.332 18.332" stroke="#4D4D4D" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.668 9.16797C16.668 5.02584 13.3101 1.66797 9.16797 1.66797C5.02584 1.66797 1.66797 5.02584 1.66797 9.16797C1.66797 13.3101 5.02584 16.668 9.16797 16.668C13.3101 16.668 16.668 13.3101 16.668 9.16797Z" stroke="#4D4D4D" stroke-width="1.25" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                        </form>

                        <div class="table-top-btn-group d-flex gap-2 mt-3">
                            <a href="{{ route('business.products.csv') }}" class="btn btn-outline-secondary">
                                <img src="{{ asset('assets/images/logo/csv.svg') }}" alt="">
                            </a>
                            <a href="{{ route('business.products.excel') }}" class="btn btn-outline-secondary">
                                <img src="{{ asset('assets/images/logo/excel.svg') }}" alt="">
                            </a>
                            <a onclick="window.print()" class="btn btn-outline-secondary">
                                <img src="{{ asset('assets/images/logo/printer.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="delete-item d-none">
                    <div class="delete-item-show d-flex justify-content-between align-items-center p-3 bg-danger text-white">
                        <p class="mb-0 fw-bold"><span class="selected-count"></span> {{ __('items show') }}</p>
                        <button data-bs-toggle="modal" class="btn btn-light" data-bs-target="#multi-delete-modal" data-url="{{ route('business.products.delete-all') }}">{{ __('Delete') }}</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="datatable">
                        <thead class="table-dark">
                            <tr>
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
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::products.view')
@endpush

