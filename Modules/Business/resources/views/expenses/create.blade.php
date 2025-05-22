<div class="modal fade" id="expenses-create-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Expense') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.expenses.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal ajaxform_instant_reload">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">{{ __('Amount') }}</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="{{ __('Enter Amount') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expense_category_id" class="form-label">{{ __('Category') }}</label>
                            <select id="expense_category_id" class="form-select" name="expense_category_id" required>
                                <option value="">{{ __('Select A Category') }}</option>
                                @foreach ($expense_categories as $expense_category)
                                <option value="{{ $expense_category->id }}">{{ $expense_category->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expanseFor" class="form-label">{{ __('Expense For') }}</label>
                            <input type="text" id="expanseFor" name="expanseFor" class="form-control" placeholder="{{ __('Enter Expense For') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="payment_type_id" class="form-label">{{ __('Payment Type') }}</label>
                            <select id="payment_type_id" class="form-select" name="payment_type_id" required>
                                <option value="">{{ __('Select a payment type') }}</option>
                                @foreach($payment_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="referenceNo" class="form-label">{{ __('Reference Number') }}</label>
                            <input type="text" id="referenceNo" name="referenceNo" class="form-control" placeholder="{{ __('Enter reference number') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expenseDate" class="form-label">{{ __('Expense Date') }}</label>
                            <input type="date" id="expenseDate" name="expenseDate" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="note" class="form-label">{{__('Note')}}</label>
                            <textarea id="note" name="note" class="form-control" placeholder="{{ __('Enter note') }}"></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="reset" class="btn btn-outline-secondary me-2">{{ __('Reset') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
