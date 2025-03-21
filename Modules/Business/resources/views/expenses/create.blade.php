<div class="modal fade" id="expenses-create-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Create Expense') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="{{ route('business.expenses.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Amount') }}</label>
                                <input type="number" name="amount" class="form-control" placeholder="{{ __('Enter Amount') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="custom-top-label">{{ __('Category') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select class="form-control form-selected" name="expense_category_id" required>
                                        <option value="">{{ __('Select A Category') }}</option>
                                        @foreach ($expense_categories as $expense_category)
                                        <option value="{{ $expense_category->id }}">{{ $expense_category->categoryName }}</option>
                                        @endforeach
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Expense For') }}</label>
                                <input type="text" name="expanseFor" class="form-control" placeholder="{{ __('Enter Expense For') }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="custom-top-label">{{ __('Payment Type') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select class="form-control form-selected" name="payment_type_id" required>
                                        <option value="">{{ __('Select a payment type') }}</option>
                                        @foreach($payment_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Reference Number') }}</label>
                                <input type="text" name="referenceNo" class="form-control" placeholder="{{ __('Enter reference number') }}">
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Expense Date') }}</label>
                                <input type="date" name="expenseDate" class="form-control">
                            </div>
                            <div class="col-lg-12">
                                <label>{{__('Note')}}</label>
                                <textarea name="note" class="form-control" placeholder="{{ __('Enter note') }}"></textarea>
                            </div>
                         </div>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
