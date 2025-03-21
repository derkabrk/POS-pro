<div class="modal fade" id="income-categories-edit-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Edit Income Category') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="" method="post" enctype="multipart/form-data"
                        class="ajaxform_instant_reload incomeCategoryUpdateForm">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-lg-6 mb-1">
                                <label>{{ __('Catgeory Name') }}</label>
                                <input type="text" name="categoryName" id="income_categories_view_name" required class="form-control" placeholder="{{ __('Enter catgeory name') }}">
                            </div>

                            <div class="col-lg-6 mt-1">
                                <label>{{__('Description')}}</label>
                                <textarea name="categoryDescription" id="income_categories_view_description" class="form-control" placeholder="{{ __('Enter Description') }}"></textarea>
                            </div>
                         </div>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <a href="{{ route('business.income-categories.index') }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
