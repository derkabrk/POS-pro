<div class="modal fade" id="registration-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Create a') }} <span id="subscription_name"> {{ __('Free') }}</span>
                    {{ __('account') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form id="registration-form" action="{{ route('register') }}" method="post"
                        enctype="multipart/form-data" class="add-brand-form pt-0 sign_up_form">
                        @csrf
                        <div class="row">
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">{{ __('Company/Business Name') }}</label>
                                <input type="text" name="companyName"
                                    placeholder="{{ __('Enter business/store Name') }}" class="form-control" required />
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">{{ __('Business Category') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="business_category_id" id="business_category"
                                        class="form-control form-selected" required>
                                        @foreach ($business_categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span></span>
                                </div>
                            </div>

                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">{{ __('Phone') }}</label>
                                <input type="number" name="phoneNumber" placeholder="{{ __('Enter Phone Number') }}"
                                    class="form-control" required />
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">{{ __('Email Address') }}</label>
                                <input type="email" name="email" placeholder="{{ __('Enter Email Address') }}"
                                    class="form-control" required />
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">{{ __('Password') }}</label>
                                <input type="password" name="password" placeholder="{{ __('Enter Password') }}"
                                    class="form-control" required />
                            </div>
                            <div class="mt-3 col-lg-6">
                                <label class="custom-top-label">{{ __('Company Address') }}</label>
                                <input type="text" name="address" placeholder="{{ __('Enter Company Address') }}"
                                    class="form-control" />
                            </div>
                            <div class="mt-3 col-lg-12">
                                <label class="custom-top-label">{{ __('Opening Balance') }}</label>
                                <input type="number" name="shopOpeningBalance"
                                    placeholder="{{ __('Enter Opening Balance') }}" class="form-control" />
                            </div>
                        </div>

                        <div class="offcanvas-footer mt-3 d-flex justify-content-center">
                            <button type="button" data-bs-dismiss="modal" class="cancel-btn btn btn-outline-danger"
                                data-bs-dismiss="offcanvas" aria-label="Close">
                                {{ __('Close') }}
                            </button>
                            <button class="submit-btn btn btn-primary text-white ms-2 btn-outline-danger" type="submit">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Verify Modal Start -->
<div class="modal fade" id="verifymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verify-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body verify-modal-body  text-center">

                <h4 class="mb-0">{{ __('Email Verification') }}</h4>
                <p class="des p-8-0 pb-3">{{ __('we sent an OTP in your email address') }} <br>
                    <span id="dynamicEmail"></span>
                </p>
                <form action="{{ route('otp-submit') }}" method="post" class="verify_form">
                    @csrf
                    <div class="code-input pin-container">
                        <input class="pin-input otp-input" id="pin-1" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-2" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input" id="pin-3" type="number" name="otp[]"
                            maxlength="1">
                        <input class="pin-input otp-input" id="pin-4" type="number" name="otp[]"
                            maxlength="1">
                        <input class="pin-input otp-input" id="pin-5" type="number" name="otp[]"
                            maxlength="1">
                        <input class="pin-input otp-input" id="pin-6" type="number" name="otp[]"
                            maxlength="1">
                    </div>



                    <p class="des p-24-0 pt-2">
                        {{ __('Code send in') }} <span id="countdown" class="countdown"></span>
                        <span class="reset text-primary cursor-pointer" id="otp-resend"
                            data-route="{{ route('otp-resend') }}">{{ __('Resend code') }}</span>
                    </p>
                    <button class="verify-btn btn btn-outline-danger submit-btn">{{ __('Verify') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Verify Modal end -->

<!-- success Modal Start -->
<div class="modal fade" id="successmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content success-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body success-modal-body text-center">
                <img src="{{ asset(get_option('general')['common_header_logo'] ?? 'assets/img/icon/1.svg') }}"
                    alt="">
                <h4>{{ __('Successfully!') }}</h4>
                <p>{{ __('Congratulations, Your account has been') }} <br> {{ __('successfully created') }}</p>
                <a href="{{ get_option('general')['app_link'] ?? '' }}"
                    class="cancel-btn btn btn-outline-danger">{{ __('Download Apk') }}</a>
            </div>
        </div>
    </div>
</div>
<!--success Modal end -->
