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
                    @can('shipping-companies-read')
                        <a href="{{ route('admin.shipping-companies.index') }}" class="add-order-btn rounded-2 {{ Route::is('admin.shipping-companies.create') ? 'active' : '' }}"><i class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}</a>
                    @endcan
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('admin.shipping-companies.store') }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>Company Name</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Company Name">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Enter Company Address">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Enter Company Email">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Phone Number</label>
                                    <input type="text" name="contact_number" class="form-control" placeholder="Enter Company Phone number">
                                </div>


                                <div class="col-lg-6 mb-2">
                                    <label>Create Api</label>
                                    <input type="text" name="create_api_url" class="form-control"  placeholder="Enter Create Api">
                                </div>


                                <div class="col-lg-6 mb-2">
                                    <label>Update Api</label>
                                    <input type="text" name="update_api_url" class="form-control" placeholder="Enter Update Api">
                                </div>


                                <div class="col-lg-6 mb-2">
                                    <label>Delete Api</label>
                                    <input type="text" name="delete_api_url" class="form-control" placeholder="Enter Delete Api">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>List Api</label>
                                    <input type="text" name="list_api_url" class="form-control" placeholder="Enter List Api">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Track Api</label>
                                    <input type="text" name="track_api_url" class="form-control" placeholder="Enter Track Api">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>First Required Credential</label>
                                    <input type="text" name="first_r_credential_lable" class="form-control" placeholder="Enter First Required Credential">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Second Required Credential</label>
                                    <input type="text" name="second_r_credential_lable" class="form-control" placeholder="Enter Second Required Credential">
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
