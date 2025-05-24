@extends('layouts.web.master')

@section('title')
    {{ __('Contact us') }}
@endsection


@section('content')
    <section class="banner-bg p-4 bg-primary bg-opacity-10 border-bottom mb-4">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none custom-clr-primary">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active custom-clr-dark" aria-current="page">{{ __('Contact Us') }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="contact-section py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="fw-bold custom-clr-dark">{{ $page_data['headings']['contact_us_title'] ?? '' }}</h2>
                <p class="text-secondary">{{ $page_data['headings']['contact_us_description'] ?? '' }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6 align-self-center">
                    <div class="contact-image rounded-4 overflow-hidden shadow-sm bg-white p-2">
                        <img src="{{ asset($page_data['contact_us_icon'] ?? 'assets/images/icons/img-upload.png') }}"
                            alt="image" class="w-100 object-fit-cover rounded-4" style="min-height: 220px; background: #f8f9fa;" />
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <form action="{{ route('contact.store') }}" method="post" class="ajaxform_instant_reload">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="full-name" class="form-label fw-medium">{{ __('Full Name') }} <span class="text-orange">*</span></label>
                                <input type="text" name="name" class="form-control" required id="full-name" placeholder="{{ __('Enter full name') }}" />
                            </div>
                            <div class="col-12">
                                <label for="phone-number" class="form-label fw-medium">{{ __('Phone Number') }} <span class="text-orange">*</span></label>
                                <input type="number" name="phone" class="form-control" required id="phone-number" placeholder="{{ __('Enter phone number') }}" />
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label fw-medium">{{ __('Email') }} <span class="text-orange">*</span></label>
                                <input type="email" name="email" class="form-control" required id="email" placeholder="{{ __('Enter email address') }}" />
                            </div>
                            <div class="col-12">
                                <label for="company-name" class="form-label fw-medium">{{ __('Company') }} <small class="text-body-secondary">(Optional)</small></label>
                                <input type="text" name="company_name" class="form-control" placeholder="{{ __('Enter company name') }}" />
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fw-medium">{{ __('Message') }}</label>
                                <textarea name="message" class="form-control" required rows="4" placeholder="{{ __('Enter your message') }}"></textarea>
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="btn theme-btn custom-message-btn submit-btn px-4 fw-semibold">
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
