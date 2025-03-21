<div class="modal fade" id="discount-modal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Add Vat') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="{{ route('business.expense-categories.store') }}" method="post"
                        enctype="multipart/form-data" class="ajaxform_instant_reload">
                        @csrf

                        <div class="row align-items-center">
                            <div class="col-lg-9">
                                <label>{{ __('Tax') }}</label>
                                <input type="text" name="categoryName" required class="form-control" placeholder="{{ __('Amount') }}">
                            </div>

                            <div class="col-lg-3">
                                <div class="pt-4 d-flex align-items-center gap-2">
                                    <button class='disc-btn'>%</button>
                                    <button class='disc-btn'>$</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-3">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Apply') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
