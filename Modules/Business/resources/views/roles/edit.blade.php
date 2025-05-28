@extends('business::layouts.master')

@section('title')
    {{ __('Roles') }}
@endsection

@section('content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card bg-white shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="table-header mb-4">
                        <h4 class="fw-bold mb-0">{{ __('Edit User Role') }}</h4>
                    </div>
                    <div class="row justify-content-center roles-permissions">
                        <div class="col-lg-10">
                            <form action="{{ route('business.roles.update', $user->id) }}" method="post" class="ajaxform_instant_reload">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <label class="required mb-2">{{ __('User Title') }}</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control form-control-lg" placeholder="{{ __('Enter user title') }}" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="email" class="required mb-2">{{ __('Email Address') }}</label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control form-control-lg" placeholder="{{ __('Enter Email Address') }}" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="password" class="mb-2">{{ __('Update Password') }}</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="{{ __('Enter Password') }}">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <table class="table table-bordered rounded-3 overflow-hidden">
                                        <tbody>
                                            <tr>
                                                <td class="border-0">
                                                    <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                        <input type="checkbox" class="custom-control-input user-check-box" id="selectAll">
                                                        <label class="custom-control-label fw-bold" for="selectAll">{{ __('Select All') }}</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row g-3">
                                                        {{-- Permission checkboxes here (same as before) --}}
                                                        @include('business::roles.partials.permissions')
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center gap-3 mt-4">
                                    <button type="reset" class="btn btn-light border role-reset-btn px-4 py-2"><i class="fas fa-undo-alt me-2"></i> {{ __('Reset') }}</button>
                                    <button type="submit" class="btn btn-warning btn-custom-warning fw-bold px-4 py-2 submit-btn"><i class="fas fa-save me-2"></i> {{ __('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
