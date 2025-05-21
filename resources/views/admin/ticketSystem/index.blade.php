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
                        <p class="fw-medium text-muted mb-0">Total Tickets</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->total() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-success-subtle text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 17.32 % </span> vs. previous month</p>
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
                        <p class="fw-medium text-muted mb-0">Pending Tickets</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->where('status.name', 'Pending')->count() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-danger-subtle text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 0.96 % </span> vs. previous month</p>
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
                        <p class="fw-medium text-muted mb-0">Closed Tickets</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->where('status.name', 'Closed')->count() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-danger-subtle text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 3.87 % </span> vs. previous month</p>
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
                        <p class="fw-medium text-muted mb-0">High Priority</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $tickets->where('priority', 'High')->count() }}">0</span></h2>
                        <p class="mb-0 text-muted"><span class="badge bg-success-subtle text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 1.09 % </span> vs. previous month</p>
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
                    <h5 class="card-title mb-0 flex-grow-1">Tickets List</h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.ticketSystem.create') }}" class="btn btn-primary add-btn">
                                <i class="ri-add-line align-bottom me-1"></i> New Ticket
                            </a>
                            <button type="button" class="btn btn-soft-info" data-bs-toggle="modal" data-bs-target="#ticketCategoriesModal">
                                <i class="ri-folder-line align-bottom me-1"></i> Manage Categories
                            </button>
                            <button type="button" class="btn btn-soft-warning" data-bs-toggle="modal" data-bs-target="#ticketStatusesModal">
                                <i class="ri-list-check align-bottom me-1"></i> Manage Statuses
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
                                <input type="text" class="form-control search bg-light border-light" placeholder="Search for ticket details or something...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col-xxl-3 col-sm-4">
                            <input type="text" class="form-control bg-light border-light" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" placeholder="Select date range">
                        </div>
                        <!--end col-->

                        <div class="col-xxl-3 col-sm-4">
                            <div class="input-light">
                                <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                    <option value="">Status</option>
                                    <option value="all" selected>All</option>
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
                                Filters
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
                                <th class="sort" data-sort="id">ID</th>
                                <th class="sort" data-sort="title">Title</th>
                                <th class="sort" data-sort="status">Status</th>
                                <th class="sort" data-sort="priority">Priority</th>
                                <th class="sort" data-sort="category">Category</th>
                                <th class="sort" data-sort="assigned">Assigned User</th>
                                <th class="sort" data-sort="action">Action</th>
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
                                    <td class="id"><a href="#" class="fw-medium link-primary">#{{ $ticket->id }}</a></td>
                                    <td class="title">{{ $ticket->title }}</td>
                                    <td class="status">
                                        <form action="{{ route('admin.ticketSystem.updateStatus', $ticket->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_id" class="form-select form-select-sm" onchange="this.form.submit()" 
                                                style="background-color: {{ $ticket->status ? $ticket->status->color : '#fff' }}; color: #fff; border-radius: 4px;">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}
                                                        style="background-color: {{ $status->color }}; color: #fff;">
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td class="priority">
                                        <span class="badge bg-{{ $ticket->priority === 'High' ? 'danger' : ($ticket->priority === 'Medium' ? 'warning' : 'info') }} text-uppercase">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="category">
                                        @if($ticket->category)
                                            <span class="badge bg-light text-dark border">
                                                <span class="d-inline-block rounded-circle me-1" style="width: 10px; height: 10px; background-color: {{ $ticket->category->color }}"></span>
                                                {{ $ticket->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="assigned">
                                        @if ($ticket->assignedUser)
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs bg-primary-subtle text-primary rounded-circle">
                                                        <span class="avatar-title">{{ substr($ticket->assignedUser->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    {{ $ticket->assignedUser->name }}
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Unassigned</span>
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
                                                        <i class="ri-reply-fill align-bottom me-2 text-muted"></i> Reply
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                    </a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.ticketSystem.destroy', $ticket->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this ticket?')">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-danger"></i> Delete
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
                    <div class="noresult">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#8c68cd,secondary:#4788ff" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-2">Sorry! No Result Found</h5>
                            <p class="text-muted mb-0">We couldn't find any tickets matching your search.</p>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="d-flex justify-content-end mt-2">
                    {{ $tickets->links('vendor.pagination.bootstrap-5') }}
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
                <h5 class="modal-title" id="ticketCategoriesModalLabel">Manage Ticket Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form at the top -->
                <form action="{{ route('admin.ticketCategories.store') }}" method="POST" id="categoryForm" class="mb-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div>
                                <label for="category-name" class="form-label">Category Name</label>
                                <input type="text" name="name" id="category-name" class="form-control" placeholder="Enter category name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="category-color" class="form-label">Category Color</label>
                                <input type="color" name="color" id="category-color" class="form-control form-control-color" value="#000000" title="Choose your color">
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="ri-add-line align-bottom me-1"></i> Add Category
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Categories Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 60px;">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Color</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $index => $category)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>
                                    <td class="text-capitalize">{{ $category->name }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block rounded-circle me-2" style="width: 18px; height: 18px; background-color: {{ $category->color }}"></span>
                                            <span class="badge bg-light text-dark border">{{ $category->color }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="hstack gap-2">
                                            <button type="button" class="btn btn-sm btn-soft-primary">
                                                <i class="ri-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-soft-danger">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
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
<div class="modal fade zoomIn" id="ticketStatusesModal" tabindex="-1" aria-labelledby="ticketStatusesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="ticketStatusesModalLabel">Manage Ticket Statuses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form at the top -->
                <form action="{{ route('admin.ticketStatus.store') }}" method="POST" id="statusForm" class="mb-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div>
                                <label for="status-name" class="form-label">Status Name</label>
                                <input type="text" name="name" id="status-name" class="form-control" placeholder="Enter status name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <label for="status-color" class="form-label">Status Color</label>
                                <input type="color" name="color" id="status-color" class="form-control form-control-color" value="#000000" title="Choose your color">
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="ri-add-line align-bottom me-1"></i> Add Status
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Statuses Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 60px;">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Color</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statuses as $index => $status)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>
                                    <td class="text-capitalize">{{ $status->name }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block rounded-circle me-2" style="width: 18px; height: 18px; background-color: {{ $status->color }}"></span>
                                            <span class="badge bg-light text-dark border">{{ $status->color }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="hstack gap-2">
                                            <button type="button" class="btn btn-sm btn-soft-primary">
                                                <i class="ri-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-soft-danger">
                                                <i class="ri-delete-bin-fill"></i>
                                            </button>
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
<div class="modal fade zoomIn" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="replyModalLabel">Reply to Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.ticketSystem.reply') }}" class="tablelist-form" autocomplete="off">
                @csrf
                <input type="hidden" name="ticket_id" id="replyTicketId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="replyMessage" name="message" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-send-plane-fill align-bottom me-1"></i> Send Reply
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
    
    // Check/Uncheck all functionality
    document.getElementById('checkAll').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('input[name="checkAll"]').forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });
});
</script>
@endsection