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
        max-height: 500px; /* Adjust the height as needed */
        overflow-y: auto; /* Enable vertical scrolling if content exceeds max height */
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
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    .modal-header {
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
        border-radius: 16px 16px 0 0;
    }
    .modal-title {
        font-weight: 600;
        font-size: 18px;
    }
    /* General Styling */
    .table {
        border-radius: 12px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
        border-color: #e9ecef;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
    }

    .table td {
        padding: 12px;
        font-size: 14px;
        color: #555;
    }

    /* Dropdown Styling */
    .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 6px 12px;
        font-size: 14px;
        color: #333;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-select:focus {
        border-color: #80bdff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Badge Styling */
    .badge {
        border-radius: 12px;
        font-size: 12px;
        padding: 6px 12px;
        font-weight: 500;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 8px 16px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    /* Modal Styling */
    .modal-body {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 0 0 16px 16px;
    }
</style>

<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card card bg-transparent">
            <div class="card-bodys">
                <div class="table-header">
                    <h4>Tickets List</h4>
                    <div class="d-flex">
                        <a href="{{ route('admin.ticketSystem.create') }}" class="btn btn-primary text-white add-order-btn">
                            <i class="fas fa-plus-circle me-1"></i> New Ticket
                        </a>
                        <button type="button" class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#ticketCategoriesModal">
                            <i class="fas fa-layer-group me-1"></i> Manage Categories
                        </button>
                        <button type="button" class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#ticketStatusesModal">
                            <i class="fas fa-tasks me-1"></i> Manage Statuses
                        </button>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="responsive-table m-0">
                    <table class="table table-bordered table-card align-middle shadow-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Category</th>
                                <th>Assigned User</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    <form action="{{ route('admin.ticketSystem.updateStatus', $ticket->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_id" class="form-select form-select-sm" onchange="this.form.submit()" 
                                            style="background-color: {{ $ticket->status ? $ticket->status->color : '#fff' }}; color: #fff;">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}
                                                    style="background-color: {{ $status->color }}; color: #fff;">
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
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
                                    @if ($ticket->assignedUser)
                                        {{ $ticket->assignedUser->name }}
                                    @else
                                        <span class="text-muted">Unassigned</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.ticketSystem.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this ticket?')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                    
                                    <button type="button"
                                            class="btn btn-sm btn-secondary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#replyModal"
                                            data-ticket-id="{{ $ticket->id }}"
                                            data-ticket-title="{{ $ticket->title }}">
                                        <i class="fas fa-reply"></i>
                                    </button>
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketCategoriesModalLabel">Manage Ticket Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form at the top -->
                <form action="{{ route('admin.ticketCategories.store') }}" method="POST" id="categoryForm" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="category-name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="category-name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="category-color" class="form-label">Category Color</label>
                            <input type="color" name="color" id="category-color" class="form-control form-control-color" value="#000000" title="Choose your color">
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-plus-circle me-1"></i> Add Category
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="responsive-table">
                    <table class="table table-bordered table-card align-middle shadow-sm mb-0" style="background: #fff;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Name</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>
                                    <td class="text-capitalize">{{ $category->name }}</td>
                                    <td>
                                        <span class="color-swatch" style="background-color: {{ $category->color }}"></span>
                                        <span class="badge rounded-pill border" style="background: {{ $category->color }}20; color: #333;">
                                            {{ $category->color }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketStatusesModalLabel">Manage Ticket Statuses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form at the top -->
                <form action="{{ route('admin.ticketStatus.store') }}" method="POST" id="statusForm" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="status-name" class="form-label">Status Name</label>
                            <input type="text" name="name" id="status-name" class="form-control" placeholder="Enter status name" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="status-color" class="form-label">Status Color</label>
                            <input type="color" name="color" id="status-color" class="form-control form-control-color" value="#000000" title="Choose your color">
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-plus-circle me-1"></i> Add Status
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="responsive-table">
                    <table class="table table-bordered table-card align-middle shadow-sm mb-0" style="background: #fff;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Name</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statuses as $index => $status)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>
                                    <td class="text-capitalize">{{ $status->name }}</td>
                                    <td>
                                        <span class="color-swatch" style="background-color: {{ $status->color }}"></span>
                                        <span class="badge rounded-pill border" style="background: {{ $status->color }}20; color: #333;">
                                            {{ $status->color }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

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

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.ticketSystem.reply') }}">
      @csrf
      <input type="hidden" name="ticket_id" id="replyTicketId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="replyModalLabel">Reply to Ticket</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="replyMessage" class="form-label">Message</label>
            <textarea class="form-control" id="replyMessage" name="message" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Send Reply</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var ticketId = button.getAttribute('data-ticket-id');
        document.getElementById('replyTicketId').value = ticketId;
    });
});
</script>
@endsection