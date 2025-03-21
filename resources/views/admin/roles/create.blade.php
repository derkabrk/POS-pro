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
                <h4>{{__('Add New Role')}}</h4>
                <small class="text-warning">{{ __('Set role permissions') }}</small>
            </div>
            <div class="row justify-content-center mt-2 roles-permissions p-16">
                <div class="col-md-12">
                    <form action="{{ route('admin.roles.store') }}" method="post" class="row ajaxform_instant_reload">
                        @csrf

                        <div class="col-12 form-group role-input-label">
                            <label for="name" class="required">{{ __("Role Name") }}</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="{{ __("Enter role name") }}" required>
                        </div>

                        <div class="col-12">
                            <h4 class="mt-3 mb-3">{{ __("Role Permissions") }}</h4>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-bolder">
                                            {{ __("Setup role permissions") }}
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="selectAll">
                                                <label class="custom-control-label fw-bold" for="selectAll">{{ __('Select All') }}</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($groups as $key => $group)
                                        <tr>
                                            <td class="text-nowrap fw-bolder">{{ $key }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    @foreach($group as $permission)
                                                        <div class="custom-control custom-checkbox mr-3 me-lg-5">
                                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="custom-control-input" id="id_{{ $permission->id }}">
                                                            <label class="custom-control-label fw-bold" for="id_{{ $permission->id }}">
                                                                {{ ucfirst(str($permission->name)->explode('-')->last()) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-12 text-center mt-2">
                                <button type="reset" class="btn btn-sm role-reset-btn">
                                    <i class="fas fa-undo-alt"></i> {{ __("Reset") }}
                                </button>
                                <button type="submit" class="btn btn-sm btn-warning btn-custom-warning fw-bold me-2 submit-btn"><i class="fas fa-save"></i> {{ __("Save") }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


                </div>
            </div>
        </div>
    </div>
@endsection

