@extends('layouts.master')

@section('title') {{ __('Subscription Plan') }} @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') {{ __('Plans') }} @endslot
@slot('title') {{ __('Plan List') }} @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="planList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Plan List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            @can('plans-create')
                                <a type="button" href="{{route('admin.plans.create')}}" class="btn btn-primary add-btn {{ Route::is('admin.plans.create') ? 'active' : '' }}">
                                    <i class="ri-add-line align-bottom me-1"></i> {{ __('Create Plan') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form action="{{ route('admin.plans.filter') }}" method="post" class="filter-form mb-0" id="filter-form">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-xxl-2 col-sm-4">
                            <select name="per_page" class="form-control">
                                <option value="10">{{__('Show- 10')}}</option>
                                <option value="25">{{__('Show- 25')}}</option>
                                <option value="50">{{__('Show- 50')}}</option>
                                <option value="100">{{__('Show- 100')}}</option>
                            </select>
                        </div>
                        <div class="col-xxl-4 col-sm-6">
                            <input class="form-control" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                        </div>
                        <div class="col-xxl-2 col-sm-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="ri-search-line me-1 align-bottom"></i> {{ __('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card mb-1">
                    <table class="table table-sm table-hover table-card table-bordered align-middle" id="planTable" style="min-width: 700px; font-size: 0.97rem;">
                        <thead class="text-muted table-light align-middle">
                            <tr class="text-uppercase align-middle">
                                @can('plans-delete')
                                <th scope="col" style="width: 36px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                @endcan
                                <th style="width: 48px;">{{ __('SL') }}</th>
                                <th class="text-start">{{ __('Subscription Name') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('Offer Price') }}</th>
                                <th>{{ __('Subscription Price') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all" id="plans-data">
                            @include('admin.plans.datas')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $plans->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
