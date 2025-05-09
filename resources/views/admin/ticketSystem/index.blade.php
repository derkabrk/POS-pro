@extends('admin::layouts.master')

@section('title', 'Tickets')

@section('main_content')
<div class="container">
    <h1>Tickets</h1>
    <a href="{{ route('admin.ticketSystem.create') }}" class="btn btn-primary">Create Ticket</a>
    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#ticketCategoriesModal">Manage Categories</button>

    <table class="table mt-3">
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
                <td>{{ $ticket->status }}</td>
                <td>{{ $ticket->priority }}</td>
                <td>
                    <a href="{{ route('admin.ticketSystem.edit', $ticket->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.ticketSystem.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tickets->links() }}
</div>

<!-- Modal for Ticket Categories -->
<div class="modal fade" id="ticketCategoriesModal" tabindex="-1" aria-labelledby="ticketCategoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketCategoriesModalLabel">Manage Ticket Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Table for Ticket Categories -->
                <table class="table">
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

                <!-- Form to Add New Category -->
                <form id="add-category-form">
                    <div class="mb-3">
                        <label for="category-name" class="form-label">Category Name</label>
                        <input type="text" id="category-name" class="form-control" placeholder="Enter category name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category-color" class="form-label">Category Color</label>
                        <input type="color" id="category-color" class="form-control" value="#000000">
                    </div>
                    <button type="submit" class="btn btn-success">Add Category</button>
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
                                <span style="display: inline-block; width: 20px; height: 20px; background-color: ${category.color}; border-radius: 50%;"></span>
                                ${category.color}
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