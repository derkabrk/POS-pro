@extends('layouts.master')

@section('title')
    {{ __('Addons List') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="addonsList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Addons List') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <a type="button" href="#addon-modal" data-bs-toggle="modal" class="btn btn-primary">
                            <i class="ri-add-circle-line me-1"></i> {{ __('Install / Update Addon') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card mb-1">
                    <table class="table table-nowrap align-middle" id="addonsTable">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th scope="col">{{ __('SL') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Version') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody id="addon-data" class="searchResults">
                            @include('admin.addons.search')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Create Modal --}}
<div class="modal modal-md fade" id="addon-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Install / Update Addon') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.addons.store') }}" method="post" enctype="multipart/form-data" class="ajaxform_instant_reload">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('Enter purchase code') }}</label>
                        <input type="text" name="purchase_code" class="form-control" placeholder="{{ __('Enter addon purchase code') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Upload addons zip file') }}</label>
                        <input type="file" name="file" class="form-control" accept="file/*" required>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="reset" class="btn btn-secondary">{{ __('Cancel') }}</button>
                        <button class="btn btn-primary submit-btn">{{ __('Install') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
