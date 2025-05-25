@extends('business::layouts.master')

@section('title')
    {{ __('Category List') }}
@endsection

@section('content')
    <div class="admin-table-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="categoryList">
                        <div class="card-header border-0">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">{{ __('Category List') }}</h5>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a type="button" href="#category-create-modal" data-bs-toggle="modal"
                                            class="btn btn-primary add-btn"><i
                                            class="ri-add-line align-bottom me-1"></i> {{ __('Add new Category') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">
                            <form action="{{ route('business.categories.filter') }}" method="post" class="filter-form"
                                table="#business-category-data" id="category-search-form">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="search-box">
                                            <input type="text" class="form-control search" name="search"
                                                value="{{ request('search') }}" placeholder="{{ __('Search...') }}"
                                                id="category-search-input">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-sm-6">
                                        <div>
                                            <select class="form-control" name="per_page" id="category_per_page">
                                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>
                                                    {{__('Show- 10')}}
                                                </option>
                                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>
                                                    {{__('Show- 25')}}
                                                </option>
                                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>
                                                    {{__('Show- 50')}}
                                                </option>
                                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>
                                                    {{__('Show- 100')}}
                                                </option>
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
                            <div class="table-responsive table-card" style="margin-top:20px;">
                                <table class="table table-nowrap mb-0" id="categoryTable">
                                    <thead class="table-light">
                                        <tr class="text-uppercase">
                                            <th style="width: 25px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input select-all-delete multi-delete">
                                                </div>
                                            </th>
                                            <th>{{ __('SL') }}.</th>
                                            <th>{{ __('Icon') }}</th>
                                            <th class="text-start">{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="business-category-data">
                                        @include('business::categories.datas')
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $categories->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('business::component.delete-modal')
    @include('business::categories.create')
    @include('business::categories.edit')
@endpush

