@extends('layouts.master')

@section('title', 'Create API Header')

@section('main_content')
<div class="container">
    <h1>Create API Header</h1>
    <form action="{{ route('admin.dynamicApiHeader.store') }}" method="POST" id="createForm">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter API Header Name" required>
        </div>
        <div class="form-group mb-3">
            <label for="api_key">API Key</label>
            <input type="text" name="api_key" id="api_key" class="form-control" placeholder="Enter API Key" required>
        </div>
        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter Description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="submitButton">
            <span id="buttonText">Save</span>
            <span class="spinner-border spinner-border-sm d-none" id="buttonLoader" role="status" aria-hidden="true"></span>
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('createForm');
        const submitButton = document.getElementById('submitButton');
        const buttonLoader = document.getElementById('buttonLoader');
        const buttonText = document.getElementById('buttonText');

        if (form) {
            form.addEventListener('submit', function (event) {
                // Disable the button and show the loader
                submitButton.disabled = true;
                buttonLoader.classList.remove('d-none');
                buttonText.textContent = 'Processing...';
            });
        }
    });
</script>
@endsection