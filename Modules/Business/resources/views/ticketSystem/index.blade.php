@extends('business::layouts.master')

@section('title', 'My Tickets')

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card" id="ticketList">
            <div class="card-header border-0 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ __('My Tickets') }}</h5>
                <button type="button" class="btn btn-primary add-btn btn-sm rounded-pill d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#createTicketModal">
                    <i class="fas fa-plus-circle me-1"></i> {{ __('Create New Ticket') }}
                </button>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive table-card m-0">
                    <table class="table table-nowrap mb-0 align-middle table-striped" id="ticketsTable">
                        <thead class="table-light">
                            <tr class="text-uppercase">
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Title') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Priority') }}</th>
                                <th scope="col">{{ __('Category') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td class="align-middle">{{ $ticket->id }}</td>
                                    <td class="align-middle fw-semibold">{{ $ticket->title }}</td>
                                    <td class="align-middle">
                                        @if ($ticket->status)
                                            <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background-color: {{ $ticket->status->color }}; color: #fff; min-width: 90px; display: inline-block;">
                                                {{ $ticket->status->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">No Status</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark border border-1 border-secondary px-2 py-1">{{ $ticket->priority }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @if ($ticket->category)
                                            <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background-color: {{ $ticket->category->color }}; color: #fff; min-width: 90px; display: inline-block;">
                                                {{ $ticket->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">No Category</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('business.ticketSystem.show', $ticket->id) }}" class="btn btn-info btn-sm rounded-pill px-3 py-1">
                                            <i class="fas fa-eye"></i> {{ __('View') }}
                                        </a>
                                        <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3 py-1" data-bs-toggle="modal" data-bs-target="#replyModal" data-ticket-id="{{ $ticket->id }}" data-ticket-title="{{ $ticket->title }}">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating a Ticket -->
<div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTicketModalLabel">Create New Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.ticketSystem.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- Title -->
                        <div class="col-lg-6 mb-2">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" name="title" id="title" class="form-control shadow-sm" placeholder="Enter ticket title" required>
                        </div>

                        <!-- Description -->
                        <div class="col-lg-12 mb-2">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" class="form-control shadow-sm" placeholder="Enter ticket description" rows="4" required></textarea>
                        </div>

                        <!-- Category -->
                        <div class="col-lg-6 mb-2">
                            <label for="category_id" class="form-label fw-bold">Category</label>
                            <select name="category_id" id="category_id" class="form-control shadow-sm">
                                <option value="">Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Create Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('business.ticketSystem.reply') }}">
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