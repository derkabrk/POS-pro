@extends('layouts.master')

@section('title') {{ __('Banner List') }} @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Banner @endslot
@slot('title') {{ __('Banner List') }} @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="bannerList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Banner List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            @can('banners-create')
                                <a type="button" href="#create-banner-modal" data-bs-toggle="modal" class="btn btn-primary add-btn {{ Route::is('admin.banners.create') ? 'active' : '' }}">
                                    <i class="ri-add-line align-bottom me-1"></i> {{ __('Create Banner') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card mb-1">
                    <table class="table table-nowrap align-middle" id="bannerTable">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                @can('banners-delete')
                                <th scope="col" style="width: 25px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                @endcan
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all" id="banner-data">
                            @include('admin.banners.search')
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $banners->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush

<!-- Create Modal -->
<div class="modal modal-md fade" id="create-banner-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create Banner') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.banners.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-xxl-6 col-md-6">
                            <div>
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                    <p class="dynamic-text mb-0">{{ __('Active') }}</p>
                                    <label class="switch m-0">
                                        <input type="checkbox" name="status" class="change-text" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <div>
                                <label for="imageUrl" class="form-label">{{ __('Image') }}</label>
                                <input type="file" accept="image/*" name="imageUrl" id="imageUrl" class="form-control">
                                <div class="mt-2">
                                    <img id="preview-image" src="{{ asset('assets/images/icons/upload.png') }}" alt="Preview" class="img-thumbnail" style="max-width: 100px; display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center mt-4">
                                <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal (structure only, you can add dynamic data as needed) -->
<div class="modal modal-md fade" id="edit-banner-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Banner') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row gy-4">
                        <div class="col-xxl-6 col-md-6">
                            <div>
                                <label for="edit-status" class="form-label">{{ __('Status') }}</label>
                                <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                                    <p class="dynamic-text mb-0">{{ __('Active') }}</p>
                                    <label class="switch m-0">
                                        <input type="checkbox" name="status" class="change-text edit-status" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <div>
                                <label for="edit-imageUrl" class="form-label">{{ __('Image') }}</label>
                                <input type="file" accept="image/*" name="imageUrl" id="edit-imageUrl" class="form-control">
                                <div class="mt-2">
                                    <img id="edit-preview-image" src="{{ asset('assets/images/icons/upload.png') }}" alt="Preview" class="img-thumbnail" style="max-width: 100px; display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="text-center mt-4">
                                <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview for create
        const imageInput = document.getElementById('imageUrl');
        const previewImage = document.getElementById('preview-image');
        if(imageInput) {
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        // Image preview for edit
        const editImageInput = document.getElementById('edit-imageUrl');
        const editPreviewImage = document.getElementById('edit-preview-image');
        if(editImageInput) {
            editImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        editPreviewImage.src = e.target.result;
                        editPreviewImage.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>
@endsection
