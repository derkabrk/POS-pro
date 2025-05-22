@extends('business::layouts.master')

@section('title', 'Edit Order Source')

@section('content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Edit Order Source</h4>
                    <a href="{{ route('business.orderSource.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-1"></i> View All Order Sources
                    </a>
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('business.orderSource.update', $orderSource->id) }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name" class="form-label">Platform Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $orderSource->name }}" required placeholder="Enter Platform Name">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="api_key" class="form-label">API Key</label>
                                <input type="text" name="api_key" id="api_key" class="form-control" value="{{ $orderSource->api_key }}" required placeholder="Enter API Key">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="api_secret" class="form-label">API Secret</label>
                                <input type="text" name="api_secret" id="api_secret" class="form-control" value="{{ $orderSource->api_secret }}" required placeholder="Enter API Secret">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="webhook_url" class="form-label">Webhook URL</label>
                                <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="{{ $orderSource->webhook_url }}" placeholder="Enter Webhook URL">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $orderSource->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$orderSource->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="settings" class="form-label">Settings (JSON)</label>
                                <textarea name="settings" id="settings" class="form-control" rows="4" placeholder="Enter additional settings in JSON format">{{ $orderSource->settings }}</textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success w-100">Update Order Source</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection