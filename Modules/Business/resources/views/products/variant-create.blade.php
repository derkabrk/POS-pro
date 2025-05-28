@extends('business::layouts.master')

@section('title')
    {{ __('Add Product Variant') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ __('Add Product Variant') }}</h4>
                <div class="flex-shrink-0">
                    <a href="{{ route('business.variants.index') }}" class="btn btn-primary">
                        <i class="far fa-list" aria-hidden="true"></i> {{ __('Product Variants') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('business.variants.store') }}" method="POST" class="ajaxform_instant_reload">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-xxl-6 col-md-6">
                            <label for="variantName" class="form-label">{{ __('Variant Name') }} <span class="text-danger">*</span></label>
                            <input type="text" id="variantName" name="variantName" required class="form-control" placeholder="{{ __('Enter Variant Name') }}">
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <label for="variantCode" class="form-label">{{ __('Variant Code') }}</label>
                            <input type="text" id="variantCode" name="variantCode" class="form-control" placeholder="{{ __('Enter Variant Code') }}">
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Inactive') }}</option>
                            </select>
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
</div>
@endsection
