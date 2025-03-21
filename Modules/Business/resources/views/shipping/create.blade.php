@extends('layouts.master')

@section('title')
    {{ __('Category') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Add New Company</h4>
                    @can('shipping-read')
                        <a href="{{ route('admin.shipping.index') }}" class="add-order-btn rounded-2 {{ Route::is('admin.shipping.create') ? 'active' : '' }}"><i class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}</a>
                    @endcan
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('admin.shipping.store') }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>Company Name</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Company Name">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" rows="3" placeholder="Enter Company Address">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" rows="3" placeholder="Enter Company Email">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Phone Number</label>
                                    <input type="text" name="contact_number" class="form-control" rows="3" placeholder="Enter Company Phone number">
                                </div>


                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                                        <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
