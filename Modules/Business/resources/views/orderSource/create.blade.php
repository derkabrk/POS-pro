@extends('business::layouts.master')

@section('title')
    Order Sources
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Add New Order Source</h4>
                 
                    <a href="{{ route('business.orderSource.index') }}" class="add-order-btn rounded-2 {{ Route::is('business.orderSource.create') ? 'active' : '' }}">
                        <i class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}
                    </a>
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('business.orderSource.store') }}" enctype="multipart/form-data" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>Platform Name</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Enter Platform Name">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>API Key</label>
                                    <input type="text" name="api_key" required class="form-control" placeholder="Enter API Key">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>API Secret</label>
                                    <input type="text" name="api_secret" required class="form-control" placeholder="Enter API Secret">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>Webhook URL</label>
                                    <input type="url" name="webhook_url" class="form-control" placeholder="Enter Webhook URL">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label>Settings (JSON)</label>
                                    <textarea name="settings" class="form-control" placeholder="Enter additional settings in JSON format"></textarea>
                                </div>

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                                        <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection