<div class="modal fade" id="registration-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-primary bg-opacity-10 border-0 rounded-top-4">
                <h1 class="modal-title fs-4 fw-bold custom-clr-dark">{{ __('Create a') }} <span id="subscription_name" class="custom-clr-primary">{{ __('Free') }}</span>
                    {{ __('account') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="personal-info">
                    <form id="registration-form" action="{{ route('register') }}" method="post"
                        enctype="multipart/form-data" class="add-brand-form pt-0 sign_up_form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label class="form-label fw-medium">{{ __('Company/Business Name') }}</label>
                                <input type="text" name="companyName"
                                    placeholder="{{ __('Enter business/store Name') }}" class="form-control" required />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label fw-medium">{{ __('Business Category') }}</label>
                                <div class="position-relative">
                                    <select name="business_category_id" id="business_category" class="form-select" required>
                                        @foreach ($business_categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label fw-medium">{{ __('Phone') }}</label>
                                <input type="number" name="phoneNumber" placeholder="{{ __('Enter Phone Number') }}"
                                    class="form-control" required />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label fw-medium">{{ __('Email Address') }}</label>
                                <input type="email" name="email" placeholder="{{ __('Enter Email Address') }}"
                                    class="form-control" required />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label fw-medium">{{ __('Password') }}</label>
                                <input type="password" name="password" placeholder="{{ __('Enter Password') }}"
                                    class="form-control" required />
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label fw-medium">{{ __('Company Address') }}</label>
                                <input type="text" name="address" placeholder="{{ __('Enter Company Address') }}"
                                    class="form-control" />
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label fw-medium">{{ __('Opening Balance') }}</label>
                                <input type="number" name="shopOpeningBalance"
                                    placeholder="{{ __('Enter Opening Balance') }}" class="form-control" />
                            </div>
                        </div>
                        <div class="offcanvas-footer mt-4 d-flex justify-content-center gap-2">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger px-4">
                                {{ __('Close') }}
                            </button>
                            <button class="btn btn-primary text-white px-4 fw-semibold" type="submit">
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
        <div class="modal-content verify-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-primary bg-opacity-10 rounded-top-4">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body verify-modal-body text-center p-4">

                <h4 class="mb-2 fw-bold custom-clr-dark">{{ __('Email Verification') }}</h4>
                <p class="des pb-3 text-secondary">{{ __('we sent an OTP in your email address') }} <br>
                    <span id="dynamicEmail" class="fw-semibold"></span>
                </p>
                <form action="{{ route('otp-submit') }}" method="post" class="verify_form">
                    @csrf
                    <div class="code-input pin-container d-flex justify-content-center gap-2 mb-3">
                        <input class="pin-input otp-input form-control text-center" id="pin-1" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input form-control text-center" id="pin-2" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input form-control text-center" id="pin-3" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input form-control text-center" id="pin-4" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input form-control text-center" id="pin-5" type="number" name="otp[]" maxlength="1">
                        <input class="pin-input otp-input form-control text-center" id="pin-6" type="number" name="otp[]" maxlength="1">
                    </div>



                    <p class="des pt-2 text-secondary">
                        {{ __('Code send in') }} <span id="countdown" class="countdown"></span>
                        <span class="reset text-primary cursor-pointer fw-semibold" id="otp-resend"
                            data-route="{{ route('otp-resend') }}">{{ __('Resend code') }}</span>
                    </p>
                    <button class="verify-btn btn btn-outline-danger submit-btn px-4 fw-semibold">{{ __('Verify') }}</button>
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
        <div class="modal-content success-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-primary bg-opacity-10 rounded-top-4">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body success-modal-body text-center p-4">
                <img src="{{ asset(get_option('general')['common_header_logo'] ?? 'assets/img/icon/1.svg') }}"
                    alt="" class="mb-3" style="max-height: 60px;">
                <h4 class="fw-bold custom-clr-dark mb-2">{{ __('Successfully!') }}</h4>
                <p class="text-secondary">{{ __('Congratulations, Your account has been') }} <br> {{ __('successfully created') }}</p>
                <a href="{{ get_option('general')['app_link'] ?? '' }}" class="btn btn-outline-danger px-4 fw-semibold">{{ __('Download Apk') }}</a>
            </div>
        </div>
    </div>
</div>
<!--success Modal end -->
