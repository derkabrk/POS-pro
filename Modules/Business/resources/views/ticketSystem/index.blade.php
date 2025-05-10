@extends('business::layouts.master')

@section('title', 'My Tickets')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>My Tickets</h4>
                    <a href="{{ route('business.ticketSystem.create') }}" class="btn btn-primary text-white add-order-btn">
                        <i class="fas fa-plus-circle me-1"></i> Create New Ticket
                    </a>
                </div>
                <div class="responsive-table m-0">
                    <table class="table table-bordered table-striped align-middle shadow-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>
                                        @if ($ticket->status)
                                            <span class="badge rounded-pill" style="background-color: {{ $ticket->status->color }}; color: #fff;">
                                                {{ $ticket->status->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">No Status</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->priority }}</td>
                                    <td>
                                        @if ($ticket->category)
                                            <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: #fff;">
                                                {{ $ticket->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">No Category</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection