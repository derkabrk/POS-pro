@extends('layouts.master')

@section('title')
    @lang('translation.add-business')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Business
        @endslot
        @slot('title')
            Add Business
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Add new Business')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.business.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('Business List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.business.store') }}" method="POST" class="ajaxform_instant_reload">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="companyName" class="form-label">{{ __('Business Name') }}</label>
                                        <input type="text" name="companyName" id="companyName" required class="form-control" placeholder="{{ __('Enter Company Name') }}">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="business_category_id" class="form-label">{{__('Business Category')}}</label>
                                        <select name="business_category_id" id="business_category_id" required class="form-control">
                                            <option value=""> {{__('Select One')}}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"> {{ ucfirst($category->name) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="plan_subscribe_id" class="form-label">{{__('Subscription Plan')}}</label>
                                        <select name="plan_subscribe_id" id="plan_subscribe_id" class="form-control">
                                            <option value=""> {{__('Select Plan')}}</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan->id }}"> {{ ucfirst($plan->subscriptionName) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="type" class="form-label">Business type</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="1"> E-commerce </option>
                                            <option value="2"> Both </option>
                                            <option value="0"> Physical </option>
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="phoneNumber" class="form-label">{{ __('Phone') }}</label>
                                        <input type="text" name="phoneNumber" id="phoneNumber" required class="form-control" placeholder="{{ __('Enter Phone Number') }}">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        <input type="email" name="email" id="email" required class="form-control" placeholder="{{ __('Enter Email') }}">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="shopOpeningBalance" class="form-label">{{ __('Shop Opening Balance') }}</label>
                                        <input type="number" name="shopOpeningBalance" id="shopOpeningBalance" required class="form-control" placeholder="{{ __('Enter Balance') }}">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="address" class="form-label">{{ __('Address') }}</label>
                                        <input type="text" name="address" id="address" required class="form-control" placeholder="{{ __('Enter Address') }}">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="password" class="form-label">{{__('Password')}}</label>
                                        <div class="form-icon">
                                            <input type="password" name="password" id="password" class="form-control form-control-icon" placeholder="{{ __('Enter New Password') }}">
                                            <i class="ri-lock-password-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="password_confirmation" class="form-label">{{__('Confirm password')}}</label>
                                        <div class="form-icon">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-icon" placeholder="{{ __('Enter Confirm password') }}">
                                            <i class="ri-lock-password-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="pictureUrl" class="form-label">{{ __('Image') }}</label>
                                        <input type="file" accept="image/*" name="pictureUrl" id="pictureUrl" class="form-control" data-id="image">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-lg-12">
                                    <div class="text-center mt-4">
                                        <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        // Password toggle visibility
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInputs = document.querySelectorAll('input[type="password"]');
            
            passwordInputs.forEach(input => {
                const icon = input.nextElementSibling;
                
                icon.addEventListener('click', function() {
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('ri-lock-password-line', 'ri-eye-line');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('ri-eye-line', 'ri-lock-password-line');
                    }
                });
            });
        });
    </script>
@endsection