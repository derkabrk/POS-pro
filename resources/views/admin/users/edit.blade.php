@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('Edit Staff') }}</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm active">
                <i class="fas fa-list me-1"></i> {{ __('View List') }}
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                @csrf
                @method('put')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Full Name') }}</label>
                        <input type="text" name="name" value="{{ $user->name }}" required class="form-control" placeholder="{{ __('Enter Name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('Email')}}</label>
                        <input type="text" name="email" value="{{ $user->email }}" required class="form-control" placeholder="{{ __('Enter Email Address') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('Phone')}}</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control" placeholder="{{ __('Enter Phone Number') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('Image')}}</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" accept="image/*" name="image" class="form-control file-input-change" data-id="image">
                            <img src="{{ asset($user->image ?? 'assets/images/icons/upload.png') }}" id="image" class="table-img" style="max-width: 40px; max-height: 40px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('Role')}}</label>
                        <select name="role" required class="form-select select-2">
                            <option value="">{{__('Select a role')}}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected($user->role == $role->name)>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('New Password')}}</label>
                        <input type="password" name="password" class="form-control" placeholder="{{ __('Enter Password') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{__('Confirm password')}}</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm password') }}">
                    </div>
                    <div class="col-12 text-center mt-4">
                        <a href="{{ route('admin.users.index',['users'=>$user->role]) }}" class="btn btn-light me-3">{{__('Cancel')}}</a>
                        <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
