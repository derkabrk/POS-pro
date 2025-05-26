@extends('business::layouts.master')

@section('title')
    Edit Shipping Service
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top-4">
            <h4 class="mb-0 fw-bold">Edit Shipping Service</h4>
            <a href="{{ route('business.shipping.index') }}" class="btn btn-outline-light btn-sm rounded-pill"><i class="ri-list-check-2 me-1"></i> {{ __('View List') }}</a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('business.shipping.update',$shipping->id) }}" enctype="multipart/form-data" method="POST" class="ajaxform_instant_reload">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">Platform Name</label>
                        <input type="text" value="{{ $shipping->name }}" name="name" required class="form-control form-control-lg" placeholder="Company Name">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label fw-semibold">Select Service</label>
                        <select name="shipping_company_id" id="shipping_company" class="form-select form-select-lg">
                            <option value="">Select Service</option>
                            @foreach ($shipping_companys as $shipping_company)
                                <option value="{{ $shipping_company->id }}" {{ isset($shipping) && $shipping->shipping_company_id == $shipping_company->id ? 'selected' : '' }}>
                                    {{ ucfirst($shipping_company->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4"><i class="ri-save-3-line me-1"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
