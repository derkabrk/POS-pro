@extends('business::layouts.master')

@section('title')
    {{__('Roles')}}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{__('User Role')}}</h4>
                    </div>
                    <div class="row mb-4 p-16">

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
                                            <a href="{{ route('business.roles.create') }}">
                                                <span class="btn btn-warning btn-custom-warning fw-bold  btn-sm mb-1">{{ __("Add User Role") }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach($users as $user)
                            <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                <div class="cards shadow border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                            <div class="role-heading">
                                                <h4 class="fw-bolder">{{ ucfirst($user->name) }}</h4>
                                                <p>{{ $user->email }}</p>
                                                <a class="primary" href="{{ route('business.roles.edit', $user->id) }}">
                                                    <small class="fw-bolder">{{ __("Edit Role") }}</small>
                                                </a>
                                            </div>

                                            <div class="card-body text-sm-end text-center ps-sm-0 ms-2">
                                                <a href="{{ route('business.roles.destroy', $user->id) }}" class="confirm-action" data-method="DELETE">
                                                    <span class="btn btn-warning btn-custom-warning fw-bold btn-sm">{{ __("Delete") }}</span>
                                                </a>
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
