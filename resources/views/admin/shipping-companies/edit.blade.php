@extends('layouts.master')

@section('title')
    {{ __('Edit Business Category') }}
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>{{ __('Edit Business Category') }}</h4>
                    @can('business-categories-read')
                        <a href="{{ route('admin.business-categories.index') }}" class="add-order-btn rounded-2 active"><i class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}</a>
                    @endcan
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('admin.business-categories.update',$category->id) }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        @method('put')

                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Buisness Name') }}</label>
                                    <input type="text" value="{{ $category->name }}" name="name" required class="form-control" placeholder="{{ __('Enter Buisness Name') }}">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>{{ __('Status') }}</label>
                                    <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                        <p class="dynamic-text mb-0">{{ $category->status == 1 ? 'Active' : 'Deactive' }}</p>
                                        <label class="switch m-0">
                                            <input type="checkbox" name="status" class="change-text" {{ $category->status == 1 ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-2">
                                    <label>{{ __('Description') }}</label>
                                    <textarea type="text" name="description" class="form-control" placeholder="{{ __('Enter Description') }}">{{ $category->description }}</textarea>
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
