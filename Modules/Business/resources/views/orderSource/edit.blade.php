@extends('business::layouts.master')

@section('title', 'Edit Order Source')

@section('main_content')
<div class="container">
    <h1>Edit Order Source</h1>
    <form action="{{ route('business.orderSource.update', $orderSource->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Platform Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $orderSource->name }}" required>
        </div>
        <div class="form-group">
            <label for="api_key">API Key</label>
            <input type="text" name="api_key" id="api_key" class="form-control" value="{{ $orderSource->api_key }}" required>
        </div>
        <div class="form-group">
            <label for="api_secret">API Secret</label>
            <input type="text" name="api_secret" id="api_secret" class="form-control" value="{{ $orderSource->api_secret }}" required>
        </div>
        <div class="form-group">
            <label for="webhook_url">Webhook URL</label>
            <input type="url" name="webhook_url" id="webhook_url" class="form-control" value="{{ $orderSource->webhook_url }}">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ $orderSource->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$orderSource->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection