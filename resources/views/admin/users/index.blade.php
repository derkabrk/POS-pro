@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('Staff List') }}</h4>
            @can('users-create')
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="far fa-plus me-1"></i>{{ __('Add New Staff') }}
                </a>
            @endcan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.filter') }}" method="post" class="filter-form mb-3" table="#users-data">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <select name="per_page" class="form-select">
                            <option value="10">{{__('Show- 10')}}</option>
                            <option value="25">{{__('Show- 25')}}</option>
                            <option value="50">{{__('Show- 50')}}</option>
                            <option value="100">{{__('Show- 100')}}</option>
                        </select>
                    </div>
                    <div class="col">
                        <input class="form-control" type="text" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                    </div>
                </div>
            </form>
            <div class="table-responsive table-card">
                <table class="table table-nowrap mb-0" id="datatable">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <div class="d-flex align-items-center gap-1">
                                    <label class="table-custom-checkbox">
                                        <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox ">
                                        <span class="table-custom-checkmark custom-checkmark"></span>
                                    </label>
                                    <i class="fal fa-trash-alt delete-selected"></i>
                                </div>
                            </th>
                            <th>{{ __('SL') }}.</th>
                            <th class="text-start">{{ __('Name') }}</th>
                            <th class="text-start">{{ __('Phone') }}</th>
                            <th class="text-start">{{ __('User Email') }}</th>
                            <th class="text-start">{{ __('User Role') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="users-data" class="searchResults">
                        @include('admin.users.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="User-view">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('View') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body order-form-section">
                <div class="costing-list">
                    <ul>
                        <li><span>{{ __('Name') }}</span> <span>:</span> <span id="staff_view_name"></span></li>
                        <li><span>{{ __('Phone') }}</span> <span>:</span> <span id="staff_view_phone_number"></span></li>
                        <li><span>{{ __('Email') }}</span> <span>:</span> <span id="staff_view_email_number"></span></li>
                        <li><span>{{ __('Role') }}</span> <span>:</span> <span id="staff_view_role"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush
