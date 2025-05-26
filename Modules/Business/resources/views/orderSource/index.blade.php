@extends('business::layouts.master')

@section('title', 'Order Sources')

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Order Sources List</h5>
                    </div>
                    <div class="col-sm-auto">
                        <a href="{{ route('business.orderSource.create') }}" class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-add-line me-1"></i> Add New Order Source
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card" style="margin-top:20px;">
                    <table class="table table-nowrap mb-0" id="orderSourceTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
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
                                    <a href="{{ route('business.orderSource.edit', $orderSource->id) }}" class="btn btn-sm btn-warning rounded-pill px-3 me-1">
                                        <i class="ri-edit-line"></i> Edit
                                    </a>
                                    <form action="{{ route('business.orderSource.destroy', $orderSource->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Are you sure you want to delete this order source?')">
                                            <i class="ri-delete-bin-line"></i> Delete
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