@extends('layouts.master')

@section('title', 'API Headers')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>API Headers</h4>
                    <!-- Trigger the modal -->  
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#apiHeaderModal">
                        <i class="fas fa-plus-circle me-1"></i> Add New API Header
                    </button>
                </div>
                <div class="responsive-table m-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>API Key</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($apiHeaders as $key => $header)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $header->name }}</td>
                                    <td>{{ $header->api_key }}</td>
                                    <td>
                                        <span class="badge {{ $header->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $header->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $header->description }}</td>
                                    <td>
                                        <a href="javascript:void(0)" 
                                           class="btn btn-sm btn-warning" 
                                           data-id="{{ $header->id }}" 
                                           data-name="{{ $header->name }}" 
                                           data-api-key="{{ $header->api_key }}" 
                                           data-status="{{ $header->status }}" 
                                           data-description="{{ $header->description }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.dynamicApiHeader.destroy', $header->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this API Header?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No API Headers Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $apiHeaders->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add API Header Modal -->
<div class="modal fade" id="apiHeaderModal" tabindex="-1" aria-labelledby="apiHeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apiHeaderModalLabel">Add New API Header</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.dynamicApiHeader.store') }}" method="POST" id="apiHeaderForm">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter API Header Name" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="api_key" class="form-label">API Key</label>
                            <input type="text" name="api_key" id="api_key" class="form-control" placeholder="Enter API Key" required>
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
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="theme-btn m-2 submit-btn" id="submitButton">
                                    <span id="buttonText">{{ __('Save') }}</span>
                                    <span class="spinner-border spinner-border-sm d-none" id="buttonLoader" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const apiHeaderModal = new bootstrap.Modal(document.getElementById('apiHeaderModal'));
    const apiHeaderForm = document.getElementById('apiHeaderForm');
    const formMethod = document.getElementById('formMethod');
    const submitButton = document.getElementById('submitButton');
    const buttonLoader = document.getElementById('buttonLoader');
    const buttonText = document.getElementById('buttonText');

    // Handle Create Button Click
    document.querySelector('.btn-primary[data-bs-target="#apiHeaderModal"]').addEventListener('click', function () {
        apiHeaderForm.action = "{{ route('admin.dynamicApiHeader.store') }}";
        formMethod.value = "POST";
        document.getElementById('apiHeaderModalLabel').textContent = "Add New API Header";
        buttonText.textContent = "Save";

        // Clear form fields
        apiHeaderForm.reset();
    });

    // Handle Edit Button Click
    document.querySelectorAll('.btn-warning').forEach(function (editButton) {
        editButton.addEventListener('click', function () {
            const apiHeaderId = this.dataset.id;
            const apiHeaderName = this.dataset.name;
            const apiHeaderKey = this.dataset.apiKey;
            const apiHeaderStatus = this.dataset.status;
            const apiHeaderDescription = this.dataset.description;

            apiHeaderForm.action = `/admin/dynamicApiHeader/${apiHeaderId}`;
            formMethod.value = "PUT";
            document.getElementById('apiHeaderModalLabel').textContent = "Edit API Header";
            buttonText.textContent = "Update";

            // Populate form fields
            document.getElementById('name').value = apiHeaderName;
            document.getElementById('api_key').value = apiHeaderKey;
            document.getElementById('status').value = apiHeaderStatus;
            document.getElementById('description').value = apiHeaderDescription;

            // Show the modal
            apiHeaderModal.show();
        });
    });

    // Handle Form Submission
    apiHeaderForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        // Show loader and disable button
        submitButton.disabled = true;
        buttonLoader.classList.remove('d-none');
        buttonText.textContent = 'Processing...';

        // Submit the form via AJAX
        const formData = new FormData(apiHeaderForm);

        fetch(apiHeaderForm.action, {
            method: formMethod.value,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.redirect) {
                    window.location.href = data.redirect; // Redirect the user
                } else {
                    alert(data.message || 'An error occurred.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                // Re-enable the button and reset the loader
                submitButton.disabled = false;
                buttonLoader.classList.add('d-none');
                buttonText.textContent = formMethod.value === "POST" ? "Save" : "Update";
            });
    });
});
</script>
@endsection