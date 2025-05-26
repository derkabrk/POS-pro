@extends('business::layouts.master')

@section('title')
    {{ __('Currency') }}
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card" id="currencyList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Currency List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
        
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('business.currencies.filter') }}" method="post" class="filter-form d-flex align-items-center gap-3" table="#currencies-data">
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
                            <div class="search-box">
                                <input class="form-control searchInput" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="currencyTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th>{{ __('SL') }}.</th>
                                <th class="text-start">{{ __('Name') }}</th>
                                <th class="text-start">{{ __('Country Name') }}</th>
                                <th class="text-start">{{ __('Code') }}</th>
                                <th class="text-start">{{ __('Symbol') }}</th>
                                <th class="text-start">{{ __('Default') }}</th>
                                <th class="text-start">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="currencies-data">
                            @include('business::currencies.datas')
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

