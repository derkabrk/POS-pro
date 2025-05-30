@extends('layouts.master')

@section('title')
    @lang('translation.edit-business')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Business
        @endslot
        @slot('title')
            Edit Business
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit Business')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.business.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('Business List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('admin.business.update', $business->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="companyName" class="form-label">{{ __('Business Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="companyName" id="companyName" value="{{ $business->companyName }}" required class="form-control" placeholder="{{ __('Enter Company Name') }}">
                                        @error('companyName')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="business_category_id" class="form-label">{{__('Business Category')}} <span class="text-danger">*</span></label>
                                        <select name="business_category_id" id="business_category_id" required class="form-control">
                                            <option value=""> {{__('Select One')}}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected($category->id == $business->business_category_id)> {{ ucfirst($category->name) }} </option>
                                            @endforeach
                                        </select>
                                        @error('business_category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="plan_subscribe_id" class="form-label">{{__('Subscription Plan')}}</label>
                                        <select name="plan_subscribe_id" id="plan_subscribe_id" class="form-control">
                                            <option value=""> {{__('Select Plan')}}</option>
                                            @foreach ($plans as $plan)
                                                <option value="{{ $plan->id }}" @selected($plan->id == $business->plan_subscribe_id)> {{ ucfirst($plan->subscriptionName) }} </option>
                                            @endforeach
                                        </select>
                                        @error('plan_subscribe_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="type" class="form-label">Business type</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="1" {{ $business->type == 1 ? 'selected' : '' }}> E-commerce </option>
                                            <option value="2" {{ $business->type == 2 ? 'selected' : '' }}> Both </option>
                                            <option value="0" {{ $business->type == 0 ? 'selected' : '' }}> Physical </option>
                                        </select>
                                        @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="phoneNumber" class="form-label">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="phoneNumber" id="phoneNumber" value="{{ $business->phoneNumber }}" required class="form-control" placeholder="{{ __('Enter Phone Number') }}">
                                        @error('phoneNumber')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" placeholder="{{ __('Enter Email') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="points" class="form-label">{{ __('User Points') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="points" id="points" value="{{ $user->points }}" required class="form-control" placeholder="{{ __('Enter Points') }}" step="1">
                                        @error('points')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="address" class="form-label">{{ __('Address') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="address" id="address" value="{{ $business->address }}" required class="form-control" placeholder="{{ __('Enter Address') }}">
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="password" class="form-label">{{__('Password')}}</label>
                                        <div class="position-relative">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter New Password') }}">
                                            <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                                <i class="ri-eye-off-line"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="password_confirmation" class="form-label">{{__('Confirm password')}}</label>
                                        <div class="position-relative">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm password') }}">
                                            <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                                <i class="ri-eye-off-line"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="pictureUrl" class="form-label">{{ __('Image') }}</label>
                                        <input type="file" accept="image/*" name="pictureUrl" id="pictureUrl" class="form-control">
                                        <div class="mt-2">
                                            <img id="preview-image" src="{{ asset($business->pictureUrl ?? 'assets/images/icons/upload.png') }}" alt="Preview" class="img-thumbnail" style="max-width: 100px; {{ $business->pictureUrl ? '' : 'display: none;' }}">
                                        </div>
                                        @error('pictureUrl')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
                    }
                });
            });
            // Image preview
            const imageInput = document.getElementById('pictureUrl');
            const previewImage = document.getElementById('preview-image');
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endsection
