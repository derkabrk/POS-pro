@extends('layouts.master')

@section('title', 'Create API Header')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>Create API Header</h4>
                    <a href="{{ route('admin.dynamicApiHeader.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-1"></i> View All API Headers
                    </a>
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('admin.dynamicApiHeader.store') }}" method="POST" id="createForm">
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
                        <button type="submit" class="btn btn-primary" id="submitButton">
                            <span id="buttonText">Save</span>
                            <span class="spinner-border spinner-border-sm d-none" id="buttonLoader" role="status" aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('createForm');
        const submitButton = document.getElementById('submitButton');
        const buttonLoader = document.getElementById('buttonLoader');
        const buttonText = document.getElementById('buttonText');

        if (form) {
            form.addEventListener('submit', function (event) {
               
                submitButton.disabled = true;

               
                buttonLoader.classList.remove('d-none');
                buttonText.textContent = 'Processing...';
            });
        }
    });
</script>
@endsection