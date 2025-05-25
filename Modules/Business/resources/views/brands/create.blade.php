<div class="modal fade" id="brand-create-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="brandCreateModalLabel">{{ __('Create Brand') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.brands.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="brandName" class="form-label">{{ __('Brand Name') }}</label>
                            <input type="text" name="brandName" id="brandName" required class="form-control" placeholder="{{ __('Enter Brand Name') }}">
                        </div>
                        <div class="col-12">
                            <label for="brandIcon" class="form-label">{{ __('Icon') }}</label>
                            <div class="border rounded upload-img-container p-2">
                                <label class="upload-v4 w-100">
                                    <div class="img-wrp mb-2">
                                        <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="Brand" id="brand-img" class="img-thumbnail" style="max-height: 60px;">
                                    </div>
                                    <input type="file" name="icon" id="brandIcon" class="d-none" onchange="document.getElementById('brand-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="brandDescription" class="form-label">{{__('Description')}}</label>
                            <textarea name="description" id="brandDescription" class="form-control" placeholder="{{ __('Enter Description') }}"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4 gap-2">
                        <button
                        <button type="submit" class="btn btn-primary submit-btn">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
