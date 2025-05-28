@extends('business::layouts.master')

@section('title')
    Edit Shipping Service
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit Shipping Service')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('business.shipping.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('Shipping List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('business.shipping.update', $shipping->id) }}" enctype="multipart/form-data" method="POST" class="ajaxform_instant_reload">
                            @csrf
                            @method('PUT')
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label fw-semibold">Platform Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $shipping->name }}" name="name" required class="form-control" placeholder="Company Name">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label fw-semibold">Select Service <span class="text-danger">*</span></label>
                                    <select name="shipping_company_id" id="shipping_company" class="form-select">
                                        <option value="">Select Service</option>
                                        @foreach ($shipping_companys as $shipping_company)
                                            <option value="{{ $shipping_company->id }}" {{ isset($shipping) && $shipping->shipping_company_id == $shipping_company->id ? 'selected' : '' }}>
                                                {{ ucfirst($shipping_company->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label" id="first_r_credential_lable"></label>
                                    <input type="text" name="first_r_credential" value="{{ $shipping->first_r_credential }}" class="form-control" placeholder="Please select a shipping service" id="first_r_credential_input">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label" id="second_r_credential_lable"></label>
                                    <input type="text" name="second_r_credential" value="{{ $shipping->second_r_credential }}" class="form-control" placeholder="Please select a shipping service" id="second_r_credential_input">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <span class="dynamic-text mb-0">{{ __('Active') }}</span>
                                        <label class="switch m-0">
                                            <input type="checkbox" name="status" value="1" {{ $shipping->status ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
