@extends('layouts.master')

@section('title')
    {{ __('Edit Subscription Plan') }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('Plans') }}
        @endslot
        @slot('title')
            {{ __('Edit Subscription Plan') }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit Package')}}</h4>
                    <div class="flex-shrink-0">
                        @can('plans-read')
                        <a href="{{ route('admin.plans.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('Package List') }}
                        </a>
                        @endcan
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.plans.update',$plan->id) }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="subscriptionName" class="form-label">{{ __('Package Name') }} <span class="text-danger">*</span></label>
                                        <input value="{{$plan->subscriptionName}}" type="text" name="subscriptionName" id="subscriptionName" required class="form-control" placeholder="{{ __('Enter Package Name') }}" @readonly($plan->subscriptionName == 'Free')>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="duration" class="form-label">{{ __('Duration in Days') }} <span class="text-danger">*</span></label>
                                        <input value="{{$plan->duration}}" type="number" step="any" name="duration" id="duration" required class="form-control" placeholder="{{ __('Enter number') }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="offerPrice" class="form-label">{{ __('Offer Price') }}</label>
                                        <input value="{{$plan->offerPrice}}" type="number" step="any" name="offerPrice" id="offerPrice" class="form-control price" placeholder="{{ __('Enter Plan Price') }}" @readonly($plan->subscriptionName == 'Free')>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="subscriptionPrice" class="form-label">{{ __('Subscription Price') }} <span class="text-danger">*</span></label>
                                        <input value="{{$plan->subscriptionPrice}}" type="number" step="any" name="subscriptionPrice" id="subscriptionPrice" required class="form-control discount" placeholder="{{ __('Enter Subscription Price') }}" @readonly($plan->subscriptionName == 'Free')>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                            <p class="dynamic-text">{{ $plan->status == 1 ? 'Active' : 'Deactive' }}</p>
                                            <label class="switch m-0">
                                                <input type="checkbox" name="status" class="change-text" {{ $plan->status == 1 ? 'checked' : '' }}>
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
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label class="form-label">{{ __('Plan Permissions') }} <span class="text-danger">*</span></label>
                                        <div class="row g-2">
                                            @php
                                                $permissions = [
                                                    'business_access' => __('Business Access'),
                                                    'sales_access' => __('Sales Access'),
                                                    'purchase_access' => __('Purchase Access'),
                                                    'products_access' => __('Products Access'),
                                                    'reports_access' => __('Reports Access'),
                                                    'bulk_message' => __('Bulk Messaging'),
                                                    'roles_access' => __('User Roles'),
                                                    'settings_access' => __('Settings'),
                                                    'expenses_access' => __('Expenses'),
                                                    'incomes_access' => __('Incomes'),
                                                    'parties_access' => __('Parties'),
                                                    'shipping_access' => __('Shipping'),
                                                    'subscriptions_access' => __('Subscriptions'),
                                                    'currencies_access' => __('Currencies'),
                                                    'vat_access' => __('VAT/Tax'),
                                                    'notifications_access' => __('Notifications'),
                                                    'order_source_access' => __('Order Source'),
                                                    'ticket_system_access' => __('Ticket System'),
                                                    'chat_access' => __('Chat'),
                                                ];
                                                $planPermissions = is_array($plan->permissions) ? $plan->permissions : (json_decode($plan->permissions, true) ?? []);
                                            @endphp
                                            @foreach($permissions as $permKey => $permLabel)
                                                <div class="col-6 col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permKey }}" id="perm_{{ $permKey }}" {{ in_array($permKey, $planPermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="perm_{{ $permKey }}">{{ $permLabel }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <small class="text-muted">{{ __('Select the features this plan will allow access to.') }}</small>
                                    </div>
                                </div>
                                <div class="col-12">
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
                                    <div class="text-center mt-4">
                                        <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endsection
