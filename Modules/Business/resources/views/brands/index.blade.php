@extends('business::layouts.master')

@section('title')
    {{ __('Brand List') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="brandList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Brand List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <a type="button" href="#brand-create-modal" data-bs-toggle="modal" class="btn btn-primary add-btn"><i class="ri-add-line align-bottom me-1"></i> {{ __('Add new Brand') }}</a>
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.brands.filter') }}" method="post" class="filter-form" table="#business-brand-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-3 col-sm-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" name="search" placeholder="{{ __('Search...') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-6">
                            <div>
                                <select class="form-control" name="per_page" id="per_page">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                    {{ __('Filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="brandTable">
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
</div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::brands.create')
    @include('business::brands.edit')
@endpush
