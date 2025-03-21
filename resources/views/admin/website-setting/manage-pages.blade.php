@extends('layouts.master')

@section('title')
    {{ __('CMS Manage') }}
@endsection

@section('main_content')
    <div class="erp-table-section system-settings">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">


            <div class="table-header p-16">
                <div class="card-bodys">
                    <h4>🚩 {{ __('Page for Updating Website Sections') }}</h4>
                </div>
            </div>
            <div class="tab-content p-16">
                <div class="tab-pane fade active show" id="add-new-petty" role="tabpanel">
                    <div class="table-header border-0">
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                            <div class="order-form-section">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4 mb-3">
                                        <div class="cards-header shadow">
                                            <div class="card-body">
                                                <ul class="nav nav-pills flex-column w-280">
                                                    <li class="nav-item">
                                                        <a href="#slider" id="home-tab4"
                                                            class="add-report-btn nav-link active"
                                                            data-bs-toggle="tab">{{ __('Slider Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#header" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Header Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#feature" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Feature Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#interface" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Interface Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#watch" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Watch Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#testimonial" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Testimonial Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#blog" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Blog Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#about_us" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('About us Page') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#contact_us" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Contuct us Page') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#pricing" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Pricing Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#footer" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">{{ __('Footer Section') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="#socials" class="add-report-btn nav-link"
                                                            data-bs-toggle="tab">
                                                            {{ __('Social Medias') }}
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-8">
                                        <div class="cards-header shadow">
                                            <div class="card-body">
                                                <form
                                                    action="{{ route('admin.website-settings.update', 'manage-pages') }}"
                                                    method="post" class="ajaxform">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="tab-content no-padding">
                                                        {{-- Slider Section Start --}}
                                                        <div class="tab-pane fade show active" id="slider">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label>{{ __('Title') }}</label>
                                                                    <input type="text" name="slider_title"
                                                                        value="{{ $page_data['headings']['slider_title'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Title') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <label>{{ __('Button One') }}</label>
                                                                    <input type="text" name="slider_btn1"
                                                                        value="{{ $page_data['headings']['slider_btn1'] ?? '' }}"
                                                                        placeholder="{{ __('Button Text') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <label>{{ __('Button One Link') }}</label>
                                                                    <input type="text" name="slider_btn1_link"
                                                                        value="{{ $page_data['headings']['slider_btn1_link'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Link') }}" class="form-control">
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <label>{{ __('Button Two') }}</label>
                                                                    <input type="text" name="slider_btn2"
                                                                        value="{{ $page_data['headings']['slider_btn2'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Text') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <label>{{ __('Button Two Link') }}</label>
                                                                    <input type="text" name="slider_btn2_link"
                                                                        value="{{ $page_data['headings']['slider_btn2_link'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Link') }}" class="form-control">
                                                                    <span
                                                                        class="text-danger">{{ __('Note: Enter embedded video link') }}</span>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label>{{ __('Description') }}</label>
                                                                    <textarea name="slider_description" placeholder="{{ __('Enter Description') }}" class="form-control">{{ $page_data['headings']['slider_description'] ?? '' }}</textarea>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label>{{ __('Scanner Text') }}</label>
                                                                    <input type="text" name="slider_scanner_text"
                                                                        value="{{ $page_data['headings']['slider_scanner_text'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Title') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-sm-10 align-self-center">
                                                                    <label class="img-label">{{ __('Scanner Image') }}</label>
                                                                    <input type="file" name="scanner_image"
                                                                        accept="image/*"
                                                                        class="form-control file-input-change"
                                                                        data-id="scanner_image">
                                                                </div>

                                                                <div class="col-sm-2 align-self-center mt-3">
                                                                    <img class="table-img" id="scanner_image"
                                                                        src="{{ asset($page_data['scanner_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                        alt="img">
                                                                </div>

                                                                <div class="col-sm-10 align-self-center">
                                                                    <label class="img-label">{{ __('Slider Image') }}</label>
                                                                    <input type="file" name="slider_image"
                                                                        accept="image/*"
                                                                        class="form-control file-input-change"
                                                                        data-id="slider_image">
                                                                </div>

                                                                <div class="col-sm-2 align-self-center mt-3">
                                                                    <img class="table-img" id="slider_image"
                                                                        src="{{ asset($page_data['slider_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                        alt="img">
                                                                </div>

                                                                <div class="col-12">
                                                                    <h4 class="mb-3">{{ __('Shop') }}</h4>
                                                                    <button
                                                                        class="w-100 py-3 d-block text-center fw-bold mt-3 admin-collapse bg-light primary border-0"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#slider_shop"
                                                                        aria-expanded="false" aria-controls="slider_shop">
                                                                        {{ __('Shop') }} <i
                                                                            class="fas fa-arrow-circle-down ms-2"></i>
                                                                    </button>
                                                                    <div class="collapse mt-3" id="slider_shop">
                                                                        @foreach ($page_data['headings']['silder_shop_text'] ?? [] as $key => $silder_shop_text)
                                                                            <div
                                                                                class="sample-form-wrp duplicate-feature pe-3">
                                                                                <div class="row mb-4">
                                                                                    <div class="col-lg-12">
                                                                                        <label>{{ __('Shop') }}-
                                                                                            {{ $key + 1 }} </label>
                                                                                        <input type="text"
                                                                                            name="silder_shop_text[]"
                                                                                            value="{{ $silder_shop_text ?? '' }}"
                                                                                            required class="form-control"
                                                                                            placeholder="{{ __('Enter text') }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Slider section End --}}

                                                        {{-- Header section start --}}
                                                        <div class="tab-pane fade" id="header">
                                                            <div class="form-group">
                                                                <label>{{ __('Header Button Text') }}</label>
                                                                <input type="text" name="header_btn_text"
                                                                    value="{{ $page_data['headings']['header_btn_text'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Title') }}" required
                                                                    class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>{{ __('Header Button Link') }}</label>
                                                                <input type="text" name="header_btn_link"
                                                                    value="{{ $page_data['headings']['header_btn_link'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Header link') }}" class="form-control">
                                                            </div>
                                                        </div>
                                                        {{-- Header section End --}}

                                                        {{-- Feature section start --}}
                                                        <div class="tab-pane fade" id="feature">
                                                            <div class="form-group">
                                                                <label>{{ __('Section Title') }}</label>
                                                                <input type="text" name="feature_title"
                                                                    value="{{ $page_data['headings']['feature_title'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Section Title') }}" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        {{-- Feature section End --}}

                                                        {{-- Interface section start --}}
                                                        <div class="tab-pane fade" id="interface">
                                                            <div class="form-group">
                                                                <label>{{ __('Interface Title') }}</label>
                                                                <input type="text" name="interface_title"
                                                                    value="{{ $page_data['headings']['interface_title'] ?? '' }}"
                                                                    required class="form-control"
                                                                    placeholder="{{ __('Enter Title') }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea name="interface_description" class="form-control" placeholder="{{ __('Enter Description') }}">{{ $page_data['headings']['interface_description'] ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        {{-- Interface section End --}}

                                                        {{-- Watch section start --}}
                                                        <div class="tab-pane fade" id="watch">
                                                            <div class="form-group">
                                                                <label>{{ __('Watch Title') }}</label>
                                                                <input type="text" name="watch_title"
                                                                    value="{{ $page_data['headings']['watch_title'] ?? '' }}"
                                                                    required class="form-control"
                                                                    placeholder="{{ __('Enter Title') }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ __('Button Link') }}</label>
                                                                <input type="text" name="watch_btn_link"
                                                                    value="{{ $page_data['headings']['watch_btn_link'] ?? '' }}"
                                                                    required class="form-control"
                                                                    placeholder="{{ __('Enter Link') }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea name="watch_description" class="form-control" placeholder="{{ __('Enter Description') }}">{{ $page_data['headings']['watch_description'] ?? '' }}</textarea>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-10 align-self-center">
                                                                    <label class="img-label">{{ __('Watch Image') }}</label>
                                                                    <input type="file" name="watch_image"
                                                                        accept="image/*"
                                                                        class="form-control file-input-change"
                                                                        data-id="watch_image">
                                                                </div>

                                                                <div class="col-sm-2 align-self-center mt-3">
                                                                    <img class="table-img" id="watch_image"
                                                                        src="{{ asset($page_data['watch_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                        alt="img">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Watch section End --}}

                                                        {{-- Blog section start --}}
                                                        <div class="tab-pane fade" id="blog">
                                                            <div class="form-group">
                                                                <label>{{ __('Blog Title') }}</label>
                                                                <input type="text" name="blog_title"
                                                                    value="{{ $page_data['headings']['blog_title'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Title') }}" required
                                                                    class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ __('Read More Button Text') }}</label>
                                                                <input type="text" name="blog_btn_text"
                                                                    value="{{ $page_data['headings']['blog_btn_text'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Title') }}" required
                                                                    class="form-control">
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <label>{{ __('View All Button Text') }}</label>
                                                                    <input type="text" name="blog_view_all_btn_text"
                                                                        value="{{ $page_data['headings']['blog_view_all_btn_text'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Text') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <label>{{ __('View All Link') }}</label>
                                                                    <input type="text" name="blog_view_all_btn_link"
                                                                        value="{{ $page_data['headings']['blog_view_all_btn_link'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Link') }}" required
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Blog section End --}}

                                                        {{-- Testimonial section start --}}
                                                        <div class="tab-pane fade" id="testimonial">
                                                            <div class="form-group">
                                                                <label>{{ __('Testimonial Title') }}</label>
                                                                <input type="text" name="testimonial_title"
                                                                    value="{{ $page_data['headings']['testimonial_title'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Title') }}" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        {{-- Testimonial section End --}}

                                                        {{-- About us section start --}}
                                                        <div class="tab-pane fade" id="about_us">
                                                            <div class="form-group">
                                                                <label>{{ __('Title') }}</label>
                                                                <input type="text" name="about_short_title"
                                                                    value="{{ $page_data['headings']['about_short_title'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Short Title') }}" required
                                                                    class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ __('Long Title') }}</label>
                                                                <input type="text" name="about_title"
                                                                    value="{{ $page_data['headings']['about_title'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Title') }}" required
                                                                    class="form-control">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-10 align-self-center">
                                                                    <label class="img-label">{{ __('About Image') }}</label>
                                                                    <input type="file" name="about_image"
                                                                        accept="image/*"
                                                                        class="form-control file-input-change"
                                                                        data-id="about_image">
                                                                </div>

                                                                <div class="col-sm-2 align-self-center mt-3">
                                                                    <img class="table-img" id="about_image"
                                                                        src="{{ asset($page_data['about_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                        alt="img">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{ __('Description One') }}</label>
                                                                <textarea name="about_desc_one" class="form-control" placeholder="{{ __('Enter Description') }}">{{ $page_data['headings']['about_desc_one'] ?? '' }}</textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>{{ __('Description Two') }}</label>
                                                                <textarea name="about_desc_two" class="form-control" placeholder="{{ __('Enter Description') }}">{{ $page_data['headings']['about_desc_two'] ?? '' }}</textarea>
                                                            </div>

                                                            <div class="col-12">
                                                                <h4 class="mb-3">{{ __('Option') }}</h4>
                                                                <button
                                                                    class="w-100 py-3 d-block text-center fw-bold mt-3 admin-collapse bg-light primary border-0"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#about_us_options"
                                                                    aria-expanded="false"
                                                                    aria-controls="about_us_options">
                                                                    {{ __('Option') }} <i
                                                                        class="fas fa-arrow-circle-down ms-2"></i>
                                                                </button>
                                                                <div class="collapse mt-3" id="about_us_options">
                                                                    @foreach ($page_data['headings']['about_us_options_text'] ?? [] as $key => $about_us_options_text)
                                                                        <div
                                                                            class="sample-form-wrp duplicate-feature pe-3">
                                                                            <div class="row mb-4">
                                                                                <div class="col-lg-12">
                                                                                    <label>{{ __('Option') }}-
                                                                                        {{ $key + 1 }} </label>
                                                                                    <input type="text"
                                                                                        name="about_us_options_text[]"
                                                                                        value="{{ $about_us_options_text ?? '' }}"
                                                                                        required class="form-control"
                                                                                        placeholder="{{ __('Enter text') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                        </div>
                                                        {{--  About Us section End --}}

                                                        {{-- Contact Us Section Start --}}
                                                        <div class="tab-pane fade" id="contact_us">

                                                            <div>
                                                                <div class="form-group">
                                                                    <label>{{ __('Title') }}</label>
                                                                    <input type="text" name="contact_us_title"
                                                                        value="{{ $page_data['headings']['contact_us_title'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Title') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>{{ __('Button Text') }}</label>
                                                                    <input type="text" name="contact_us_btn_text"
                                                                        value="{{ $page_data['headings']['contact_us_btn_text'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Text') }}" class="form-control">
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-10 align-self-center">
                                                                        <label class="img-label">{{ __('Icon') }}</label>
                                                                        <input type="file" name="contact_us_icon"
                                                                            accept="image/*"
                                                                            class="form-control file-input-change"
                                                                            data-id="contact_us_branch_icon">
                                                                    </div>

                                                                    <div class="col-lg-2 align-self-center mt-3">
                                                                        <img class="table-img" id="contact_us_icon"
                                                                            src="{{ asset($page_data['contact_us_icon'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                            alt="img">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>{{ __('Description') }}</label>
                                                                    <textarea name="contact_us_description" class="form-control" placeholder="{{ __('Enter Description') }}">{{ $page_data['headings']['contact_us_description'] ?? '' }}</textarea>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        {{-- Contact Us Section End --}}

                                                        {{-- Pricing section --}}
                                                        <div class="tab-pane fade" id="pricing">
                                                            <div class="form-group">
                                                                <label>{{ __('Title') }}</label>
                                                                <input type="text" name="pricing_title"
                                                                    value="{{ $page_data['headings']['pricing_title'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Title') }}" required
                                                                    class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>{{ __('Plan Button Url') }}</label>
                                                                <input type="text" name="pricing_btn_link"
                                                                    value="{{ $page_data['headings']['pricing_btn_link'] ?? '' }}"
                                                                    placeholder="{{ __('Enter Link') }}" required
                                                                    class="form-control">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>{{ __('Description') }}</label>
                                                                <textarea name="pricing_description" class="form-control" placeholder="{{ __('Enter Description') }}">{{ $page_data['headings']['pricing_description'] ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        {{-- pricing section end --}}

                                                        {{-- Footer Section Start --}}
                                                        <div class="tab-pane fade" id="footer">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label>{{ __('Short Title') }}</label>
                                                                    <input type="text" name="footer_short_title"
                                                                        value="{{ $page_data['headings']['footer_short_title'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Title') }}" required
                                                                        class="form-control">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label>{{ __('Scanner Text') }}</label>
                                                                    <input type="text" name="footer_scanner_title"
                                                                        value="{{ $page_data['headings']['footer_scanner_title'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Title') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-12">
                                                                    <label>{{ __('Right Footer Title') }}</label>
                                                                    <input type="text" name="right_footer_title"
                                                                        value="{{ $page_data['headings']['right_footer_title'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Title') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-12">
                                                                    <label>{{ __('Middle Footer Title') }}</label>
                                                                    <input type="text" name="middle_footer_title"
                                                                        value="{{ $page_data['headings']['middle_footer_title'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Title') }}" required
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-lg-10 mt-2">
                                                                    <div>
                                                                        <label class="img-label">{{ __('Scanner Image') }}</label>
                                                                        <input type="file" name="footer_scanner_image"
                                                                            accept="image/*"
                                                                            data-id="footer_scanner_image"
                                                                            onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2 mt-2 align-self-center">
                                                                    <div class="align-self-center mt-3">
                                                                        <img src="{{ asset($page_data['footer_scanner_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                            id="footer_scanner_image" class="table-img">
                                                                    </div>
                                                                </div>


                                                                <div class="col-5">
                                                                    <label>{{ __('Apple App Link') }}</label>
                                                                    <input type="text" name="footer_apple_app_link"
                                                                        value="{{ $page_data['headings']['footer_apple_app_link'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Link') }}" class="form-control">
                                                                </div>

                                                                <div class="col-lg-5">
                                                                    <div>
                                                                        <label class="img-label">{{ __('Apple App') }}</label>
                                                                        <input type="file"
                                                                            name="footer_apple_app_image" accept="image/*"
                                                                            data-id="footer_apple_app_image"
                                                                            onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2 mt-2 align-self-center">
                                                                    <div class="align-self-center mt-3">
                                                                        <img src="{{ asset($page_data['footer_apple_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                            id="footer_apple_app_image" class="table-img">
                                                                    </div>
                                                                </div>

                                                                <div class="col-5">
                                                                    <label>{{ __('Google Play Link') }}</label>
                                                                    <input type="text"
                                                                        name="footer_google_play_app_link"
                                                                        value="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}"
                                                                        placeholder="{{ __('Enter Link') }}" class="form-control">
                                                                </div>

                                                                <div class="col-lg-5">
                                                                    <div>
                                                                        <label class="img-label">{{ __('Google Play App') }}</label>
                                                                        <input type="file"
                                                                            name="footer_google_app_image"
                                                                            accept="image/*"
                                                                            data-id="footer_google_app_image"
                                                                            onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2 mt-2 align-self-center">
                                                                    <div class="align-self-center mt-3">
                                                                        <img src="{{ asset($page_data['footer_google_app_image'] ?? 'assets/images/icons/img-upload.png') }}"
                                                                            id="footer_google_app_image"
                                                                            class="table-img">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4 class="mb-3">{{ __('Right Footer') }}</h4>
                                                                    <button
                                                                        class="w-100 py-3 d-block text-center fw-bold mt-3 admin-collapse bg-light primary border-0"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#right_footer"
                                                                        aria-expanded="false"
                                                                        aria-controls="right_footer">
                                                                       {{ __('Right Footer') }}
                                                                        <i class="fas fa-arrow-circle-down ms-2"></i>
                                                                    </button>
                                                                    <div class="mt-3 collapse row" id="right_footer">
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_one"
                                                                                    value="{{ $page_data['headings']['right_footer_one'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_link_one"
                                                                                    value="{{ $page_data['headings']['right_footer_link_one'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_two"
                                                                                    value="{{ $page_data['headings']['right_footer_two'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_link_two"
                                                                                    value="{{ $page_data['headings']['right_footer_link_two'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_three"
                                                                                    value="{{ $page_data['headings']['right_footer_three'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_link_three"
                                                                                    value="{{ $page_data['headings']['right_footer_link_three'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_four"
                                                                                    value="{{ $page_data['headings']['right_footer_four'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_link_four"
                                                                                    value="{{ $page_data['headings']['right_footer_link_four'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_five"
                                                                                    value="{{ $page_data['headings']['right_footer_five'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_link_five"
                                                                                    value="{{ $page_data['headings']['right_footer_link_five'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_six"
                                                                                    value="{{ $page_data['headings']['right_footer_six'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="right_footer_link_six"
                                                                                    value="{{ $page_data['headings']['right_footer_link_six'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4 class="mb-3">{{ __('Middle Footer') }}</h4>
                                                                    <button
                                                                        class="w-100 py-3 d-block text-center fw-bold mt-3 admin-collapse bg-light primary border-0"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#middle_footer"
                                                                        aria-expanded="false"
                                                                        aria-controls="middle_footer">
                                                                       {{ __('Middle Footer') }}
                                                                        <i class="fas fa-arrow-circle-down ms-2"></i>
                                                                    </button>
                                                                    <div class="mt-3 collapse row" id="middle_footer">
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_one"
                                                                                    value="{{ $page_data['headings']['middle_footer_one'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_link_one"
                                                                                    value="{{ $page_data['headings']['middle_footer_link_one'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_two"
                                                                                    value="{{ $page_data['headings']['middle_footer_two'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_link_two"
                                                                                    value="{{ $page_data['headings']['middle_footer_link_two'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_three"
                                                                                    value="{{ $page_data['headings']['middle_footer_three'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_link_three"
                                                                                    value="{{ $page_data['headings']['middle_footer_link_three'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_four"
                                                                                    value="{{ $page_data['headings']['middle_footer_four'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_link_four"
                                                                                    value="{{ $page_data['headings']['middle_footer_link_four'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_five"
                                                                                    value="{{ $page_data['headings']['middle_footer_five'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_link_five"
                                                                                    value="{{ $page_data['headings']['middle_footer_link_five'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_six"
                                                                                    value="{{ $page_data['headings']['middle_footer_six'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="middle_footer_link_six"
                                                                                    value="{{ $page_data['headings']['middle_footer_link_six'] ?? '' }}"
                                                                                    required class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4 class="mb-3">{{ __('Left Footer') }}</h4>
                                                                    <button
                                                                        class="w-100 py-3 d-block text-center fw-bold mt-3 admin-collapse bg-light primary border-0"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#left_footer"
                                                                        aria-expanded="false" aria-controls="left_footer">
                                                                        {{ __('Left Footer') }}
                                                                        <i class="fas fa-arrow-circle-down ms-2"></i>
                                                                    </button>
                                                                    <div class="mt-3 collapse row" id="left_footer">
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_one"
                                                                                    value="{{ $page_data['headings']['left_footer_one'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_link_one"
                                                                                    value="{{ $page_data['headings']['left_footer_link_one'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_two"
                                                                                    value="{{ $page_data['headings']['left_footer_two'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_link_two"
                                                                                    value="{{ $page_data['headings']['left_footer_link_two'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_three"
                                                                                    value="{{ $page_data['headings']['left_footer_three'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_link_three"
                                                                                    value="{{ $page_data['headings']['left_footer_link_three'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_four"
                                                                                    value="{{ $page_data['headings']['left_footer_four'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_link_four"
                                                                                    value="{{ $page_data['headings']['left_footer_link_four'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-4">
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Title') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_five"
                                                                                    value="{{ $page_data['headings']['left_footer_five'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label>{{ __('Link') }}</label>
                                                                                <input type="text"
                                                                                    name="left_footer_link_five"
                                                                                    value="{{ $page_data['headings']['left_footer_link_five'] ?? '' }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Footer section End --}}

                                                        {{-- Social section start --}}
                                                        <div class="tab-pane fade" id="socials">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4 class="mb-3">{{ __('Footer Socials') }}</h4>
                                                                    <button
                                                                        class="w-100 py-3 d-block text-center fw-bold mt-3 admin-collapse bg-light primary border-0"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#footer-socials"
                                                                        aria-expanded="false"
                                                                        aria-controls="footer-socials">
                                                                        {{ __('Footer Socials') }} <i
                                                                            class="fas fa-arrow-circle-down ms-2"></i>
                                                                    </button>
                                                                    <div class="collapse mt-3" id="footer-socials">
                                                                        @foreach ($page_data['headings']['footer_socials_links'] ?? [] as $key => $footer_socials_links)
                                                                            <div
                                                                                class="sample-form-wrp duplicate-feature pe-3">
                                                                                <div class="row mb-4">
                                                                                    <div class="col-sm-6">
                                                                                        <label>{{ __('Link') }}</label>
                                                                                        <input type="text"
                                                                                            name="footer_socials_links[]"
                                                                                            value="{{ $footer_socials_links ?? '' }}"
                                                                                            required class="form-control">
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-sm-5 align-self-center">
                                                                                        <label class="img-label">{{ __('Icon') }}</label>
                                                                                        <input type="file"
                                                                                            name="footer_socials_icons[]"
                                                                                            accept="image/*"
                                                                                            class="form-control image-input">
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-sm-1 align-self-center mt-2">
                                                                                        <img width="100%" height="auto"
                                                                                            class="image-preview"
                                                                                            data-default-src="{{ asset('assets/img/demo-img.png') }}"
                                                                                            id="footer_socials_icons"
                                                                                            src="{{ asset($page_data['footer_socials_icons'][$key] ?? 'assets/img/demo-img.png') }}"
                                                                                            alt="img">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Social section end --}}

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="button-group text-center mt-4">
                                                                    <button
                                                                        class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
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
                        </div>
                    </div>
                </div>
            </div>

                </div>
                </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
@endpush
