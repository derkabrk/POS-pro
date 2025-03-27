@extends('business::layouts.master')

@section('title')
    {{ __('Roles') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{ __('Edit User Role') }}</h4>
                    </div>
                    <div class="justify-content-center mt-2 roles-permissions p-16">
                        <div>
                            <form action="{{ route('business.roles.update', $user->id) }}" method="post" class=" ajaxform_instant_reload">
                                @csrf
                                @method('PUT')
                                <div>
                                    <div class="row">
                                        <div class="col-lg-6 form-group role-input-label">
                                            <label class="required">{{ __('User Title') }}</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="form-control" placeholder="{{ __('Enter user title') }}" required>
                                        </div>

                                        <div class="col-lg-6 form-group role-input-label">
                                            <label for="email" class="required">{{ __('Email Address') }}</label>
                                            <input type="email" name="email" value="{{ $user->email }}"
                                                class="form-control" placeholder="{{ __('Enter Email Address') }}" required>
                                        </div>

                                        <div class="col-lg-6 form-group role-input-label">
                                            <label for="password">{{ __('Update Password') }}</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="{{ __('Enter Password') }}">
                                        </div>

                                        <table class="table mt-3">
                                            <tbody>
                                                <tr>
                                                    <td class="border-0  mb-2">
                                                        <div class="custom-control custom-checkbox d-flex align-items-center gap-2">
                                                            <input type="checkbox" class="custom-control-input user-check-box"
                                                                id="selectAll">
                                                            <label class="custom-control-label fw-bold"
                                                                for="selectAll">{{ __('Select All') }}</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="profileEditPermission"
                                                                        class="custom-control-input user-check-box" id="profile_edit"
                                                                        {{ $user->visibility['profileEditPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                        for="profile_edit">{{ __('Profile Edit') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="salePermission"
                                                                        class="custom-control-input user-check-box" id="sale"
                                                                        {{ $user->visibility['salePermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                        for="sale">{{ __('Sales') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="salesListPermission"
                                                                           class="custom-control-input user-check-box" id="stock"
                                                                        {{ $user->visibility['salesListPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                           for="stock">{{ __('Sales List') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="purchasePermission"
                                                                        class="custom-control-input user-check-box" id="purchase"
                                                                        {{ $user->visibility['purchasePermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                        for="purchase">{{ __('Purchase') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="purchaseListPermission"
                                                                           class="custom-control-input user-check-box" id="stock"
                                                                        {{ $user->visibility['purchaseListPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                           for="stock">{{ __('Purchase List') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="productPermission"
                                                                        class="custom-control-input user-check-box" id="product"
                                                                        {{ $user->visibility['productPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                        for="product">{{ __('Products') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4  mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="stockPermission"
                                                                           class="custom-control-input user-check-box" id="stock"
                                                                        {{ $user->visibility['stockPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                           for="stock">{{ __('Stock') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="partiesPermission"
                                                                           class="custom-control-input user-check-box" id="party"
                                                                        {{ $user->visibility['partiesPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                           for="party">{{ __('Parties') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="addIncomePermission"
                                                                           class="custom-control-input user-check-box" id="stock"
                                                                        {{ $user->visibility['addIncomePermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                           for="stock">{{ __('Income') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="addExpensePermission"
                                                                           class="custom-control-input user-check-box" id="stock"
                                                                        {{ $user->visibility['addExpensePermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                           for="stock">{{ __('Expense') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="dueListPermission"
                                                                        class="custom-control-input user-check-box" id="due_list"
                                                                        {{ $user->visibility['dueListPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                        for="due_list">{{ __('Due List') }}</label>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="shippingPermission"
                                                                        class="custom-control-input user-check-box" id="shipping"
                                                                        {{ $user->visibility['shippingPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                        for="shipping">Shipping</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="lossProfitPermission"
                                                                           class="custom-control-input user-check-box" id="stock"
                                                                        {{ $user->visibility['lossProfitPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                           for="stock">{{ __('Loss Profit') }}</label>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex col-lg-4 mb-2">
                                                                <div class="custom-control custom-checkbox mr-3 me-lg-5  d-flex align-items-center gap-2">
                                                                    <input type="checkbox" name="reportsPermission"
                                                                        class="custom-control-input user-check-box" id="stock"
                                                                        {{ $user->visibility['reportsPermission'] ?? false ? 'checked' : '' }}>
                                                                    <label class="custom-control-label fw-bold"
                                                                        for="stock">{{ __('Reports') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div
                                            class="col-lg-12 text-center mt-3 d-flex align-items-center justify-content-center gap-3">
                                            <button type="reset" class="btn btn-sm role-reset-btn"><i
                                                    class="fas fa-undo-alt"></i> {{ __('Reset') }}</button>
                                            <button type="submit"
                                                class="btn btn-sm btn-warning btn-custom-warning fw-bold me-2 submit-btn"><i
                                                    class="fas fa-save"></i> {{ __('Save') }}</button>
                                        </div>
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
