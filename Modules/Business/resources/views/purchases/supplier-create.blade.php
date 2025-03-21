<div class="modal fade" id="supplier-create-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Create Supplier') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="{{ route('business.purchases.store.supplier') }}" method="post" enctype="multipart/form-data"
                        class="ajaxform_instant_reload">
                        @csrf

                        <div class="row">

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name" required class="form-control" placeholder="{{ __('Enter Name') }}">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Phone') }}</label>
                                <input type="number" name="phone" required class="form-control" placeholder="{{ __('Enter phone number') }}">
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control" placeholder="{{ __('Enter Email') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Address') }}</label>
                                <input type="text" name="address" class="form-control" placeholder="{{ __('Enter Address') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Due') }}</label>
                                <input type="number" name="due" step="any" class="form-control" placeholder="{{ __('Enter Due') }}">
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-10">
                                        <label class="img-label">{{ __('Image') }}</label>
                                        <input type="file" accept="image/*" name="image" class="form-control file-input-change" data-id="image">
                                    </div>
                                    <div class="col-1 align-self-center mt-3">
                                        <img src="{{ asset('assets/images/icons/upload.png') }}" id="image" class="table-img">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="type" value="Supplier">
                         </div>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
