@extends('business::layouts.master')

@section('title')
    Edit Shipping Service
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Shipping Service</h4>
            <a href="{{ route('business.shipping.index') }}" class="btn btn-outline-primary btn-sm"><i class="far fa-list me-1"></i> {{ __('View List') }}</a>
        </div>
        <div class="card-body">
            <form action="{{ route('business.shipping.update',$shipping->id) }}" enctype="multipart/form-data" method="POST" class="ajaxform_instant_reload">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label class="form-label">Platform Name</label>
                        <input type="text" value="{{ $shipping->name }}" name="name" required class="form-control" placeholder="Company Name">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label">Select Service</label>
                        <select name="shipping_company_id" id="shipping_company" class="form-select">
                            <option value="">Select Service</option>
                            @foreach ($shipping_companys as $shipping_company)
                                <option value="{{ $shipping_company->id }}" {{ isset($shipping) && $shipping->shipping_company_id == $shipping_company->id ? 'selected' : '' }}>
                                    {{ ucfirst($shipping_company->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
