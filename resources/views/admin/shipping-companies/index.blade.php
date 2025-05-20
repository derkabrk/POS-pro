@extends('layouts.master')

@section('title')
{{ __('Shipping Companies List') }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Shipping Companies List</h4>
            @can('banners-create')
                <a href="{{ route('admin.shipping-companies.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus-circle me-1"></i>Add New Company</a>
            @endcan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping-companies.filter') }}" method="post" class="filter-form mb-3" table="#business-category-data">
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
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}">
                    </div>
                </div>
            </form>
            <div class="table-responsive table-card">
                <table class="table table-nowrap mb-0" id="datatable">
                    <thead class="table-light">
                        <tr>
                            @can('banners-delete')
                                <th>
                                    <div class="d-flex align-items-center gap-3">
                                        <label class="table-custom-checkbox">
                                            <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox">
                                            <span class="table-custom-checkmark custom-checkmark"></span>
                                        </label>
                                    </div>
                                </th>
                            @endcan
                            <th>{{ __('SL') }}.</th>
                            <th class="text-start">Company Name</th>
                            <th class="text-start">Email</th>
                            <th class="text-start">Address</th>
                            <th class="text-start">Contact Number</th>
                            <th class="text-start">Action</th>
                        </tr>
                    </thead>
                    <tbody id="business-category-data" class="searchResults">
                        @include('admin.shipping-companies.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $shippingCompanies->links('vendor.pagination.bootstrap-5') }}
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
