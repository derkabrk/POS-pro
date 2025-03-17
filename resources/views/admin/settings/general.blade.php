@extends('layouts.master')

@section('title')
    {{ __('General Settings') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{ __('General Settings') }}</h4>
                    </div>
                    <div class="order-form-section p-16">
                        <form action="{{ route('admin.settings.update', $general->id) }}" method="post"
                            enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="add-suplier-modal-wrapper d-block">
                                <div class="row">
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Title') }}</label>
                                        <input type="text" name="title" value="{{ $general->value['title'] ?? '' }}"
                                            required class="form-control" placeholder="{{ __('Enter Title') }}">
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <label>{{ __('Copy Right') }}</label>
                                        <input type="text" name="copy_right"
                                            value="{{ $general->value['copy_right'] ?? '' }}" required class="form-control"
                                            placeholder="{{ __('Enter Title') }}">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Admin Footer Text') }}</label>
                                        <input type="text" name="admin_footer_text"
                                            value="{{ $general->value['admin_footer_text'] ?? '' }}" required class="form-control"
                                            placeholder="{{ __('Enter Text') }}">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Admin Footer Link Text') }}</label>
                                        <input type="text" name="admin_footer_link_text"
                                            value="{{ $general->value['admin_footer_link_text'] ?? '' }}" required class="form-control"
                                            placeholder="{{ __('Enter Text') }}">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('Admin Footer Link') }}</label>
                                        <input type="text" name="admin_footer_link"
                                            value="{{ $general->value['admin_footer_link'] ?? '' }}" required class="form-control"
                                            placeholder="{{ __('Enter Link') }}">
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label>{{ __('App Link') }}</label>
                                        <input type="url" name="app_link" value="{{ $general->value['app_link'] ?? '' }}" class="form-control" placeholder="{{ __('Enter Link') }}">
                                    </div>

                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="title">{{ __('Main Header Logo') }}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="logo">
                                                </div>
                                                <input type="file" name="logo" class="d-none" accept="image/*"
                                                    onchange="document.getElementById('logo').src = window.URL.createObjectURL(this.files[0])"
                                                    class="form-control">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="title">{{ __('Common Header Logo') }}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img src="{{ asset($general->value['common_header_logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="common_header_logo">
                                                </div>
                                                <input type="file" name="common_header_logo" class="d-none"
                                                    accept="image/*"
                                                    onchange="document.getElementById('common_header_logo').src = window.URL.createObjectURL(this.files[0])"
                                                    class="form-control">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="title">{{ __('Footer Logo') }}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img src="{{ asset($general->value['footer_logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="footer_logo">
                                                </div>
                                                <input type="file" name="footer_logo" class="d-none"
                                                    accept="image/*"
                                                    onchange="document.getElementById('footer_logo').src = window.URL.createObjectURL(this.files[0])"
                                                    class="form-control">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="title">{{ __('Admin Logo') }}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img src="{{ asset($general->value['admin_logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="admin_logo">
                                                </div>
                                                <input type="file" name="admin_logo" class="d-none"
                                                    accept="image/*"
                                                    onchange="document.getElementById('admin_logo').src = window.URL.createObjectURL(this.files[0])"
                                                    class="form-control">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="title">{{ __('Favicon') }}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img src="{{ asset($general->value['favicon'] ?? 'assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="favicon">
                                                </div>
                                                <input type="file" name="favicon" class="d-none" accept="image/*"
                                                    onchange="document.getElementById('favicon').src = window.URL.createObjectURL(this.files[0])"
                                                    class="form-control">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="title">{{ __('Login Page Logo') }}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img src="{{ asset($general->value['login_page_logo'] ?? 'assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="login_page_logo">
                                                </div>
                                                <input type="file" name="login_page_logo" class="d-none" accept="image/*"
                                                    onchange="document.getElementById('login_page_logo').src = window.URL.createObjectURL(this.files[0])"
                                                    class="form-control">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 settings-image-upload">
                                        <label class="title">{{ __('Login Page Image') }}</label>
                                        <div class="upload-img-v2">
                                            <label class="upload-v4 settings-upload-v4">
                                                <div class="img-wrp">
                                                    <img src="{{ asset($general->value['login_page_image'] ?? 'assets/images/icons/upload-icon.svg') }}"
                                                        alt="user" id="login_page_image">
                                                </div>
                                                <input type="file" name="login_page_image" class="d-none" accept="image/*"
                                                    onchange="document.getElementById('login_page_image').src = window.URL.createObjectURL(this.files[0])"
                                                    class="form-control">
                                            </label>
                                        </div>
                                    </div>

                                    @can('settings-update')
                                        <div class="col-lg-12">
                                            <div class="text-center mt-5">
                                                <button type="submit"
                                                    class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
