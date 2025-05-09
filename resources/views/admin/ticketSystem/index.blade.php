@extends('layouts.master')

@section('title', 'Tickets')

@section('main_content')
<style>
    .color-swatch {
        display: inline-block;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #ddd;
        margin-right: 8px;
        vertical-align: middle;
    }
    .modal-body {
        background: #f8f9fa;
    }
    .table-header {
        padding: 16px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .add-order-btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 6px 18px;
        margin-left: 8px;
    }
    .erp-table-section {
        margin-top: 24px;
    }
    .modal-content {
        border-radius: 12px;
    }
    .modal-header {
        border-bottom: 1px solid #e9ecef;
    }
    .modal-title {
        font-weight: 600;
    }
</style>

<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys">
                <div class="table-header">
                    <h4>Tickets List</h4>
                    <div>
                        <button type="button" class="add-order-btn btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ticketCategoriesModal">
                            <i class="fas fa-layer-group me-1"></i> Manage Categories
                        </button>
                    </div>
                </div>
                <div class="responsive-table m-0">
                    <table class="table table-bordered table-striped align-middle shadow-sm" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    <span class="badge bg-{{ $ticket->status === 'Open' ? 'success' : ($ticket->status === 'Closed' ? 'secondary' : 'warning') }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $ticket->priority === 'High' ? 'danger' : ($ticket->priority === 'Medium' ? 'warning' : 'info') }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>
                                <td>
                                    @if($ticket->category)
                                        <span class="color-swatch" style="background-color: {{ $ticket->category->color }}"></span>
                                        {{ $ticket->category->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.ticketSystem.edit', $ticket->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('admin.ticketSystem.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this ticket?')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $tickets->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Ticket Categories -->
<div class="modal fade" id="ticketCategoriesModal" tabindex="-1" aria-labelledby="ticketCategoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ticketCategoriesModalLabel">Manage Ticket Categories</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Table for Ticket Categories -->
                <div class="responsive-table mb-4">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <span class="color-swatch" style="background-color: {{ $category->color }}"></span>
                                        <span>{{ $category->color }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Form to Add New Category -->
                <form class="row g-3" method="POST" action="{{ route('admin.ticketCategories.store') }}">
                    @csrf
                    <div class="col-md-6">
                        <label for="category-name" class="form-label">Category Name</label>
                        <input type="text" name="name" id="category-name" class="form-control" placeholder="Enter category name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="category-color" class="form-label">Category Color</label>
                        <input type="color" name="color" id="category-color" class="form-control form-control-color" value="#000000" title="Choose your color">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus-circle me-1"></i> Add Category</button>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for Ticket Statuses -->
<div class="modal fade" id="ticketStatusesModal" tabindex="-1" aria-labelledby="ticketStatusesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ticketStatusesModalLabel">Manage Ticket Statuses</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Table for Ticket Statuses -->
                <div class="responsive-table mb-4">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statuses as $index => $status)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $status->name }}</td>
                                    <td>
                                        <span class="color-swatch" style="background-color: {{ $status->color }}"></span>
                                        <span>{{ $status->color }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Form to Add New Status -->
                <form class="row g-3" method="POST" action="{{ route('admin.ticketStatus.store') }}">
                    @csrf
                    <div class="col-md-6">
                        <label for="status-name" class="form-label">Status Name</label>
                        <input type="text" name="name" id="status-name" class="form-control" placeholder="Enter status name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="status-color" class="form-label">Status Color</label>
                        <input type="color" name="color" id="status-color" class="form-control form-control-color" value="#000000" title="Choose your color">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus-circle me-1"></i> Add Status</button>
                    </div>
                </form>
                @if ($errors->any() && session('form') === 'status')
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success_status'))
                    <div class="alert alert-success mt-3">
                        {{ session('success_status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection