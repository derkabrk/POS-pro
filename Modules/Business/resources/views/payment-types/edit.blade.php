<div class="modal fade" id="payment-types-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h4 class="modal-title fw-bold mb-0">{{ __('Edit Payment Type') }}</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post" enctype="multipart/form-data"
                    class="ajaxform_instant_reload paymentTypeUpdateForm">
                    @csrf
                    @method('put')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('Name') }}</label>
                            <input type="text" name="name" id="PaymentTypeName" required class="form-control form-control-lg"
                                placeholder="{{ __('Enter Name') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('Status') }}</label>
                            <select name="status" id="PaymentTypeStatus" required class="form-select form-select-lg">
                                <option value="1">{{ __('Active') }}</option>
                                <option value="0">{{ __('Deactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('business.payment-types.index') }}"
                            class="btn btn-outline-secondary rounded-pill px-4">{{ __('Cancel') }}</a>
                        <button class="btn btn-primary rounded-pill px-4 submit-btn"><i
                                class="ri-save-3-line me-1"></i> {{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
