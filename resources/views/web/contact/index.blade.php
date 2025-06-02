@extends('layouts.web.master')

@section('title')
    {{ __('Contact us') }}
@endsection

@section('content')
<!-- Enhanced Hero Section -->
<section class="section pb-0 hero-section bg-primary bg-opacity-10 position-relative" id="hero">
    <div class="bg-overlay bg-overlay-pattern opacity-25"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mt-4 pt-4 pb-2">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb mb-0 bg-transparent p-0 justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="/" class="text-decoration-none text-primary fw-medium">
                                    <i class="ri-home-4-line me-1"></i>{{ __('Home') }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">
                                {{ __('Contact Us') }}
                            </li>
                        </ol>
                    </nav>
                    
                    <div class="avatar-sm icon-effect mx-auto mb-4">
                        <div class="avatar-title bg-transparent rounded-circle text-primary h1">
                            <i class="ri-phone-line fs-36"></i>
                        </div>
                    </div>
                    
                    <h1 class="display-6 fw-semibold mb-3 lh-base">
                        Get In <span class="text-primary">Touch</span>
                    </h1>
                    <p class="lead text-muted lh-base ff-secondary">
                        We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hero Shape -->
    <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
            <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z" fill="rgba(255,255,255,1)"></path>
            </g>
        </svg>
    </div>
</section>

<!-- Enhanced Contact Section -->
<section class="section bg-light py-5">
    <div class="container">
        <!-- Section Header -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="text-center">
                    <h3 class="mb-3 fw-semibold">
                        {{ $page_data['headings']['contact_us_title'] ?? 'Contact Information' }}
                    </h3>
                    <p class="text-muted mb-4 ff-secondary">
                        {{ $page_data['headings']['contact_us_description'] ?? 'We thrive when coming up with innovative ideas but also understand that a smart concept should be supported with measurable results.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Cards Row -->
        <div class="row gy-4 mb-5">
            <!-- Office Address -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body p-4">
                        <div class="avatar-lg mx-auto mb-4">
                            <div class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">
                                <i class="ri-map-pin-line fs-24"></i>
                            </div>
                        </div>
                        <h5 class="fw-semibold mb-3">Office Address</h5>
                        <p class="text-muted mb-0 ff-secondary">
                            4461 Cedar Street Moro,<br />
                            AR 72368, United States
                        </p>
                    </div>
                </div>
            </div>

            <!-- Phone Number -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body p-4">
                        <div class="avatar-lg mx-auto mb-4">
                            <div class="avatar-title bg-success bg-opacity-10 text-success rounded-circle">
                                <i class="ri-phone-line fs-24"></i>
                            </div>
                        </div>
                        <h5 class="fw-semibold mb-3">Phone Number</h5>
                        <p class="text-muted mb-2 ff-secondary">+1 (555) 123-4567</p>
                        <p class="text-muted mb-0 ff-secondary">+1 (555) 987-6543</p>
                    </div>
                </div>
            </div>

            <!-- Email Address -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body p-4">
                        <div class="avatar-lg mx-auto mb-4">
                            <div class="avatar-title bg-warning bg-opacity-10 text-warning rounded-circle">
                                <i class="ri-mail-line fs-24"></i>
                            </div>
                        </div>
                        <h5 class="fw-semibold mb-3">Email Address</h5>
                        <p class="text-muted mb-2 ff-secondary">info@company.com</p>
                        <p class="text-muted mb-0 ff-secondary">support@company.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Contact Form Section -->
        <div class="row gy-4 align-items-center">
            <!-- Contact Image -->
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="contact-image rounded-4 overflow-hidden shadow-lg bg-white p-3">
                        <img src="{{ asset($page_data['contact_us_icon'] ?? 'assets/images/icons/img-upload.png') }}"
                             alt="Contact Us" 
                             class="w-100 object-fit-cover rounded-4" 
                             style="min-height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" />
                    </div>
                    
                    <!-- Floating Elements -->
                    <div class="position-absolute top-0 end-0 translate-middle">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-primary rounded-circle">
                                <i class="ri-customer-service-line fs-18"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="position-absolute bottom-0 start-0 m-3">
                        <div class="badge bg-success bg-opacity-90 text-white px-3 py-2 rounded-pill">
                            <i class="ri-time-line me-1"></i>
                            24/7 Support
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 bg-white">
                    <div class="card-header bg-primary bg-opacity-10 border-0 rounded-top-4 p-4">
                        <h4 class="mb-0 fw-semibold text-primary">
                            <i class="ri-send-plane-line me-2"></i>Send us a Message
                        </h4>
                        <p class="text-muted mb-0 mt-2 small">
                            Fill out the form below and we'll get back to you within 24 hours
                        </p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="{{ route('contact.store') }}" method="post" class="ajaxform_instant_reload">
                            @csrf
                            <div class="row g-3">
                                <!-- Full Name -->
                                <div class="col-12">
                                    <label for="full-name" class="form-label fw-medium">
                                        <i class="ri-user-line me-1 text-primary"></i>{{ __('Full Name') }} 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control border-light bg-light" 
                                           required id="full-name" placeholder="{{ __('Enter your full name') }}" />
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6">
                                    <label for="phone-number" class="form-label fw-medium">
                                        <i class="ri-phone-line me-1 text-primary"></i>{{ __('Phone Number') }} 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" name="phone" class="form-control border-light bg-light" 
                                           required id="phone-number" placeholder="{{ __('Enter phone number') }}" />
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-medium">
                                        <i class="ri-mail-line me-1 text-primary"></i>{{ __('Email') }} 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control border-light bg-light" 
                                           required id="email" placeholder="{{ __('Enter email address') }}" />
                                </div>

                                <!-- Company -->
                                <div class="col-12">
                                    <label for="company-name" class="form-label fw-medium">
                                        <i class="ri-building-line me-1 text-primary"></i>{{ __('Company') }} 
                                        <small class="text-muted">(Optional)</small>
                                    </label>
                                    <input type="text" name="company_name" class="form-control border-light bg-light" 
                                           id="company-name" placeholder="{{ __('Enter company name') }}" />
                                </div>

                                <!-- Message -->
                                <div class="col-12">
                                    <label for="message" class="form-label fw-medium">
                                        <i class="ri-message-line me-1 text-primary"></i>{{ __('Message') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="message" class="form-control border-light bg-light" 
                                              required rows="4" id="message" 
                                              placeholder="{{ __('Tell us about your project or inquiry...') }}"></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 pt-2">
                                    <button type="submit" class="btn btn-primary btn-label rounded-pill w-100 submit-btn">
                                        <i class="ri-send-plane-line label-icon align-middle rounded-pill fs-16 me-2"></i>
                                        {{ $page_data['headings']['contact_us_btn_text'] ?? 'Send Message' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info Section -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="text-center bg-white rounded-4 p-4 p-lg-5 shadow-sm border">
                    <div class="row text-center gy-3">
                        <div class="col-lg-3 col-6">
                            <div class="py-3">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">
                                        <i class="ri-time-line fs-18"></i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">Response Time</h6>
                                <p class="text-muted mb-0 small">Within 2 hours</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="py-3">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-success bg-opacity-10 text-success rounded-circle">
                                        <i class="ri-customer-service-2-line fs-18"></i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">Support</h6>
                                <p class="text-muted mb-0 small">24/7 Available</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="py-3">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-warning bg-opacity-10 text-warning rounded-circle">
                                        <i class="ri-shield-check-line fs-18"></i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">Privacy</h6>
                                <p class="text-muted mb-0 small">100% Secure</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="py-3">
                                <div class="avatar-sm mx-auto mb-2">
                                    <div class="avatar-title bg-info bg-opacity-10 text-info rounded-circle">
                                        <i class="ri-global-line fs-18"></i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">Global Reach</h6>
                                <p class="text-muted mb-0 small">Worldwide Service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 bg-primary position-relative bg-opacity-50">
    <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-sm">
                <div>
                    <h4 class="text-white mb-2 fw-semibold">Ready to start your project?</h4>
                    <p class="text-white-50 mb-0">Let's discuss how we can help you achieve your goals</p>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="d-flex gap-2">
                    <a href="tel:+1555123456" class="btn bg-gradient btn-light">
                        <i class="ri-phone-line align-middle me-1"></i> Call Now
                    </a>
                    <a href="mailto:info@company.com" class="btn btn-outline-light">
                        <i class="ri-mail-line align-middle me-1"></i> Email Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
// Form enhancement and validation
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.ajaxform_instant_reload');
    const submitBtn = contactForm.querySelector('.submit-btn');
    
    // Enhanced form submission
    contactForm.addEventListener('submit', function(e) {
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="ri-loader-2-line me-2 spin"></i>Sending...';
        submitBtn.disabled = true;
        
        // Reset after 3 seconds (adjust based on your AJAX response)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
    
    // Real-time validation
    const requiredFields = contactForm.querySelectorAll('input[required], textarea[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
    
    // Email validation
    const emailField = contactForm.querySelector('input[type="email"]');
    if (emailField) {
        emailField.addEventListener('blur', function() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailPattern.test(this.value)) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });
    }
    
    // Phone number formatting
    const phoneField = contactForm.querySelector('input[type="tel"]');
    if (phoneField) {
        phoneField.addEventListener('input', function() {
            // Remove all non-digits
            let value = this.value.replace(/\D/g, '');
            
            // Format as (XXX) XXX-XXXX
            if (value.length >= 6) {
                value = `(${value.slice(0,3)}) ${value.slice(3,6)}-${value.slice(6,10)}`;
            } else if (value.length >= 3) {
                value = `(${value.slice(0,3)}) ${value.slice(3)}`;
            }
            
            this.value = value;
        });
    }
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add hover effects to contact cards
document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px)';
        this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
        this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '';
    });
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .spin { 
        animation: spin 1s linear infinite; 
    }
    @keyframes spin { 
        from { transform: rotate(0deg); } 
        to { transform: rotate(360deg); } 
    }
    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    .is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }
`;
document.head.appendChild(style);
</script>
@endsection