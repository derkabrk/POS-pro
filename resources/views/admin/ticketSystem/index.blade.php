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
    .table thead th {
        background: #343a40;
        color: #fff;
        vertical-align: middle;
    }
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f2f2f2;
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6 !important;
    }
</style>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Tickets</h1>
        <div>
            <a href="{{ route('admin.ticketSystem.create') }}" class="btn btn-primary me-2">Create Ticket</a>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ticketCategoriesModal">
                Manage Categories
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow-sm">
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
                        <a href="{{ route('admin.ticketSystem.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.ticketSystem.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this ticket?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $tickets->links() }}
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
                <div class="table-responsive mb-4">
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
                <form id="add-category-form" class="row g-3" method="POST" action="{{ route('admin.ticket_categories.store') }}">
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
                        <button type="submit" class="btn btn-success w-100">Add Category</button>
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
@endsection