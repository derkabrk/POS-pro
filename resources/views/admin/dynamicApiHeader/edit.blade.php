@extends('admin::layouts.master')

@section('title', 'Edit API Header')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>Edit API Header</h4>
                    <a href="{{ route('admin.dynamicApiHeader.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-1"></i> View All API Headers
                    </a>
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('admin.dynamicApiHeader.update', $dynamicApiHeader->id) }}" method="POST" class="ajaxform_instant_reload" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $dynamicApiHeader->name }}" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="api_key" class="form-label">API Key</label>
                                <input type="text" name="api_key" id="api_key" class="form-control" value="{{ $dynamicApiHeader->api_key }}" required>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $dynamicApiHeader->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$dynamicApiHeader->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="4">{{ $dynamicApiHeader->description }}</textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success w-100" id="editButton">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <i class="fas fa-save me-1"></i> Update API Header
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle Create Form Submission
    const createForm = document.getElementById('createForm');
    const createButton = document.getElementById('createButton');
    if (createForm && createButton) {
        createForm.addEventListener('submit', function () {
            const spinner = createButton.querySelector('.spinner-border');
            spinner.classList.remove('d-none'); // Show spinner
            createButton.setAttribute('disabled', 'true'); // Disable button
        });
    }

    // Handle Edit Form Submission
    const editForm = document.getElementById('editForm');
    const editButton = document.getElementById('editButton');
    if (editForm && editButton) {
        editForm.addEventListener('submit', function () {
            const spinner = editButton.querySelector('.spinner-border');
            spinner.classList.remove('d-none'); // Show spinner
            editButton.setAttribute('disabled', 'true'); // Disable button
        });
    }
});
</script>
@endpush