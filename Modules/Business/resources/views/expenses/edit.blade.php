<div class="modal fade" id="expenses-edit-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Expense') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal ajaxform_instant_reload expenseUpdateForm">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expense_amount" class="form-label">{{ __('Amount') }}</label>
                            <input type="number" name="amount" id="expense_amount" required class="form-control" placeholder="{{ __('Enter amount') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expenseCategoryId" class="form-label">{{ __('Category') }}</label>
                            <select class="form-select" id="expenseCategoryId" name="expense_category_id" required>
                                <option value="">{{ __('Select A Category') }}</option>
                                @foreach ($expense_categories as $expense_category)
                                <option value="{{ $expense_category->id }}">{{ $expense_category->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expe_for" class="form-label">{{ __('Expense For') }}</label>
                            <input type="text" name="expanseFor" id="expe_for" class="form-control" placeholder="{{ __('Enter Expense For') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expensePaymentType" class="form-label">{{ __('Payment Type') }}</label>
                            <select class="form-select" id="expensePaymentType" name="payment_type_id" required>
                                <option value="">{{ __('Select a payment type') }}</option>
                                @foreach($payment_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="refeNo" class="form-label">{{ __('Reference Number') }}</label>
                            <input type="text" name="referenceNo" id="refeNo" class="form-control" placeholder="{{ __('Enter reference number') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_date_expe" class="form-label">{{ __('Expense Date') }}</label>
                            <input type="date" name="expenseDate" id="edit_date_expe" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="expenote" class="form-label">{{__('Note')}}</label>
                            <textarea name="note" id="expenote" class="form-control" placeholder="{{ __('Enter note') }}"></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('business.expenses.index') }}" class="btn btn-outline-secondary me-2">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
