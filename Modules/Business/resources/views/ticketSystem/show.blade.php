@extends('business::layouts.master')

@section('title', 'View Ticket')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Ticket Details</h4>
                    <a href="{{ route('business.ticketSystem.index') }}" class="btn btn-primary text-white add-order-btn">
                        <i class="fas fa-arrow-left me-1"></i> Back to Tickets
                    </a>
                </div>
                <div class="p-16">
                    <div class="row g-4">
                        <!-- Ticket Title -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold">Title:</h6>
                            <p>{{ $ticket->title }}</p>
                        </div>

                        <!-- Ticket Description -->
                        <div class="col-lg-12">
                            <h6 class="fw-bold">Description:</h6>
                            <p>{{ $ticket->description }}</p>
                        </div>

                        <!-- Ticket Category -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold">Category:</h6>
                            @if ($ticket->category)
                                <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: #fff;">
                                    {{ $ticket->category->name }}
                                </span>
                            @else
                                <span class="text-muted">No Category</span>
                            @endif
                        </div>

                        <!-- Ticket Status -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold">Status:</h6>
                            @if ($ticket->status)
                                <span class="badge rounded-pill" style="background-color: {{ $ticket->status->color }}; color: #fff;">
                                    {{ $ticket->status->name }}
                                </span>
                            @else
                                <span class="text-muted">No Status</span>
                            @endif
                        </div>

                        <!-- Ticket Priority -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold">Priority:</h6>
                            <p>{{ $ticket->priority ?? 'No Priority' }}</p>
                        </div>

                        <!-- Created At -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold">Created At:</h6>
                            <p>{{ $ticket->created_at->format('d M Y, h:i A') }}</p>
                        </div>

                        <!-- Updated At -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold">Last Updated:</h6>
                            <p>{{ $ticket->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Replies Section --}}
                    <div class="mt-4">
                        <h5 class="fw-bold">Replies</h5>
                        @if($ticket->replies && $ticket->replies->count())
                            @foreach($ticket->replies as $reply)
                                <div class="card mb-2 
                                    @if($reply->user_id == auth()->id()) border-primary @else border-secondary @endif">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>
                                                @if($reply->user_id == auth()->id())
                                                    <span class="badge bg-primary">You</span>
                                                @else
                                                    <span class="badge bg-secondary">User #{{ $reply->user_id }}</span>
                                                @endif
                                            </span>
                                            <small class="text-muted">{{ $reply->created_at->format('d M Y, h:i A') }}</small>
                                        </div>
                                        <div>{{ $reply->message }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No replies yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection