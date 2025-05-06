@extends('admin::layouts.master')

@section('title', 'API Headers')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>API Headers</h4>
                    <a href="{{ route('admin.dynamicApiHeader.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New API Header
                    </a>
                </div>
                <div class="responsive-table m-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>API Key</th>
                                <th>Status</th>
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
                                <td colspan="5" class="text-center">No API Headers Found</td>
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
@endsection