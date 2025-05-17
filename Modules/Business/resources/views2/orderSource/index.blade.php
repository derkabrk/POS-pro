@extends('business::layouts.master')

@section('title', 'Order Sources')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>Order Sources List</h4>
                    <a href="{{ route('business.orderSource.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add New Order Source
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
                            @forelse ($orderSources as $key => $orderSource)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $orderSource->name }}</td>
                                <td>{{ $orderSource->api_key }}</td>
                                <td>
                                    <span class="badge {{ $orderSource->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $orderSource->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('business.orderSource.edit', $orderSource->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('business.orderSource.destroy', $orderSource->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order source?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Order Sources Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $orderSources->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection