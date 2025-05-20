@extends('layouts.master')

@section('title')
    {{ __('Edit Business Category') }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('Business Categories') }}
        @endslot
        @slot('title')
            {{ __('Edit Business Category') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit Business Category')}}</h4>
                    <div class="flex-shrink-0">
                        @can('business-categories-read')
                        <a href="{{ route('admin.business-categories.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('View List') }}
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.business-categories.update',$category->id) }}" method="POST" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="name" class="form-label">{{ __('Business Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ $category->name }}" name="name" id="name" required class="form-control" placeholder="{{ __('Enter Business Name') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text mb-0">{{ $category->status == 1 ? 'Active' : 'Deactive' }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" {{ $category->status == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <label for="description" class="form-label">{{ __('Description') }}</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="{{ __('Enter Description') }}">{{ $category->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-center mt-4">
                                        <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
