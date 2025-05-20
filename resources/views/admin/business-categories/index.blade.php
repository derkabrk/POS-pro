@extends('layouts.master')

@section('title')
    {{ __('Business Categories List') }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('Business Categories') }}
        @endslot
        @slot('title')
            {{ __('Business Categories List') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('Business Categories List') }}</h4>
                    <div class="flex-shrink-0">
                        @can('banners-create')
                        <a type="button" href="{{route('admin.business-categories.create')}}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i>{{ __('Add new Category') }}
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.business-categories.filter') }}" method="post" class="filter-form mb-3" table="#business-category-data">
                        @csrf
                        <div class="row g-2 align-items-center">
                            <div class="col-auto">
                                <select name="per_page" class="form-control">
                                    <option value="10">{{__('Show- 10')}}</option>
                                    <option value="25">{{__('Show- 25')}}</option>
                                    <option value="50">{{__('Show- 50')}}</option>
                                    <option value="100">{{__('Show- 100')}}</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-sm table-hover table-striped table-bordered align-middle" id="datatable">
                            <thead class="text-muted table-light align-middle">
                                <tr class="text-uppercase align-middle">
                                    @can('banners-delete')
                                    <th style="width:36px;">
                                        <label class="table-custom-checkbox">
                                            <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox">
                                            <span class="table-custom-checkmark custom-checkmark"></span>
                                        </label>
                                    </th>
                                    @endcan
                                    <th>{{ __('SL') }}</th>
                                    <th class="text-start">{{ __('Business Name') }}</th>
                                    <th class="text-start">{{ __('Description') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="business-category-data" class="searchResults">
                                @include('admin.business-categories.datas')
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
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
