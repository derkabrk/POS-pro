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
                    <form action="{{ route('admin.dynamicApiHeader.store') }}" method="POST" class="ajaxform_instant_reload" id="createForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required placeholder="Enter API Header Name">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="api_key" class="form-label">API Key</label>
                                <input type="text" name="api_key" id="api_key" class="form-control" required placeholder="Enter API Key">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success w-100" id="submitButton">
                                    <span class="spinner-border spinner-border-sm d-none" id="buttonLoader" role="status" aria-hidden="true"></span>
                                    <span id="buttonText">Save API Header</span>
                                </button>
                            </div>
                        </div>
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
            form.addEventListener('submit', function () {
                // Disable the button to prevent multiple submissions
                submitButton.disabled = true;

                // Show the loader and hide the button text
                buttonLoader.classList.remove('d-none');
                buttonText.textContent = 'Processing...';
            });
        }
    });
</script>
@endsection