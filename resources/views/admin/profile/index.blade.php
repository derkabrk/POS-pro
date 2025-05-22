@extends('layouts.master')

@section('title')
    {{__('User Profile')}}
@endsection

@php
    $user = auth()->user();
@endphp

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-img-top profile-bg">
                    <img src="{{ asset('assets/images/profile/cover-photo.jpg') }}" alt="profile-bg" class="img-fluid rounded-top">
                </div>
                <div class="profile-img text-center mt-n5">
                    <img id="profile_picture" src="{{ asset(Auth::user()->image ?? 'assets/images/profile/profile-img.png') }}" alt="user avatar" class="rounded-circle border border-3" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><span class="fw-bold">{{ __('Name') }}: </span>{{ ucwords($user->name) }}</li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Email') }}: </span>{{ $user->email }}</li>
                        <li class="list-group-item"><span class="fw-bold">{{ __('Registration Date') }}:</span> {{ formatted_date($user->created_at) }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{__('User Profile')}}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profiles.update',$user->id) }}" method="post" enctype="multipart/form-data" class="row g-3 ajaxform_instant_reload">
                        @csrf
                        @method('put')
                        <div class="col-lg-6">
                            <label class="form-label">{{__('Name')}}</label>
                            <input type="text" name="name" value="{{ $user->name }}" required class="form-control" placeholder="{{ __('Enter Your Name') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{__('Email')}}</label>
                            <input type="email" name="email" value="{{ $user->email }}" required class="form-control" placeholder="{{ __('Enter Your Email') }}">
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">{{__('Profile Picture')}}</label>
                            <input type="file" name="image" onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])" id="upload" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{__('Current Password')}}</label>
                            <input type="password" name="current_password" class="form-control" placeholder="{{ __('Enter Your Current Password') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{__('New Password')}}</label>
                            <input type="password" name="password" class="form-control" placeholder="{{ __('Enter New Password') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{__('Confirm password')}}</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm password') }}">
                        </div>
                        <div class="col-12 text-end mt-3">
                            <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
