@extends('layouts.master')

@section('title')
    {{ __('Banner') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="bannersList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Advertising List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        @can('banners-create')
                        <a type="button" href="#create-banner-modal" data-bs-toggle="modal" class="btn btn-primary">
                            <i class="ri-add-circle-line me-1"></i> {{ __('Create Banner') }}
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('admin.banners.filter') }}" method="post" class="filter-form mb-3" table="#banner-data">
                    @csrf
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <select name="per_page" class="form-select">
                                <option value="10">{{ __('Show- 10') }}</option>
                                <option value="25">{{ __('Show- 25') }}</option>
                                <option value="50">{{ __('Show- 50') }}</option>
                                <option value="100">{{ __('Show- 100') }}</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="table-responsive table-card mb-1">
                    <table class="table table-nowrap align-middle" id="bannersTable">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                @can('banners-delete')
                                <th>
                                    <div class="form-check">
                                        <input class="form-check-input selectAllCheckbox" type="checkbox">
                                    </div>
                                </th>
                                @endcan
                                <th scope="col">{{ __('SL') }}</th>
                                <th scope="col">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody id="banner-data">
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
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush

{{-- Create Modal --}}
<div class="modal modal-md fade" id="create-banner-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create Advertising') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.banners.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    <div class="mb-3 position-relative">
                        <label class="form-label">{{ __('Image') }}</label>
                        <div class="upload-img-v2">
                            <label class="upload-v4 start-0">
                                <div class="img-wrp">
                                    <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="user" id="profile-img">
                                </div>
                                <input type="file" name="imageUrl" class="d-none" onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                            <span class="mb-0">{{ __('Active') }}</span>
                            <label class="switch m-0 top-0">
                                <input type="checkbox" name="status" class="change-text" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="reset" class="btn btn-secondary">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary submit-btn">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-md fade" id="edit-banner-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Advertising') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload edit-imageUrl-form mb-0">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label class="form-label">{{ __('Image') }}</label>
                        <div class="upload-img-v2">
                            <label class="upload-v4">
                                <div class="img-wrp">
                                    <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="user" id="edit-imageUrl">
                                </div>
                                <input type="file" name="imageUrl" class="d-none" onchange="document.getElementById('edit-imageUrl').src = window.URL.createObjectURL(this.files[0])" accept="image/*">
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                            <span>{{ __('Active') }}</span>
                            <label class="switch m-0 top-0">
                                <input type="checkbox" name="status" class="change-text edit-status" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="reset" class="btn btn-secondary">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary submit-btn">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
