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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addApiHeaderModal">
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
                                        <a href="{{ route('admin.dynamicApiHeader.edit', $header->id) }}" class="btn btn-sm btn-warning">
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
<div class="modal fade" id="addApiHeaderModal" tabindex="-1" aria-labelledby="addApiHeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addApiHeaderModalLabel">Add New API Header</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.dynamicApiHeader.store') }}" method="POST" id="createForm">
                    @csrf
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
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                                <button type="submit" class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection