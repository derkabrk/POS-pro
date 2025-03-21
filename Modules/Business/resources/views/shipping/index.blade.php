@extends('business::layouts.master')


@section('title')
Shipping Services
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Shipping Companies List</h4>
                   
                        <a type="button" href="{{ route('business.shipping.create')}}" class="add-order-btn rounded-2 class="btn btn-primary" ><i class="fas fa-plus-circle me-1"></i>Add New Company</a>
                
                </div>

            </div>

            <div class="responsive-table m-0">
                <table class="table" id="datatable">
                    <thead>
                    <tr>
                       
                            <th>
                                <div class="d-flex align-items-center gap-3">
                                    <label class="table-custom-checkbox">
                                        <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox">
                                        <span class="table-custom-checkmark custom-checkmark"></span>
                                    </label>
                                </div>
                            </th>
                        
                        <th>{{ __('SL') }}.</th>
                        <th class="text-start">Name</th>
                        <th class="text-start">Platform</th>
                        <th class="text-start">Active</th>
                        <th class="text-start">Action</th>
                    </tr>
                    </thead>
                    <tbody id="business-category-data" class="searchResults">
                        @include('business::shipping.datas')
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $shippings->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection


@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
