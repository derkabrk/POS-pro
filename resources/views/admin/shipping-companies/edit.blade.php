@extends('layouts.master')

@section('title')
    {{ __('Edit Shipping Company') }}
@endsection

@section('main_content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Company's Info</h4>
            @can('shipping-companies-read')
                <a href="{{ route('admin.shipping-companies.index') }}" class="btn btn-outline-primary btn-sm"><i class="far fa-list me-1"></i> {{ __('View List') }}</a>
            @endcan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping-companies.update',$shippingCompany->id) }}" method="POST" class="ajaxform_instant_reload">
                @csrf
                @method('put')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" value="{{ $shippingCompany->name }}" name="name" required class="form-control" placeholder="Enter Business Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" value="{{ $shippingCompany->address }}" name="address" required class="form-control" placeholder="Enter Company Address">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" value="{{ $shippingCompany->email }}" name="email" required class="form-control" placeholder="Enter Company Email">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" value="{{ $shippingCompany->contact_number }}" name="contact_number" required class="form-control" placeholder="Enter Company Phone Number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Create Api</label>
                        <input type="text" value="{{ $shippingCompany->create_api_url }}" name="create_api_url" class="form-control"  placeholder="Enter Create Api">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Update Api</label>
                        <input type="text" value="{{ $shippingCompany->update_api_url }}" name="update_api_url" class="form-control" placeholder="Enter Update Api">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Delete Api</label>
                        <input type="text" value="{{ $shippingCompany->delete_api_url }}" name="delete_api_url" class="form-control" placeholder="Enter Delete Api">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">List Api</label>
                        <input type="text" value="{{ $shippingCompany->list_api_url }}" name="list_api_url" class="form-control" placeholder="Enter List Api">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Track Api</label>
                        <input type="text" value="{{ $shippingCompany->track_api_url }}" name="track_api_url" class="form-control" placeholder="Enter Track Api">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">First Required Credential</label>
                        <input type="text" value="{{ $shippingCompany->first_r_credential_lable }}" name="first_r_credential_lable" class="form-control" placeholder="Enter First Required Credential">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Second Required Credential</label>
                        <input type="text" value="{{ $shippingCompany->second_r_credential_lable }}" name="second_r_credential_lable" class="form-control" placeholder="Enter Second Required Credential">
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
