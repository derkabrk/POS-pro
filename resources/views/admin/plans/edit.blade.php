@extends('layouts.master')

@section('title')
    {{ __('Edit Subscription Plan') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card border-0">
                <div class="card-bodys shadow-sm">
                    <div class="table-header p-16">
                        <h4>{{__('Edit Package')}}</h4>
                        @can('plans-read')
                            <a href="{{ route('admin.plans.index') }}" class="add-order-btn rounded-2 {{ Route::is('admin.users.create') ? 'active' : '' }}"><i class="far fa-list" aria-hidden="true"></i> {{ __('Package List') }}</a>
                        @endcan
                    </div>
                    <div class="order-form-section p-16">
                        <form action="{{ route('admin.plans.update',$plan->id) }}" method="POST" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="add-suplier-modal-wrapper d-block">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Package Name') }}</label>
                                        <input value="{{$plan->subscriptionName}}" type="text" name="subscriptionName" required class="form-control" placeholder="{{ __('Enter Package Name') }}" @readonly($plan->subscriptionName == 'Free')>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Duration in Days') }}</label>
                                        <input value="{{$plan->duration}}" type="number" step="any" name="duration" required class="form-control" placeholder="{{ __('Enter Duration Days') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Offer Price') }}</label>
                                        <input value="{{$plan->offerPrice}}" type="number" step="any" name="offerPrice" class="form-control price" placeholder="{{ __('Enter Plan Price') }}" @readonly($plan->subscriptionName == 'Free')>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Subscription Price') }}</label>
                                        <input value="{{$plan->subscriptionPrice}}" type="number" step="any" name="subscriptionPrice" required class="form-control" placeholder="{{ __('Enter Subscription Price') }}" @readonly($plan->subscriptionName == 'Free')>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Status') }}</label>
                                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">{{ $plan->status == 1 ? 'Active' : 'Deactive' }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" {{ $plan->status == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label>{{ __('Add New Features') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control add-feature border-0 bg-transparent" placeholder="{{ __('Enter features') }}">
                                            <button class="feature-btn" id="feature-btn">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row feature-list">
                                            @foreach ($plan->features ?? [] as $key => $item)
                                            <div class="col-lg-6 mt-4">
                                                <div class="form-control manage-plan d-flex justify-content-between align-items-center position-relative">
                                                    <input name="features[features_{{ $key }}][]" required class="form-control subscription-plan-edit-custom-input" type="text" value="{{ $item[0] ?? '' }}">
                                                  <div class="custom-manageswitch">
                                                    <label class="switch m-0">
                                                        <input type="checkbox" name="features[features_{{ $key }}][]" @checked(isset($item[1])) value="1">
                                                        <span class="slider round"></span>
                                                    </label>
                                                  </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                                            <button class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
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

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
