@extends('layouts.master')

@section('title', 'Tickets')

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">{{ __('Total Tickets') }}</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->total() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-success-subtle text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 17.32 % </span> {{ __('vs. previous month') }}</p>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                <i class="ri-ticket-2-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div>
    <!--end col-->
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">{{ __('Pending Tickets') }}</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->where('status.name', 'Pending')->count() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-danger-subtle text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 0.96 % </span> {{ __('vs. previous month') }}</p>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                <i class="mdi mdi-timer-sand"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">{{ __('Closed Tickets') }}</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->where('status.name', 'Closed')->count() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-danger-subtle text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 3.87 % </span> {{ __('vs. previous month') }}</p>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                <i class="ri-shopping-bag-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div>
    <!--end col-->
    <div class="col-xxl-3 col-sm-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">{{ __('High Priority') }}</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->where('priority', 'High')->count() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-success-subtle text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 1.09 % </span> {{ __('vs. previous month') }}</p>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                <i class="ri-alert-line"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="ticketsList">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">{{ __('Tickets List') }}</h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.ticketSystem.create') }}" class="btn btn-primary add-btn">
                                <i class="ri-add-line align-bottom me-1"></i> {{ __('New Ticket') }}
                            </a>
                            <button type="button" class="btn btn-soft-info" data-bs-toggle="modal" data-bs-target="#ticketCategoriesModal">
                                <i class="ri-folder-line align-bottom me-1"></i> {{ __('Manage Categories') }}
                            </button>
                            <button type="button" class="btn btn-soft-warning" data-bs-toggle="modal" data-bs-target="#ticketStatusesModal">
                                <i class="ri-list-check align-bottom me-1"></i> {{ __('Manage Statuses') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form>
                    <div class="row g-3">
                        <div class="col-xxl-5 col-sm-12">
                            <div class="search-box">
                                <input type="text" class="form-control search bg-light border-light" placeholder="{{ __('Search for ticket details or something...') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col-xxl-3 col-sm-4">
                            <input type="text" class="form-control bg-light border-light" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" placeholder="{{ __('Select date range') }}">
                        </div>
                        <!--end col-->

                        <div class="col-xxl-3 col-sm-4">
                            <div class="input-light">
                                <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                    <option value="">{{ __('Status') }}</option>
                                    <option value="all" selected>{{ __('All') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-1 col-sm-4">
                            <button type="button" class="btn btn-primary w-100"> 
                                <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                {{ __('Filters') }}
                            </button>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <!--end card-body-->
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card-body">
                <div class="table-responsive table-card mb-4">
                    <table class="table align-middle table-nowrap mb-0" id="ticketTable">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 40px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                    </div>
                                </th>
                                <th class="sort" data-sort="id">{{ __('ID') }}</th>
                                <th class="sort" data-sort="tasks_name">{{ __('Title') }}</th>
                                <th class="sort" data-sort="status">{{ __('Status') }}</th>
                                <th class="sort" data-sort="priority">{{ __('Priority') }}</th>
                                <th class="sort" data-sort="category">{{ __('Category') }}</th>
                                <th class="sort" data-sort="assigned">{{ __('Assigned User') }}</th>
                                <th class="sort" data-sort="action">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="checkAll" value="{{ $ticket->id }}">
                                        </div>
                                    </th>
                                    <td class="id"><a href="{{ route('admin.ticketSystem.show', $ticket->id) }}" class="fw-medium link-primary">#{{ $ticket->id }}</a></td>
                                    <td class="tasks_name">{{ $ticket->title }}</td>
                                    <td class="status">
                                        <form action="{{ route('admin.ticketSystem.updateStatus', $ticket->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td class="priority">
                                        @if($ticket->priority == 'High')
                                            <span class="badge bg-danger text-uppercase">{{ __('High') }}</span>
                                        @elseif($ticket->priority == 'Medium')
                                            <span class="badge bg-warning text-uppercase">{{ __('Medium') }}</span>
                                        @else
                                            <span class="badge bg-success text-uppercase">{{ __('Low') }}</span>
                                        @endif
                                    </td>
                                    <td class="category">
                                        @if($ticket->category)
                                            <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: #fff;">
                                                {{ $ticket->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">{{ __('No Category') }}</span>
                                        @endif
                                    </td>
                                    <td class="assigned">
                                        @if ($ticket->assignedUser)
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary text-white">
                                                            {{ substr($ticket->assignedUser->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    {{ $ticket->assignedUser->name }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">{{ __('Unassigned') }}</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <div class="dropdown">
                                            <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#replyModal" data-ticket-id="{{ $ticket->id }}" data-ticket-title="{{ $ticket->title }}">
                                                        <i class="ri-reply-fill align-bottom me-2 text-muted"></i> {{ __('Reply') }}
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.ticketSystem.show', $ticket->id) }}">
    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> {{ __('View') }}
</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> {{ __('Edit') }}
                                                    </a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.ticketSystem.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('{{ __('Are you sure you want to delete this ticket?') }}')">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-danger"></i> {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if($tickets->isEmpty())
                    <div class="noresult" style="display: block;">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#8c68cd,secondary:#4788ff" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-2">{{ __('Sorry! No Result Found') }}</h5>
                            <p class="text-muted mb-0">{{ __('We\'ve searched more than 150+ Tickets We did not find any Tickets for you search.') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="d-flex justify-content-end mt-2">
                    <div class="pagination-wrap hstack gap-2">
                        {{ $tickets->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

<!-- Modal for Ticket Categories -->
<div class="modal fade zoomIn" id="ticketCategoriesModal" tabindex="-1" aria-labelledby="ticketCategoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="ticketCategoriesModalLabel">{{ __('Manage Ticket Categories') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <div class="modal-body">
                <!-- Form at the top -->
                <form action="{{ route('admin.ticketCategories.store') }}" method="POST" id="categoryForm" class="mb-4 tablelist-form" autocomplete="off">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div>
                                <label for="category-name" class="form-label">{{ __('Category Name') }}</label>
                                <input type="text" name="name" id="category-name" class="form-control" placeholder="{{ __('Enter category name') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="category-color" class="form-label">{{ __('Category Color') }}</label>
                                <input type="color" name="color" id="category-color" class="form-control form-control-color" value="#3577f1" title="{{ __('Choose your color') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-success" id="add-btn">
                                <i class="ri-add-line align-bottom me-1"></i> {{ __('Add Category') }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Categories Table -->
                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap" id="categoryTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAllCategories" value="option">
                                    </div>
                                </th>
                                <th class="sort" data-sort="category_name">{{ __('Category Name') }}</th>
                                <th class="sort" data-sort="category_color">{{ __('Color') }}</th>
                                <th class="sort" data-sort="action">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach($categories as $index => $category)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="checkAllCategories" value="{{ $category->id }}">
                                        </div>
                                    </th>
                                    <td class="category_name">{{ $category->name }}</td>
                                    <td class="category_color">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar-xs" style="background-color: {{ $category->color }}; border-radius: 4px;"></div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $category->color }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="edit">
                                                <button class="btn btn-sm btn-success edit-item-btn" 
                                                    data-id="{{ $category->id }}" 
                                                    data-name="{{ $category->name }}" 
                                                    data-color="{{ $category->color }}">
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                                </button>
                                            </div>
                                            <div class="remove">
                                                <button class="btn btn-sm btn-danger remove-item-btn" data-id="{{ $category->id }}">
                                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                                </button>
                                                <form id="delete-category-{{ $category->id }}" action="{{ route('admin.ticketCategories.destroy', $category->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal for Ticket Statuses -->
<div class="modal fade zoomIn" id="ticketStatusesModal" tabindex="-1" aria-labelledby="ticketStatusesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="ticketStatusesModalLabel">{{ __('Manage Ticket Statuses') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-status-modal"></button>
            </div>
            <div class="modal-body">
                <!-- Form at the top -->
                <form action="{{ route('admin.ticketStatus.store') }}" method="POST" id="statusForm" class="tablelist-form" autocomplete="off">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div>
                                <label for="status-name" class="form-label">{{ __('Status Name') }}</label>
                                <input type="text" name="name" id="status-name" class="form-control" placeholder="{{ __('Enter status name') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="status-color" class="form-label">{{ __('Status Color') }}</label>
                                <input type="color" name="color" id="status-color" class="form-control form-control-color" value="#3577f1" title="{{ __('Choose your color') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-success" id="add-status-btn">
                                <i class="ri-add-line align-bottom me-1"></i> {{ __('Add Status') }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Statuses Table -->
                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap" id="statusTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAllStatuses" value="option">
                                    </div>
                                </th>
                                <th class="sort" data-sort="status_name">{{ __('Status Name') }}</th>
                                <th class="sort" data-sort="status_color">{{ __('Color') }}</th>
                                <th class="sort" data-sort="action">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach($statuses as $index => $status)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="checkAllStatuses" value="{{ $status->id }}">
                                        </div>
                                    </th>
                                    <td class="status_name">{{ $status->name }}</td>
                                    <td class="status_color">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar-xs" style="background-color: {{ $status->color }}; border-radius: 4px;"></div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $status->color }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="edit">
                                                <button class="btn btn-sm btn-success edit-item-btn" 
                                                    data-id="{{ $status->id }}" 
                                                    data-name="{{ $status->name }}" 
                                                    data-color="{{ $status->color }}">
                                                    <i class="ri-pencil-fill align-bottom"></i>
                                                </button>
                                            </div>
                                            <div class="remove">
                                                <button class="btn btn-sm btn-danger remove-item-btn" data-id="{{ $status->id }}">
                                                    <i class="ri-delete-bin-fill align-bottom"></i>
                                                </button>
                                                <form id="delete-status-{{ $status->id }}" action="{{ route('admin.ticketStatus.destroy', $status->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
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
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade zoomIn" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="replyModalLabel">{{ __('Reply to Ticket') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.ticketSystem.reply') }}" class="tablelist-form" autocomplete="off">
                @csrf
                <input type="hidden" name="ticket_id" id="replyTicketId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">{{ __('Message') }}</label>
                        <textarea class="form-control" id="replyMessage" name="message" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-send-plane-fill align-bottom me-1"></i> {{ __('Send Reply') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Reply modal functionality
    var replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var ticketId = button.getAttribute('data-ticket-id');
        var ticketTitle = button.getAttribute('data-ticket-title');
        document.getElementById('replyTicketId').value = ticketId;
        document.getElementById('replyModalLabel').textContent = 'Reply to: ' + ticketTitle;
    });
    
    // Initialize counter animation
    document.querySelectorAll('.counter-value').forEach(function(counterElement) {
        const target = parseInt(counterElement.getAttribute('data-target')) || 0;
        let count = 0;
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        
        const timer = setInterval(function() {
            count += increment;
            if (count >= target) {
                clearInterval(timer);
                count = target;
            }
            counterElement.textContent = Math.floor(count);
        }, 16);
    });
    
    // Check/Uncheck all functionality for main table
    document.getElementById('checkAll').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('input[name="checkAll"]').forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });
    
    // Check/Uncheck all functionality for categories table
    if (document.getElementById('checkAllCategories')) {
        document.getElementById('checkAllCategories').addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('input[name="checkAllCategories"]').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
    }
    
    // Check/Uncheck all functionality for statuses table
    if (document.getElementById('checkAllStatuses')) {
        document.getElementById('checkAllStatuses').addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('input[name="checkAllStatuses"]').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
    }

    // Category Edit/Delete
    $(document).on('click', '#categoryTable .edit-item-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var color = $(this).data('color');
        $('#category-name').val(name);
        $('#category-color').val(color);
        $('#categoryForm').attr('action', '/admin/ticket-categories/' + id);
        if ($('#categoryForm input[name="_method"]').length === 0) {
            $('#categoryForm').append('<input type="hidden" name="_method" value="PUT">');
        } else {
            $('#categoryForm input[name="_method"]').val('PUT');
        }
        $('#add-btn').html('<i class="ri-save-line align-bottom me-1"></i> {{ __('Update Category') }}');
    });
    $(document).on('click', '#categoryTable .remove-item-btn', function() {
        var id = $(this).data('id');
        if (confirm('{{ __('Are you sure you want to delete this category?') }}')) {
            $('#delete-category-' + id).submit();
        }
    });
    $('#ticketCategoriesModal').on('hidden.bs.modal', function () {
        $('#categoryForm').trigger('reset');
        $('#categoryForm').attr('action', '{{ route('admin.ticketCategories.store') }}');
        $('#categoryForm input[name="_method"]').remove();
        $('#add-btn').html('<i class="ri-add-line align-bottom me-1"></i> {{ __('Add Category') }}');
    });

    // Status Edit/Delete
    $(document).on('click', '#statusTable .edit-item-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var color = $(this).data('color');
        $('#status-name').val(name);
        $('#status-color').val(color);
        $('#statusForm').attr('action', '/admin/ticket-status/' + id);
        if ($('#statusForm input[name="_method"]').length === 0) {
            $('#statusForm').append('<input type="hidden" name="_method" value="PUT">');
        } else {
            $('#statusForm input[name="_method"]').val('PUT');
        }
        $('#add-status-btn').html('<i class="ri-save-line align-bottom me-1"></i> {{ __('Update Status') }}');
    });
    $(document).on('click', '#statusTable .remove-item-btn', function() {
        var id = $(this).data('id');
        if (confirm('{{ __('Are you sure you want to delete this status?') }}')) {
            $('#delete-status-' + id).submit();
        }
    });
    $('#ticketStatusesModal').on('hidden.bs.modal', function () {
        $('#statusForm').trigger('reset');
        $('#statusForm').attr('action', '{{ route('admin.ticketStatus.store') }}');
        $('#statusForm input[name="_method"]').remove();
        $('#add-status-btn').html('<i class="ri-add-line align-bottom me-1"></i> {{ __('Add Status') }}');
    });
});
</script>
@endsection