@extends('admin::layouts.master')

@section('title', 'Tickets')

@section('main_content')
<div class="container">
    <h1>Tickets</h1>
    <a href="{{ route('admin.ticketSystem.create') }}" class="btn btn-primary">Create Ticket</a>
    <table class="table">
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
@endsection