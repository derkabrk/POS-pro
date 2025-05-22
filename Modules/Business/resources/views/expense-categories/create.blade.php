<div class="modal fade" id="expense-categories-create-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Expense Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.expense-categories.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal ajaxform_instant_reload">
                    @csrf

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('Category Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" name="categoryName" required class="form-control" placeholder="{{ __('Enter category name') }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">{{ __('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea name="categoryDescription" class="form-control" placeholder="{{ __('Enter description') }}"></textarea>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="reset" class="btn btn-secondary m-2">{{ __('Reset') }}</button>
                        <button type="submit" class="btn btn-primary m-2">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
