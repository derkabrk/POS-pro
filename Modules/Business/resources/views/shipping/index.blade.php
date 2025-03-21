@extends('layouts.master')

@section('title')
{{ __('Business Categories List') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Shipping Companies List</h4>
                    @can('banners-create')
                        <a type="button" href="{{ route('business.shipping-companies.create')}}" class="add-order-btn rounded-2 {{ Route::is('business.plans.create') ? 'active' : '' }}" class="btn btn-primary" ><i class="fas fa-plus-circle me-1"></i>Add New Company</a>
                    @endcan
                </div>

            </div>



            <div class="responsive-table m-0">
                <table class="table" id="datatable">
                    <thead>
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
                        @include('business.shipping-companies.datas')
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
    @include('business.components.multi-delete-modal')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
