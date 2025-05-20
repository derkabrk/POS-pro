@extends('layouts.master')

@section('title', 'Tickets')

@section('content')

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
                    <table class="table table-bordered table-striped align-middle shadow-sm">
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
                    <table class="table table-bordered table-striped align-middle shadow-sm mb-0" style="background: #fff;">
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
                    <table class="table table-bordered table-striped align-middle shadow-sm mb-0" style="background: #fff;">
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