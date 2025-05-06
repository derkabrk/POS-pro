@extends('business::layouts.master')

@section('title', 'Create API Header')

@section('main_content')
<div class="container">
    <h1>Create API Header</h1>
    <form action="{{ route('business.dynamicApiHeader.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="api_key">API Key</label>
            <input type="text" name="api_key" id="api_key" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create API Header</button>
    </form>
</div>
@endsection