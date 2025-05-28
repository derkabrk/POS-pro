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
                        <h4 class="fw-bold mb-0">{{ __('Add User Role') }}</h4>
                    </div>
                    <div class="row justify-content-center roles-permissions">
                        <div class="col-lg-10">
                            <form action="{{ route('business.roles.store') }}" method="post" class="ajaxform_instant_reload">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <label class="required mb-2">{{ __('User Title') }}</label>
                                        <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="{{ __('Enter user title') }}" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="email" class="required mb-2">{{ __('Email Address') }}</label>
                                        <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="{{ __('Enter Email Address') }}" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="password" class="required mb-2">{{ __('Password') }}</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="{{ __('Enter Password') }}" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="confirm_password" class="required mb-2">{{ __('Confirm Password') }}</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="{{ __('Enter Confirm password') }}" required>
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
                                                        {{-- Permission checkboxes here (inline, since partial is missing) --}}
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="profileEditPermission" class="custom-control-input user-check-box" id="profile_edit">
                                                                <label class="custom-control-label fw-bold" for="profile_edit">{{ __('Profile Edit') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="salePermission" class="custom-control-input user-check-box" id="sale">
                                                                <label class="custom-control-label fw-bold" for="sale">{{ __('Sales') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="salesListPermission" class="custom-control-input user-check-box" id="sales_list">
                                                                <label class="custom-control-label fw-bold" for="sales_list">{{ __('Sales List') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="purchasePermission" class="custom-control-input user-check-box" id="purchase">
                                                                <label class="custom-control-label fw-bold" for="purchase">{{ __('Purchase') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="purchaseListPermission" class="custom-control-input user-check-box" id="purchase_list">
                                                                <label class="custom-control-label fw-bold" for="purchase_list">{{ __('Purchase List') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="productPermission" class="custom-control-input user-check-box" id="product">
                                                                <label class="custom-control-label fw-bold" for="product">{{ __('Products') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="stockPermission" class="custom-control-input user-check-box" id="stock">
                                                                <label class="custom-control-label fw-bold" for="stock">{{ __('Stock') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="partiesPermission" class="custom-control-input user-check-box" id="party">
                                                                <label class="custom-control-label fw-bold" for="party">{{ __('Parties') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="addIncomePermission" class="custom-control-input user-check-box" id="income">
                                                                <label class="custom-control-label fw-bold" for="income">{{ __('Income') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="addExpensePermission" class="custom-control-input user-check-box" id="expense">
                                                                <label class="custom-control-label fw-bold" for="expense">{{ __('Expense') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="dueListPermission" class="custom-control-input user-check-box" id="due_list">
                                                                <label class="custom-control-label fw-bold" for="due_list">{{ __('Due List') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="shippingPermission" class="custom-control-input user-check-box" id="shipping">
                                                                <label class="custom-control-label fw-bold" for="shipping">{{ __('Shipping') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="lossProfitPermission" class="custom-control-input user-check-box" id="loss_profit">
                                                                <label class="custom-control-label fw-bold" for="loss_profit">{{ __('Loss Profit') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex col-lg-4 mb-2">
                                                            <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                                <input type="checkbox" name="reportsPermission" class="custom-control-input user-check-box" id="reports">
                                                                <label class="custom-control-label fw-bold" for="reports">{{ __('Reports') }}</label>
                                                            </div>
                                                        </div>
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
