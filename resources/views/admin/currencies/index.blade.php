@extends('layouts.master')

@section('title')
    {{ __('Currency') }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('Currencies') }}
        @endslot
        @slot('title')
            {{ __('Currency List') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('Currency List') }}</h4>
                    <div class="flex-shrink-0">
                        @can('currencies-create')
                        <a href="{{ route('admin.currencies.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> {{ __('Add Currency') }}
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.currencies.filter') }}" method="post" class="filter-form mb-3" table="#currencies-data">
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
                                <input class="form-control searchInput" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-sm table-hover table-striped table-bordered align-middle" id="erp-table">
                            <thead class="text-muted table-light align-middle">
                                <tr class="text-uppercase align-middle">
                                    <th style="width:36px;">
                                        <label class="table-custom-checkbox">
                                            <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox">
                                            <span class="table-custom-checkmark custom-checkmark"></span>
                                        </label>
                                    </th>
                                    <th>{{ __('SL') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Rate') }}</th>
                                    <th>{{ __('Symbol') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Default') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="currencies-data" class="searchResults">
                                @include('admin.currencies.datas')
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $currencies->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
