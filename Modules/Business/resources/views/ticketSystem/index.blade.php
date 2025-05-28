@extends('business::layouts.master')

@section('title', __('My Tickets'))

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@component('components.breadcrumb')
@slot('li_1') {{ __('Business') }} @endslot
@slot('title') {{ __('Tickets') }} @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="ticketList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">{{ __('My Tickets') }}</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#createTicketModal">
                                <i class="fas fa-plus-circle me-1"></i> {{ __('Create New Ticket') }}
                            </button>
                        </div>
                    </div>
                </div>
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
                <div class="table-responsive table-card mb-1">
                    <table class="table table-nowrap align-middle" id="ticketsTable">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th class="sort" data-sort="id">#</th>
                                <th class="sort" data-sort="title">{{ __('Title') }}</th>
                                <th class="sort" data-sort="status">{{ __('Status') }}</th>
                                <th class="sort" data-sort="priority">{{ __('Priority') }}</th>
                                <th class="sort" data-sort="category">{{ __('Category') }}</th>
                                <th class="sort" data-sort="action">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all" id="tickets-data">
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
                                            <span class="text-muted">{{ __('No Status') }}</span>
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
                                            <span class="text-muted">{{ __('No Category') }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('business.ticketSystem.show', $ticket->id) }}" class="btn btn-info btn-sm rounded-circle d-inline-flex align-items-center justify-content-center me-1" title="{{ __('View') }}">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <button type="button" class="btn btn-secondary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#replyModal" data-ticket-id="{{ $ticket->id }}" data-ticket-title="{{ $ticket->title }}" title="{{ __('Reply') }}">
                                            <i class="ri-reply-line"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px">
                            </lord-icon>
                            <h5 class="mt-2">{{ __('Sorry! No Result Found') }}</h5>
                            <p class="text-muted">{{ __('We\'ve searched through all ticket records. We did not find any tickets matching your search criteria.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <div class="pagination-wrap hstack gap-2">
                        {{ $tickets->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<!-- Modal for Creating a Ticket -->
<div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTicketModalLabel">{{ __('Create New Ticket') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('business.ticketSystem.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <!-- Title -->
                        <div class="col-lg-6 mb-2">
                            <label for="title" class="form-label fw-bold">{{ __('Title') }}</label>
                            <input type="text" name="title" id="title" class="form-control shadow-sm" placeholder="{{ __('Enter ticket title') }}" required>
                        </div>

                        <!-- Description -->
                        <div class="col-lg-12 mb-2">
                            <label for="description" class="form-label fw-bold">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control shadow-sm" placeholder="{{ __('Enter ticket description') }}" rows="4" required></textarea>
                        </div>

                        <!-- Category -->
                        <div class="col-lg-6 mb-2">
                            <label for="category_id" class="form-label fw-bold">{{ __('Category') }}</label>
                            <select name="category_id" id="category_id" class="form-control shadow-sm">
                                <option value="">{{ __('Select a Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> {{ __('Create Ticket') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('business.ticketSystem.reply') }}">
      @csrf
      <input type="hidden" name="ticket_id" id="replyTicketId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="replyModalLabel">{{ __('Reply to Ticket') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="replyMessage" class="form-label">{{ __('Message') }}</label>
            <textarea class="form-control" id="replyMessage" name="message" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ __('Send Reply') }}</button>
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

@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection