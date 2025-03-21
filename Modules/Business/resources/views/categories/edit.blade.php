<div class="modal fade" id="category-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Edit Category') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="" method="post" enctype="multipart/form-data"
                          class="ajaxform_instant_reload categoryEditForm">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="mt-3 col-lg-12">
                                <label class="custom-top-label">{{ __('Name') }}</label>
                                <input type="text" name="categoryName" id="category_name" required placeholder="{{ __('Enter Category Name') }}" class="form-control"/>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <label>{{ __("Icon") }}</label>
                                <div class="border rounded upload-img-container">
                                    <label class="upload-v4">
                                        <div class="img-wrp">
                                            <img src="" alt="user" id="category_icon">
                                        </div>
                                        <input type="file" name="icon" class="d-none" onchange="document.getElementById('category_icon').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h2 class='option-title'>{{ __('Select Variations') }}:</h2>
                                <div class="select-variations-container">
                                    <div class="select-variations-content">
                                        <input class="form-check-input variations-input" type="checkbox" name="variationCapacity" value="true" id="capacityCheck">
                                        <label class="form-check-label variations-label" for="capacityCheck">
                                            {{ __('Capacity') }}
                                        </label>
                                    </div>
                                    <div class="select-variations-content">
                                        <input class="form-check-input variations-input" type="checkbox" name="variationColor" value="true" id="colorCheck">
                                        <label class="form-check-label variations-label" for="colorCheck">
                                            {{ __('Color') }}
                                        </label>
                                    </div>
                                    <div class="select-variations-content">
                                        <input class="form-check-input variations-input" type="checkbox" name="variationSize" value="true" id="sizeCheck">
                                        <label class="form-check-label variations-label" for="sizeCheck">
                                            {{ __('Size') }}
                                        </label>
                                    </div>
                                    <div class="select-variations-content">
                                        <input class="form-check-input variations-input" type="checkbox"
                                               name="variationType" value="true" id="typeCheck">
                                        <label class="form-check-label variations-label" for="typeCheck">
                                            {{ __('Type') }}
                                        </label>
                                    </div>
                                    <div class="select-variations-content">
                                        <input class="form-check-input variations-input" type="checkbox"
                                               name="variationWeight" value="true" id="weightCheck">
                                        <label class="form-check-label variations-label" for="weightCheck">
                                            {{ __('Weight') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="offcanvas-footer mt-3">
                    <div class="button-group text-center mt-5">
                        <a href="{{ route('business.categories.index') }}"
                           class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                        <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
