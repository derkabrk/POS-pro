@extends('layouts.master')

@section('title')
    {{ __('General Settings') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ __('General Settings') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update', $general->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label>{{ __('Title') }}</label>
                            <input type="text" name="title" value="{{ $general->value['title'] ?? '' }}" required class="form-control" placeholder="{{ __('Enter Title') }}">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label>{{ __('Copy Right') }}</label>
                            <input type="text" name="copy_right" value="{{ $general->value['copy_right'] ?? '' }}" required class="form-control" placeholder="{{ __('Enter Title') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Admin Footer Text') }}</label>
                            <input type="text" name="admin_footer_text" value="{{ $general->value['admin_footer_text'] ?? '' }}" required class="form-control" placeholder="{{ __('Enter Text') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Admin Footer Link Text') }}</label>
                            <input type="text" name="admin_footer_link_text" value="{{ $general->value['admin_footer_link_text'] ?? '' }}" required class="form-control" placeholder="{{ __('Enter Text') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Admin Footer Link') }}</label>
                            <input type="text" name="admin_footer_link" value="{{ $general->value['admin_footer_link'] ?? '' }}" required class="form-control" placeholder="{{ __('Enter Link') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('App Link') }}</label>
                            <input type="url" name="app_link" value="{{ $general->value['app_link'] ?? '' }}" class="form-control" placeholder="{{ __('Enter Link') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="title">{{ __('Main Header Logo') }}</label>
                            <div class="mb-2">
                                <img src="{{ asset($general->value['logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="logo" class="img-thumbnail" style="max-height: 60px;">
                            </div>
                            <input type="file" name="logo" accept="image/*" class="form-control" onchange="document.getElementById('logo').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="title">{{ __('Common Header Logo') }}</label>
                            <div class="mb-2">
                                <img src="{{ asset($general->value['common_header_logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="common_header_logo" class="img-thumbnail" style="max-height: 60px;">
                            </div>
                            <input type="file" name="common_header_logo" accept="image/*" class="form-control" onchange="document.getElementById('common_header_logo').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="title">{{ __('Footer Logo') }}</label>
                            <div class="mb-2">
                                <img src="{{ asset($general->value['footer_logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="footer_logo" class="img-thumbnail" style="max-height: 60px;">
                            </div>
                            <input type="file" name="footer_logo" accept="image/*" class="form-control" onchange="document.getElementById('footer_logo').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="title">{{ __('Admin Logo') }}</label>
                            <div class="mb-2">
                                <img src="{{ asset($general->value['admin_logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="admin_logo" class="img-thumbnail" style="max-height: 60px;">
                            </div>
                            <input type="file" name="admin_logo" accept="image/*" class="form-control" onchange="document.getElementById('admin_logo').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="title">{{ __('Favicon') }}</label>
                            <div class="mb-2">
                                <img src="{{ asset($general->value['favicon'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="favicon" class="img-thumbnail" style="max-height: 60px;">
                            </div>
                            <input type="file" name="favicon" accept="image/*" class="form-control" onchange="document.getElementById('favicon').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="title">{{ __('Login Page Logo') }}</label>
                            <div class="mb-2">
                                <img src="{{ asset($general->value['login_page_logo'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="login_page_logo" class="img-thumbnail" style="max-height: 60px;">
                            </div>
                            <input type="file" name="login_page_logo" accept="image/*" class="form-control" onchange="document.getElementById('login_page_logo').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="title">{{ __('Login Page Image') }}</label>
                            <div class="mb-2">
                                <img src="{{ asset($general->value['login_page_image'] ?? 'assets/images/icons/upload-icon.svg') }}" alt="user" id="login_page_image" class="img-thumbnail" style="max-height: 60px;">
                            </div>
                            <input type="file" name="login_page_image" accept="image/*" class="form-control" onchange="document.getElementById('login_page_image').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label>{{ __('Points per Invite') }}</label>
                            <input type="number" name="points_per_invite" min="0" value="{{ $general->value['points_per_invite'] ?? 10 }}" class="form-control" placeholder="{{ __('Enter points per invite') }}">
                        </div>
                        @can('settings-update')
                        <div class="col-lg-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary m-2 submit-btn">{{ __('Update') }}</button>
                        </div>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
