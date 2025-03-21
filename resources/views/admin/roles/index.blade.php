@extends('layouts.master')

@section('title')
    {{__('Roles')}}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{__('Roles List')}}</h4>
                    </div>
                    <div class="row mb-4 p-16">
                        @can('roles-create')
                        <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                            <div class="cards shadow border-0 h-100">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="d-flex align-items-end justify-content-center h-100">
                                            <img src="{{ asset('assets/images/icons/user-roles.svg') }}" class="img-fluid mt-2" alt="Image" width="85">
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="card-body text-sm-end text-center ps-sm-0 ms-2">
                                            <a href="{{ route('admin.roles.create') }}">
                                                <span class="btn btn-warning btn-custom-warning fw-bold text-uppercase btn-sm mb-1">{{ __("Add New Role") }}</span>
                                            </a>
                                            <small class="mb-0 d-block">{{ __("Add role, if it does not exist") }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @foreach($roles as $role)
                            <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                <div class="cards shadow border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ __("Total :count users", ['count' => $role->users_count]) }}</span>
                                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                                @foreach($role->users->take(5) as $user)
                                                    <li class="avatar avatar-sm pull-up">
                                                        <img class="rounded-circle" src="{{ asset($user->image) }}" alt="{{ ucfirst($user->name) }}">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                            <div class="role-heading">
                                                <h4 class="fw-bolder">{{ ucfirst($role->name) }} <i class="{{ request('id') == $role->id ? 'fas fa-bell text-red' : '' }}"></i></h4>
                                                @can('roles-update')
                                                <a class="primary" href="{{ route('admin.roles.edit', $role->id) }}">
                                                    <small class="fw-bolder">{{ __("Edit Role") }}</small>
                                                </a>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

