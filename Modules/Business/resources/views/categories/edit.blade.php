<div class="modal fade" id="category-edit-modal" tabindex="-1" aria-labelledby="categoryEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryEditModalLabel">{{ __('Edit Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload categoryEditForm">
                    @csrf
                    @method('put')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="category_name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" name="categoryName" id="category_name" required placeholder="{{ __('Enter Category Name') }}" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="category_icon" class="form-label">{{ __('Icon') }}</label>
                            <div class="input-group">
                                <label class="input-group-text" for="category_icon">
                                    <img src="" alt="user" id="category_icon" class="img-thumbnail">
                                </label>
                                <input type="file" name="icon" class="form-control" id="category_icon_input" onchange="document.getElementById('category_icon').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6 class="fw-bold">{{ __('Select Variations') }}:</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="variationCapacity" value="true" id="capacityCheck">
                                <label class="form-check-label" for="capacityCheck">
                                    {{ __('Capacity') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="variationColor" value="true" id="colorCheck">
                                <label class="form-check-label" for="colorCheck">
                                    {{ __('Color') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="variationSize" value="true" id="sizeCheck">
                                <label class="form-check-label" for="sizeCheck">
                                    {{ __('Size') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="variationType" value="true" id="typeCheck">
                                <label class="form-check-label" for="typeCheck">
                                    {{ __('Type') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="variationWeight" value="true" id="weightCheck">
                                <label class="form-check-label" for="weightCheck">
                                    {{ __('Weight') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('business.categories.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
