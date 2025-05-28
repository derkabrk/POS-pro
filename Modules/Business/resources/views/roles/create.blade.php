@extends('business::layouts.master')

@section('title')
    {{ __('Roles') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Add new Role')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('business.roles.index') }}" class="btn btn-primary">
                            <i class="ri-list-check" aria-hidden="true"></i> {{ __('Role List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('business.roles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="name" class="form-label">{{ __('User Title') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" required class="form-control" placeholder="{{ __('Enter user title') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" required class="form-control" placeholder="{{ __('Enter Email Address') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter Password') }}">
                                            <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                                <i class="ri-eye-off-line"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <div>
                                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm password') }}">
                                            <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;">
                                                <i class="ri-eye-off-line"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
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
                                                            {{-- Permission checkboxes here (inline) --}}
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
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-center mt-4">
                                        <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        // Password toggle visibility
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.password-toggle');
            
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
                    }
                });
            });
        });
    </script>
@endsection
