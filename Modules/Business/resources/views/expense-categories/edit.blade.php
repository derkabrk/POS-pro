<div class="modal fade" id="expense-categories-edit-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Expense Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal ajaxform_instant_reload expenseCategoryUpdateForm">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expense_categories_view_name" class="form-label">{{ __('Business Name') }}</label>
                            <input type="text" name="categoryName" id="expense_categories_view_name" required class="form-control" placeholder="{{ __('Enter Business Name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expense_categories_view_description" class="form-label">{{ __('Description') }}</label>
                            <textarea name="categoryDescription" id="expense_categories_view_description" class="form-control" placeholder="{{ __('Enter Description') }}"></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('business.expense-categories.index') }}" class="btn btn-secondary me-2">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
