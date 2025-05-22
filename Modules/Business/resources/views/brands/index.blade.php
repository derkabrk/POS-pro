@extends('business::layouts.master')

@section('title')
    {{ __('Brand List') }}
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex align-items-center justify-content-between bg-white border-bottom-0">
            <h4 class="mb-0 fw-semibold text-dark">{{ __('Brand List') }}</h4>
            <div class="d-flex gap-2 flex-wrap">
                <a type="button" href="#brand-create-modal" data-bs-toggle="modal" class="btn btn-primary btn-sm rounded-pill d-flex align-items-center gap-1 add-btn">
                    <i class="ri-add-line align-bottom"></i> {{ __('Add new Brand') }}
                </a>
                <button class="btn btn-outline-danger btn-sm rounded-pill d-flex align-items-center gap-1" id="remove-actions" onClick="deleteMultiple()">
                    <i class="ri-delete-bin-2-line"></i>
                </button>
            </div>
        </div>
        <div class="card-body border-bottom">
            <form action="{{ route('business.brands.filter') }}" method="post" class="row g-3 align-items-center mb-3 filter-form" table="#business-brand-data">
                @csrf
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control search" name="search" placeholder="{{ __('Search...') }}">
                        <span class="input-group-text bg-light"><i class="ri-search-line"></i></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="per_page" id="per_page" aria-label="{{ __('Items per page') }}">
                        <option value="10">{{__('Show- 10')}}</option>
                        <option value="25">{{__('Show- 25')}}</option>
                        <option value="50">{{__('Show- 50')}}</option>
                        <option value="100">{{__('Show- 100')}}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-primary w-100 btn-sm rounded-pill d-flex align-items-center gap-1" onclick="SearchData();" aria-label="{{ __('Apply filters') }}">
                        <i class="ri-equalizer-fill me-1 align-bottom"></i>{{ __('Filters') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive table-card">
                <table class="table table-hover align-middle table-striped mb-0" id="brandTable">
                    <thead class="table-light">
                        <tr class="text-uppercase">
                            <th style="width: 25px;">
                                <div class="form-check">
                                    <input class="form-check-input select-all-delete multi-delete" type="checkbox" id="checkAll" value="option">
                                </div>
                            </th>
                            <th>{{ __('SL') }}.</th>
                            <th>{{ __('Icon') }}</th>
                            <th class="text-start">{{ __('Brand Name') }}</th>
                            <th class="text-start">{{ __('Description') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="business-brand-data">
                        @include('business::brands.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $brands->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::brands.create')
    @include('business::brands.edit')
@endpush
