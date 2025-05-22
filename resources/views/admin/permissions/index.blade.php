@extends('layouts.master')

@section('title')
    {{ __('Assigned Role') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{__('Assigned Role')}}</h4>
            </div>
            <div class="card-body">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8 col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <h5 class="fw-bold">{{ __("Assign Role To User") }}</h5>
                                </div>
                                <form action="{{ route('admin.permissions.store') }}" method="post" class="row g-3 ajaxform_instant_reload">
                                    @csrf
                                    <div class="col-12">
                                        <label for="user" class="form-label required">{{ __("User") }}</label>
                                        <select name="user" id="user" class="form-control" required>
                                            <option>-{{ __('Select User') }}-</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="role" class="form-label required">{{ __("Role") }}</label>
                                        <select name="roles" id="role" class="form-control" required>
                                            <option>-{{ __('Select Role') }}-</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <button type="reset" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-undo-alt"></i> {{ __("Reset") }}
                                        </button>
                                        <button type="submit" class="btn btn-warning fw-bold">
                                            <i class="fas fa-save"></i> {{ __("Save") }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

