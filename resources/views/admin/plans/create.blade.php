@extends('layouts.master')

@section('title')
    @lang('translation.add-plan')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('Plans') }}
        @endslot
        @slot('title')
            {{ __('Add Subscription Plan') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Add new Package')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.plans.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('Package List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.plans.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="subscriptionName" class="form-label">{{ __('Package Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="subscriptionName" id="subscriptionName" required class="form-control" placeholder="{{ __('Enter Package Name') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="duration" class="form-label">{{ __('Duration in Days') }} <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="duration" id="duration" required class="form-control" placeholder="{{ __('Enter number') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="offerPrice" class="form-label">{{ __('Offer Price') }}</label>
                                        <input type="number" step="any" name="offerPrice" id="offerPrice" class="form-control price" placeholder="{{ __('Enter Plan Price') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="subscriptionPrice" class="form-label">{{ __('Subscription Price') }} <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="subscriptionPrice" id="subscriptionPrice" required class="form-control discount" placeholder="{{ __('Enter Subscription Price') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">{{ __('Active') }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="feature-input" class="form-label">{{ __('Add New Features') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control add-feature border-0 bg-transparent" id="feature-input" placeholder="{{ __('Enter features') }}">
                                            <button class="btn btn-primary feature-btn" id="feature-btn" type="button">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row feature-list">
                                        {{-- Will be added dynamically. --}}
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

@section('script')
    <script>
        // Add JS for dynamic features if needed
    </script>
@endsection
