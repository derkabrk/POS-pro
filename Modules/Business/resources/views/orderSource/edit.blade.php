@extends('business::layouts.master')

@section('title', __('Edit Order Source'))

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('Edit Order Source') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <a href="{{ route('business.orderSource.index') }}" class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-list-unordered me-1"></i> {{ __('View All Order Sources') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('business.orderSource.update', $orderSource->id) }}" method="POST" class="ajaxform_instant_reload">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label for="name" class="form-label">{{ __('Platform Name') }}</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $orderSource->name }}" required placeholder="{{ __('Enter Platform Name') }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="api_key" class="form-label">{{ __('API Key') }}</label>
                            <input type="text" name="api_key" id="api_key" class="form-control" value="{{ $orderSource->api_key }}" required placeholder="{{ __('Enter API Key') }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="api_secret" class="form-label">{{ __('API Secret') }}</label>
                            <input type="text" name="api_secret" id="api_secret" class="form-control" value="{{ $orderSource->api_secret }}" required placeholder="{{ __('Enter API Secret') }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="webhook_url" class="form-label">{{ __('Webhook URL') }}</label>
                            <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="{{ $orderSource->webhook_url }}" placeholder="{{ __('Enter Webhook URL') }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ $orderSource->status ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="0" {{ !$orderSource->status ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="settings" class="form-label">{{ __('Settings (JSON)') }}</label>
                            <textarea name="settings" id="settings" class="form-control" rows="4" placeholder="{{ __('Enter additional settings in JSON format') }}">{{ $orderSource->settings }}</textarea>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4">{{ __('Update Order Source') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection