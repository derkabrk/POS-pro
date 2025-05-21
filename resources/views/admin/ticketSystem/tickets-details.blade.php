@extends('layouts.master')

@section('title', 'Ticket Details')

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Ticket Header Section -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mt-n4 mx-n4 card-border-effect-none mb-n5 border-bottom-0 border-start-0 rounded-0">
            <div>
                <div class="card-body pb-4 mb-5">
                    <div class="row">
                        <div class="col-md">
                            <div class="row align-items-center">
                                <div class="col-md-auto">
                                    <div class="avatar-md mb-md-0 mb-4">
                                        <div class="avatar-title bg-white rounded-circle">
                                            <i class="ri-ticket-2-line fs-2 text-primary"></i>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-md">
                                    <h4 class="fw-semibold">#{{ $ticket->id }} - {{ $ticket->title }}</h4>
                                    <div class="hstack gap-3 flex-wrap">
                                        <div class="text-muted">
                                            <i class="ri-user-3-line align-bottom me-1"></i>
                                            <span>{{ $ticket->user->name ?? 'Unknown User' }}</span>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Created: <span class="fw-medium">{{ $ticket->created_at->format('d M, Y') }}</span></div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Updated: <span class="fw-medium">{{ $ticket->updated_at->format('d M, Y') }}</span></div>
                                        <div class="vr"></div>
                                        @if($ticket->status)
                                            <div class="badge rounded-pill fs-12" style="background-color: {{ $ticket->status->color }}">
                                                {{ $ticket->status->name }}
                                            </div>
                                        @else
                                            <div class="badge rounded-pill bg-secondary fs-12">No Status</div>
                                        @endif
                                        <div class="badge rounded-pill bg-{{ $ticket->priority === 'High' ? 'danger' : ($ticket->priority === 'Medium' ? 'warning' : 'info') }} fs-12">
                                            {{ $ticket->priority }}
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end col-->
                        <div class="col-md-auto mt-md-0 mt-4">
                            <div class="hstack gap-1 flex-wrap">
                                <button type="button" class="btn py-0 fs-16 text-body" id="ticketDropdown" data-bs-toggle="dropdown">
                                    <i class="ri-more-2-fill"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="ticketDropdown">
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#replyModal" data-ticket-id="{{ $ticket->id }}" data-ticket-title="{{ $ticket->title }}">
                                            <i class="ri-reply-fill align-bottom me-2 text-muted"></i> Reply
                                        </button>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('business.ticketSystem.index') }}"><i class="ri-corner-up-left-fill align-bottom me-2 text-muted"></i> Back to List</a></li>
                                    @if(auth()->user()->can('update', $ticket))
                                    <li><a class="dropdown-item" href="#"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                    @endif
                                    @if(auth()->user()->can('delete', $ticket))
                                    <li>
                                        <form action="{{ route('business.ticketSystem.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('Are you sure you want to delete this ticket?')">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-danger"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!-- end card body -->
            </div>
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->

<!-- Ticket Content and Comments -->
<div class="row">
    <div class="col-xxl-9">
        <div class="card">
            <div class="card-body p-4">
                <h6 class="fw-semibold text-uppercase mb-3">Ticket Description</h6>
                <div class="ticket-description">
                    {!! nl2br(e($ticket->description)) !!}
                </div>
                
                @if(!empty($ticket->attachments))
                <div class="mt-4">
                    <h6 class="fw-semibold text-uppercase mb-3">Attachments</h6>
                    <div class="row g-3">
                        @foreach($ticket->attachments as $attachment)
                        <div class="col-lg-4">
                            <div class="border rounded border-dashed p-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <div class="avatar-title bg-light rounded">
                                            <i class="ri-file-text-line fs-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1"><a href="{{ route('business.ticketSystem.download', $attachment->id) }}">{{ $attachment->filename }}</a></h6>
                                        <small class="text-muted">{{ round($attachment->filesize / 1024, 2) }} KB</small>
                                    </div>
                                    <div class="hstack gap-3 fs-16">
                                        <a href="{{ route('business.ticketSystem.download', $attachment->id) }}" class="text-muted"><i class="ri-download-2-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div><!--end card-body-->
            
            <div class="card-body p-4">
                <h5 class="card-title mb-4">Comments</h5>

                <div data-simplebar style="height: 300px;" class="px-3 mx-n3">
                    @if($ticket->comments && count($ticket->comments) > 0)
                        @foreach($ticket->comments as $comment)
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                        {{ substr($comment->user->name ?? 'U', 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="fs-13">{{ $comment->user->name ?? 'Unknown User' }} <small class="text-muted">{{ $comment->created_at->format('d M Y - h:iA') }}</small></h5>
                                <p class="text-muted">{{ $comment->message }}</p>
                                
                                @if(!empty($comment->attachments))
                                    <div class="row g-2 mb-3">
                                        @foreach($comment->attachments as $attachment)
                                        <div class="col-lg-1 col-sm-2 col-6">
                                            <a href="{{ route('business.ticketSystem.download', $attachment->id) }}" class="d-block text-center border rounded p-1">
                                                <i class="ri-file-text-line fs-24 text-primary"></i>
                                                <small class="d-block text-truncate">{{ $attachment->filename }}</small>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <button type="button" 
                                    class="badge text-muted bg-light reply-comment-btn"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#replyModal"
                                    data-ticket-id="{{ $ticket->id }}"
                                    data-parent-id="{{ $comment->id }}">
                                    <i class="mdi mdi-reply"></i> Reply
                                </button>
                                
                                @if(!empty($comment->replies))
                                    @foreach($comment->replies as $reply)
                                    <div class="d-flex mt-4">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle bg-info text-white">
                                                    {{ substr($reply->user->name ?? 'U', 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fs-13">{{ $reply->user->name ?? 'Unknown User' }} <small class="text-muted">{{ $reply->created_at->format('d M Y - h:iA') }}</small></h5>
                                            <p class="text-muted">{{ $reply->message }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <div class="avatar-md mx-auto my-4">
                                <div class="avatar-title bg-light text-secondary rounded-circle fs-2">
                                    <i class="ri-chat-3-line"></i>
                                </div>
                            </div>
                            <h5 class="text-muted">No comments yet</h5>
                            <p class="text-muted">Be the first to add a comment to this ticket.</p>
                        </div>
                    @endif
                </div>
                
                <form action="{{ route('business.ticketSystem.reply') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="comment-message" class="form-label">Leave a Comment</label>
                            <textarea class="form-control bg-light border-light" id="comment-message" name="message" rows="3" placeholder="Write your comment here..."></textarea>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-send-plane-fill align-bottom me-1"></i> Post Comment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div><!--end card-->
    </div><!--end col-->
    
    <div class="col-xxl-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Ticket Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-medium">Ticket ID</td>
                                <td>#{{ $ticket->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Created By</td>
                                <td>{{ $ticket->user->name ?? 'Unknown User' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Category</td>
                                <td>
                                    @if($ticket->category)
                                        <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: #fff;">
                                            {{ $ticket->category->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">No Category</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Assigned To</td>
                                <td>
                                    @if($ticket->assignedUser)
                                        <div class="avatar-group">
                                            <a href="javascript:void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" data-bs-original-title="{{ $ticket->assignedUser->name }}">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                                        {{ substr($ticket->assignedUser->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </a>
                                            @if(auth()->user()->can('update', $ticket))
                                            <a href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" data-bs-original-title="Assign to User">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title fs-16 rounded-circle bg-light border-dashed border text-primary">
                                                        +
                                                    </div>
                                                </div>
                                            </a>
                                            @endif
                                        </div>
                                    @elseif(auth()->user()->can('update', $ticket))
                                        <button type="button" class="btn btn-sm btn-soft-primary" data-bs-toggle="modal" data-bs-target="#assignTicketModal">
                                            <i class="ri-user-add-line align-middle me-1"></i> Assign Ticket
                                        </button>
                                    @else
                                        <span class="text-muted">Not Assigned</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Status</td>
                                <td>
                                    @if(auth()->user()->can('update', $ticket))
                                        <form action="{{ route('business.ticketSystem.updateStatus', $ticket->id) }}" method="POST" id="statusForm">
                                            @csrf
                                            @method('PATCH')
                                            <select class="form-select form-select-sm" name="status_id" onchange="document.getElementById('statusForm').submit()">
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @else
                                        @if($ticket->status)
                                            <span class="badge" style="background-color: {{ $ticket->status->color }}; color: #fff;">
                                                {{ $ticket->status->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">No Status</span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Priority</td>
                                <td>
                                    @if(auth()->user()->can('update', $ticket))
                                        <form action="{{ route('business.ticketSystem.updatePriority', $ticket->id) }}" method="POST" id="priorityForm">
                                            @csrf
                                            @method('PATCH')
                                            <select class="form-select form-select-sm" name="priority" onchange="document.getElementById('priorityForm').submit()">
                                                <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                                <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
                                            </select>
                                        </form>
                                    @else
                                        <span class="badge bg-{{ $ticket->priority === 'High' ? 'danger' : ($ticket->priority === 'Medium' ? 'warning' : 'info') }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Created Date</td>
                                <td>{{ $ticket->created_at->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-medium">Last Updated</td>
                                <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                            </tr>
                            @if($ticket->tags && count($ticket->tags) > 0)
                            <tr>
                                <td class="fw-medium">Tags</td>
                                <td class="hstack text-wrap gap-1">
                                    @foreach($ticket->tags as $tag)
                                    <span class="badge bg-primary-subtle text-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div><!--end card-body-->
        </div><!--end card-->
        
        @if(!empty($ticket->attachments))
        <div class="card">
            <div class="card-header">
                <h6 class="card-title fw-semibold mb-0">Attachments</h6>
            </div>
            <div class="card-body">
                @foreach($ticket->attachments as $attachment)
                <div class="d-flex align-items-center border border-dashed p-2 rounded {{ !$loop->first ? 'mt-2' : '' }}">
                    <div class="flex-shrink-0 avatar-sm">
                        <div class="avatar-title bg-light rounded">
                            @php
                                $ext = pathinfo($attachment->filename, PATHINFO_EXTENSION);
                                $icon = 'ri-file-text-line';
                                $color = 'primary';
                                
                                if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    $icon = 'ri-image-line';
                                    $color = 'success';
                                } elseif(in_array($ext, ['pdf'])) {
                                    $icon = 'ri-file-pdf-line';
                                    $color = 'danger';
                                } elseif(in_array($ext, ['doc', 'docx'])) {
                                    $icon = 'ri-file-word-line';
                                    $color = 'info';
                                } elseif(in_array($ext, ['xls', 'xlsx'])) {
                                    $icon = 'ri-file-excel-line';
                                    $color = 'success';
                                } elseif(in_array($ext, ['zip', 'rar'])) {
                                    $icon = 'ri-file-zip-line';
                                    $color = 'warning';
                                }
                            @endphp
                            <i class="{{ $icon }} fs-20 text-{{ $color }}"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1"><a href="{{ route('business.ticketSystem.download', $attachment->id) }}">{{ $attachment->filename }}</a></h6>
                        <small class="text-muted">{{ round($attachment->filesize / 1024, 2) }} KB</small>
                    </div>
                    <div class="hstack gap-3 fs-16">
                        <a href="{{ route('business.ticketSystem.download', $attachment->id) }}" class="text-muted"><i class="ri-download-2-line"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        @if($relatedTickets && count($relatedTickets) > 0)
        <div class="card">
            <div class="card-header">
                <h6 class="card-title fw-semibold mb-0">Related Tickets</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($relatedTickets as $relatedTicket)
                    <li class="list-group-item px-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="ri-ticket-2-line text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-1"><a href="{{ route('business.ticketSystem.show', $relatedTicket->id) }}">#{{ $relatedTicket->id }} - {{ $relatedTicket->title }}</a></h6>
                                <small class="text-muted">
                                    @if($relatedTicket->status)
                                        <span class="badge rounded-pill" style="background-color: {{ $relatedTicket->status->color }}; color: #fff;">
                                            {{ $relatedTicket->status->name }}
                                        </span>
                                    @endif
                                    · {{ $relatedTicket->created_at->format('d M, Y') }}
                                </small>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div><!--end col-->
</div><!--end row-->

<!-- Reply Modal -->
<div class="modal fade zoomIn" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="replyModalLabel">Reply to Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('business.ticketSystem.reply') }}" class="tablelist-form" autocomplete="off">
                @csrf
                <input type="hidden" name="ticket_id" id="replyTicketId" value="{{ $ticket->id }}">
                <input type="hidden" name="parent_id" id="replyParentId" value="">
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

<!-- Assign Ticket Modal -->
@if(auth()->user()->can('update', $ticket))
<div class="modal fade zoomIn" id="assignTicketModal" tabindex="-1" aria-labelledby="assignTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-primary-subtle">
                <h5 class="modal-title" id="assignTicketModalLabel">Assign Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('business.ticketSystem.assign', $ticket->id) }}" class="tablelist-form" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assigned_user_id" class="form-label">Select User</label>
                        <select class="form-select" id="assigned_user_id" name="assigned_user_id" required>
                            <option value="">Select a user</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $ticket->assigned_user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-user-add-line align-bottom me-1"></i> Assign
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('script')
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Reply modal functionality
    var replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var ticketId = button.getAttribute('data-ticket-id');
        var parentId = button.getAttribute('data-parent-id');
        document.getElementById('replyTicketId').value = ticketId;
        document.getElementById('replyParentId').value = parentId || '';
    });
});
</script>
@endsection