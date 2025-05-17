@extends('business::layouts.master')

@section('title')
    {{__('User Profile')}}
@endsection

@php
    $user = auth()->user();
@endphp

@section('main_content')
<div class="erp-state-overview-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="erp-dashboard-profile card">
                    <div class="profile-bg">
                        <img src="{{ asset('assets/images/profile/cover-photo.jpg') }}" alt="profile-bg">
                    </div>
                    <div class="profile-img">
                        <img id="profile_picture" src="{{ asset(Auth::user()->image ?? 'assets/images/icons/default-user.png') }}" alt="user avatar">
                    </div>
                    <div class="profile-details card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><span>{{ __('Shop Opening Balance') }}: </span>{{ currency_format($user->business?->shopOpeningBalance, 'icon', 2, business_currency()) }}</li>
                            <li class="list-group-item"><span>{{ __('Shop Remaining Balance') }}: </span>{{ currency_format($user->business?->remainingShopBalance, 'icon', 2, business_currency())}}</li>
                            <li class="list-group-item"><span>{{ __('Registration Date') }}:</span> {{ formatted_date($user->created_at) }}</li>
                            <li class="list-group-item"><span>{{ __('Plan Expire Date') }}:</span> {{ formatted_date(plan_data()['will_expire'] ?? '') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="erp-dashboard-profile-section card">
                    <div class="table-header">
                        <h4>{{__('User Profile')}}</h4>
                    </div>
                    <form action="{{ route('business.profiles.update',$user->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-lg-4 mt-3">
                                <label>{{__('Name')}}</label>
                            </div>
                            <div class="col-lg-8 mt-3">
                                <input type="text" name="name" value="{{ $user->name }}" required class="form-control" placeholder="{{ __('Enter Your Name') }}">
                            </div>
                            <div class="col-lg-4 mt-3">
                                <label>{{__('Email')}}</label>
                            </div>
                            <div class="col-lg-8 mt-3">
                                <input type="email" name="email" value="{{ $user->email }}" required class="form-control" placeholder="{{ __('Enter Your Email') }}">
                            </div>
                            <div class="col-lg-4 mt-3">
                                <label>{{__('Profile Picture')}}</label>
                            </div>
                            <div class="col-lg-8 mt-3">
                            <input type="file" name="image" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])" id="upload" class="form-control">
                            </div>
                            <div class="col-lg-4 mt-3">
                                <label>{{__('Current Password')}}</label>
                            </div>
                            <div class="col-lg-8 mt-3">
                                <input type="password" name="current_password" class="form-control" placeholder="{{ __('Enter Your Current Password') }}">
                            </div>
                            <div class="col-lg-4 mt-3">
                                <label>{{__('New Password')}}</label>
                            </div>
                            <div class="col-lg-8 mt-3">
                                <input type="password" name="password" class="form-control" placeholder="{{ __('Enter New Password') }}">
                            </div>
                            <div class="col-lg-4 mt-3">
                                <label>{{__('Confirm password')}}</label>
                            </div>
                            <div class="col-lg-8 mt-3">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm password') }}">
                            </div>
                            <div class="col-lg-12 mt-5">
                                <button type="submit" class="theme-btn submit-btn">{{__('Save Changes')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
