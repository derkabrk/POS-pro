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
                        <tbody id="categories-table">
                            <!-- Categories will be dynamically added here -->
                        </tbody>
                    </table>
                </div>

                <!-- Form to Add New Category -->
                <form id="add-category-form" class="row g-3">
                    <div class="col-md-6">
                        <label for="category-name" class="form-label">Category Name</label>
                        <input type="text" id="category-name" class="form-control" placeholder="Enter category name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="category-color" class="form-label">Category Color</label>
                        <input type="color" id="category-color" class="form-control form-control-color" value="#000000" title="Choose your color">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Fetch and display ticket categories
    function fetchCategories() {
        axios.get('/admin/ticketCategories')
            .then(response => {
                const categories = response.data;
                const categoriesTable = $('#categories-table');
                categoriesTable.empty();
                categories.forEach((category, index) => {
                    categoriesTable.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${category.name}</td>
                            <td>
                                <span class="color-swatch" style="background-color: ${category.color};"></span>
                                <span>${category.color}</span>
                            </td>
                        </tr>
                    `);
                });
            })
            .catch(error => console.error(error));
    }

    // Add a new ticket category
    $('#add-category-form').on('submit', function (e) {
        e.preventDefault();
        const categoryName = $('#category-name').val();
        const categoryColor = $('#category-color').val();

        axios.post('/admin/ticketCategories', { name: categoryName, color: categoryColor })
            .then(response => {
                alert(response.data.message);
                $('#category-name').val(''); // Clear the input field
                $('#category-color').val('#000000'); // Reset the color picker
                fetchCategories(); // Refresh the categories table
            })
            .catch(error => {
                console.error(error);
                alert('Failed to add category. Make sure the name is unique.');
            });
    });

    // Initial fetch
    fetchCategories();
</script>
@endsection