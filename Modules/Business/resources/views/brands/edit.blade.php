
<div class="modal fade" id="brand-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Edit Brand') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="" method="post" enctype="multipart/form-data"
                        class="ajaxform_instant_reload brandUpdateForm">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label>{{ __('Brand Name') }}</label>
                                <input type="text" name="brandName" id="brand_view_name" required class="form-control" placeholder="{{ __('Enter Brand Name') }}">
                            </div>

                            <div class="col-lg-12 mb-2">
                                <label>{{ __("Icon") }}</label>
                                <div class="border rounded upload-img-container">
                                    <label class="upload-v4">
                                        <div class="img-wrp">
                                            <img src="" alt="user" id="edit_icon">
                                        </div>
                                        <input type="file" name="icon" class="d-none" onchange="document.getElementById('edit_icon').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 mb-2">
                                <label>{{__('Description')}}</label>
                                <textarea name="description" id="brand_view_description" class="form-control" placeholder="{{ __('Enter Description') }}"></textarea>
                            </div>
                         </div>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <a href="{{ route('business.brands.index') }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
