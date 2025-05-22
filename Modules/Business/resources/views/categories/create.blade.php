<div class="modal fade" id="category-create-modal" tabindex="-1" aria-labelledby="categoryCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryCreateModalLabel">{{ __('Add New Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.categories.store') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="{{ __('Enter Category Name') }}" required>
                        <div class="invalid-feedback">
                            {{ __('Please provide a category name.') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="icon" class="form-label">{{ __('Icon') }}</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="icon" name="icon" accept="image/*" onchange="document.getElementById('brand-img').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="mt-2">
                            <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="Brand" id="brand-img" class="img-thumbnail" style="max-width: 100px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6 class="form-label">{{ __('Select Variations') }}</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="variationCapacity" name="variationCapacity" value="true">
                            <label class="form-check-label" for="variationCapacity">{{ __('Capacity') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="variationColor" name="variationColor" value="true">
                            <label class="form-check-label" for="variationColor">{{ __('Color') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="variationSize" name="variationSize" value="true">
                            <label class="form-check-label" for="variationSize">{{ __('Size') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="variationType" name="variationType" value="true">
                            <label class="form-check-label" for="variationType">{{ __('Type') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="variationWeight" name="variationWeight" value="true">
                            <label class="form-check-label" for="variationWeight">{{ __('Weight') }}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
