@extends('layouts.master')

@section('title')
    {{ __('Assigned Role') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{__('Assigned Role')}}</h4>
                    </div>
                    <div class="row justify-content-center mb-4 p-16">
                        <div class="col-md-6">
                            <div class="cards shadow border-0 mt-4">
                                <div class="card-body permission">
                                    <div class="text-center mb-3">
                                        <h3>{{ __("Assign Role To User") }}</h3>
                                    </div>

                                    <form action="{{ route('admin.permissions.store') }}" method="post" class="row ajaxform_instant_reload">
                                        @csrf

                                        <div class="col-12 form-group mb-3">
                                            <label for="user" class="required">{{ __("User") }}</label>
                                            <div class="gpt-up-down-arrow position-relative">
                                            <select name="user" id="user" class="form-control" required>
                                                <option>-{{ __('Select User') }}-</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                            </div>
                                        </div>

                                        <div class="col-12 form-group mb-3">
                                            <label for="role" class="required">{{ __("Role") }}</label>
                                            <div class="gpt-up-down-arrow position-relative">
                                            <select name="roles" id="role" class="form-control" required>
                                                <option>-{{ __('Select Role') }}-</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center mt-4">
                                            <button type="reset" class="btn btn-sm role-reset-btn">
                                                <i class="fas fa-undo-alt"></i> {{ __("Reset") }}
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-warning btn-custom-warning fw-bold me-2 submit-btn"><i class="fas fa-save"></i> {{ __("Save") }}</button>
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
@endsection

