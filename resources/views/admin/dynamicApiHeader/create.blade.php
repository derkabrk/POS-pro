@extends('layouts.master')

@section('title', 'Edit API Header')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('API Headers') }}
        @endslot
        @slot('title')
            {{ __('Edit API Header') }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit API Header')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.dynamicApiHeader.index') }}" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i> {{ __('View All API Headers') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dynamicApiHeader.update', $dynamicApiHeader->id) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="row gy-4">
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $dynamicApiHeader->name }}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="api_key" class="form-label">{{ __('API Key') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="api_key" id="api_key" class="form-control" value="{{ $dynamicApiHeader->api_key }}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $dynamicApiHeader->status ? 'selected' : '' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ !$dynamicApiHeader->status ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div>
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" class="form-control" rows="4">{{ $dynamicApiHeader->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-center mt-4">
                                    <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary" id="editButton">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editForm = document.getElementById('editForm');
    const editButton = document.getElementById('editButton');

    if (editForm && editButton) {
        editForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            const spinner = editButton.querySelector('.spinner-border');
            spinner.classList.remove('d-none'); // Show spinner
            editButton.setAttribute('disabled', 'true'); // Disable button

            // Submit the form via AJAX
            const formData = new FormData(editForm);

            fetch(editForm.action, {
                method: 'POST',
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
                    editButton.removeAttribute('disabled');
                    spinner.classList.add('d-none');
                });
        });
    }
});
</script>
@endpush