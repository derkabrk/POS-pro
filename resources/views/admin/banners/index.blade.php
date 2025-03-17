@extends('layouts.master')

@section('title')
    {{ __('Banner') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card">
                <div class="card-bodys">
                    <div class="table-header p-16">
                        <h4>{{ __('Advertising List') }}</h4>
                        @can('banners-create')
                            <a type="button" href="#create-banner-modal" data-bs-toggle="modal"
                                class="add-order-btn rounded-2 active" class="btn btn-primary"><i
                                    class="fas fa-plus-circle me-1"></i> {{ __('Create Banner') }}</a>
                        @endcan
                    </div>

                    <div class="table-top-form p-16-0">
                        <form action="{{ route('admin.banners.filter') }}" method="post" class="filter-form mb-0" table="#banner-data">
                            @csrf

                            <div class="table-top-left d-flex gap-3 margin-l-16">
                                <div class="gpt-up-down-arrow position-relative">
                                    <select name="per_page" class="form-control">
                                        <option value="1">{{ __('Show- 10') }}</option>
                                        <option value="2">{{ __('Show- 25') }}</option>
                                        <option value="3">{{ __('Show- 50') }}</option>
                                        <option value="100">{{ __('Show- 100') }}</option>
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="responsive-table m-0">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                @can('banners-delete')
                                    <th>
                                        <div class="d-flex align-items-center gap-1">

                                            <label class="table-custom-checkbox">
                                                <input type="checkbox" class="table-hidden-checkbox selectAllCheckbox">
                                                <span class="table-custom-checkmark custom-checkmark"></span>
                                            </label>
                                            <i class="fal fa-trash-alt delete-selected"></i>
                                        </div>
                                    </th>
                                @endcan


                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
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
@endsection

@push('modal')
    @include('admin.components.multi-delete-modal')
@endpush

{{-- Create Modal --}}
<div class="modal modal-md fade" id="create-banner-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create Advertising') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.banners.store') }}" method="post" enctype="multipart/form-data"
                    class="ajaxform_instant_reload ">
                    @csrf

                    <div class="mt-3 position-relative">
                        <label class="upload-img-label">{{ __('Image') }}</label>
                        <div class="upload-img-v2">
                            <label class="upload-v4 start-0">
                                <div class="img-wrp">
                                    <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="user"
                                        id="profile-img">
                                </div>
                                <input type="file" name="imageUrl" class="d-none"
                                    onchange="document.getElementById('profile-img').src = window.URL.createObjectURL(this.files[0])"
                                    accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>{{ __('Status') }}</label>
                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                            <p class="dynamic-text mb-0">{{ __('Active') }}</p>
                            <label class="switch m-0 top-0">
                                <input type="checkbox" name="status" class="change-text" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="button-group text-center mt-5">
                            <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                            <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-md fade" id="edit-banner-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Advertising') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data"
                    class="ajaxform_instant_reload edit-imageUrl-form mb-0">
                    @csrf
                    @method('put')
                    <div class="mt-3">
                        <label></label>
                        <div class="upload-img-v2">
                            <label class="upload-v4">
                                <div class="img-wrp">
                                    <img src="{{ asset('assets/images/icons/upload-icon.svg') }}" alt="user"
                                        id="edit-imageUrl">
                                </div>
                                <input type="file" name="imageUrl" class="d-none"
                                    onchange="document.getElementById('edit-imageUrl').src = window.URL.createObjectURL(this.files[0])"
                                    accept="image/*">
                            </label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>{{ __('Status') }}</label>
                        <div class="form-control d-flex justify-content-between align-items-center radio-switcher">
                            <p class="dynamic-text">{{ __('Active') }}</p>
                            <label class="switch m-0 top-0">
                                <input type="checkbox" name="status" class="change-text edit-status" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="button-group text-center mt-5">
                            <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                            <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
