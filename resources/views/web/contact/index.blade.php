@extends('layouts.web.master')

@section('title')
    {{ __('Contact us') }}
@endsection


@section('main_content')
    <section class="banner-bg p-4">
        <div class="container">
            <p class="mb-0 fw-bolder custom-clr-dark">
                {{ __('Home') }} <span class="font-monospace">></span> {{ __('Contact Us') }}
            </p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>{{ $page_data['headings']['contact_us_title'] ?? '' }}</h2>
                <p>
                    {{ $page_data['headings']['contact_us_description'] ?? '' }}
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-3 align-self-center">
                    <div class="contact-image">
                        <img src="{{ asset($page_data['contact_us_icon'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="image" class="w-100 object-fit-cover rounded-2" />
                    </div>
                </div>
                <div class="col-lg-6 mb-3 align-self-center">
                    <form action="{{ route('contact.store') }}" method="post" class="ajaxform_instant_reload">
                        @csrf
                        <div class="row contact">
                            <div class="col-md-12 mb-2">
                                <label for="full-name" class="col-form-label fw-medium">{{ __('Full Name') }} <span class="text-orange">*</span></label>
                                <input type="text" name="name" class="form-control" required id="full-name" placeholder="{{ __('Enter full name') }}" />
                            </div>

                            <div class="col-md-12 mb-2">
                                <label for="phone-number" class="col-form-label fw-medium">{{ __('Phone Number') }} <span
                                        class="text-orange">*</span></label>
                                <input type="number" name="phone" class="form-control" required id="phone-number"
                                    placeholder="{{ __('Enter phone number') }}" />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="email" class="col-form-label fw-medium">{{ __('Email') }} <span
                                        class="text-orange">*</span></label>
                                <input type="email"  name="email" class="form-control" required id="email"
                                    placeholder="{{ __('Enter email address') }}" />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="company-name" class="col-form-label fw-medium">{{ __('Company') }}
                                    <small class="text-body-secondary">(Optional)</small></label>
                                <input type="text" name="company_name" class="form-control"
                                    placeholder="{{ __('Enter company name') }}" />
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="message" class="col-form-label fw-medium">{{ __('Message') }}</label>
                                <textarea  name="message" class="form-control" required rows="4" placeholder="{{ __('Enter your message') }}"></textarea>
                            </div>
                            <div class="py-1 mt-3">
                                <button type="submit" class="custom-btn custom-message-btn submit-btn">
                                    {{ $page_data['headings']['contact_us_btn_text'] ?? '' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
