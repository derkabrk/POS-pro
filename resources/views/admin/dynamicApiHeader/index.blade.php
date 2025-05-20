@extends('layouts.master')

@section('title', 'API Headers')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            {{ __('API Headers') }}
        @endslot
        @slot('title')
            {{ __('API Headers List') }}
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('API Headers List') }}</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#apiHeaderModal">
                            <i class="fas fa-plus-circle me-1"></i> {{ __('Add New API Header') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mb-1">
                        <table class="table table-sm table-hover table-striped table-bordered align-middle">
                            <thead class="text-muted table-light align-middle">
                                <tr class="text-uppercase align-middle">
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('API Key') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($apiHeaders as $key => $header)
                                    <tr class="align-middle">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $header->name }}</td>
                                        <td>{{ $header->api_key }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $header->status ? 'success' : 'danger' }} px-2 py-1">
                                                {{ $header->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $header->description }}</td>
                                        <td>
                                            <a href="{{ route('admin.dynamicApiHeader.edit', $header->id) }}" class="btn btn-sm btn-icon btn-light me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.dynamicApiHeader.destroy', $header->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-light confirm-action" onclick="return confirm('Are you sure you want to delete this API Header?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('No API Headers Found') }}</td>
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
                    <h5 class="modal-title" id="apiHeaderModalLabel">{{ __('Add New API Header') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.dynamicApiHeader.store') }}" method="POST" id="apiHeaderForm">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">
                        <div class="row gy-4">
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter API Header Name" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="api_key" class="form-label">API Key <span class="text-danger">*</span></label>
                                    <input type="text" name="api_key" id="api_key" class="form-control" placeholder="Enter API Key" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div>
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="text-center mt-4">
                                    <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection