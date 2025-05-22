<div class="modal fade" id="brand-edit-modal" tabindex="-1" aria-labelledby="brandEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="brandEditModalLabel">{{ __('Edit Brand') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload brandUpdateForm">
                    @csrf
                    @method('put')
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="brand_view_name" class="form-label">{{ __('Brand Name') }}</label>
                            <input type="text" name="brandName" id="brand_view_name" required class="form-control" placeholder="{{ __('Enter Brand Name') }}">
                        </div>
                        <div class="col-12">
                            <label for="edit_icon" class="form-label">{{ __('Icon') }}</label>
                            <div class="border rounded upload-img-container p-2">
                                <label class="upload-v4 w-100">
                                    <div class="img-wrp mb-2">
                                        <img src="" alt="user" id="edit_icon" class="img-thumbnail" style="max-height: 60px;">
                                    </div>
                                    <input type="file" name="icon" class="d-none" onchange="document.getElementById('edit_icon').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="brand_view_description" class="form-label">{{__('Description')}}</label>
                            <textarea name="description" id="brand_view_description" class="form-control" placeholder="{{ __('Enter Description') }}"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4 gap-2">
                        <a href="{{ route('business.brands.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary submit-btn">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
