@extends('layouts.master')

@section('title')
    {{ __('Add Shipping Company') }}
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{__('Add New Company')}}</h4>
            <div>
                @can('shipping-companies-read')
                <a href="{{ route('admin.shipping-companies.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="far fa-list me-1"></i> {{ __('View List') }}
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping-companies.store') }}" method="POST" class="ajaxform_instant_reload">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" required class="form-control" placeholder="Company Name">
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Enter Company Address">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Company Email">
                    </div>
                    <div class="col-md-6">
                        <label for="contact_number" class="form-label">Phone Number</label>
                        <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Enter Company Phone number">
                    </div>
                    <div class="col-md-6">
                        <label for="create_api_url" class="form-label">Create Api</label>
                        <input type="text" name="create_api_url" id="create_api_url" class="form-control" placeholder="Enter Create Api">
                    </div>
                    <div class="col-md-6">
                        <label for="update_api_url" class="form-label">Update Api</label>
                        <input type="text" name="update_api_url" id="update_api_url" class="form-control" placeholder="Enter Update Api">
                    </div>
                    <div class="col-md-6">
                        <label for="delete_api_url" class="form-label">Delete Api</label>
                        <input type="text" name="delete_api_url" id="delete_api_url" class="form-control" placeholder="Enter Delete Api">
                    </div>
                    <div class="col-md-6">
                        <label for="list_api_url" class="form-label">List Api</label>
                        <input type="text" name="list_api_url" id="list_api_url" class="form-control" placeholder="Enter List Api">
                    </div>
                    <div class="col-md-6">
                        <label for="track_api_url" class="form-label">Track Api</label>
                        <input type="text" name="track_api_url" id="track_api_url" class="form-control" placeholder="Enter Track Api">
                    </div>
                    <div class="col-md-6">
                        <label for="first_r_credential_lable" class="form-label">First Required Credential</label>
                        <input type="text" name="first_r_credential_lable" id="first_r_credential_lable" class="form-control" placeholder="Enter First Required Credential">
                    </div>
                    <div class="col-md-6">
                        <label for="second_r_credential_lable" class="form-label">Second Required Credential</label>
                        <input type="text" name="second_r_credential_lable" id="second_r_credential_lable" class="form-control" placeholder="Enter Second Required Credential">
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
