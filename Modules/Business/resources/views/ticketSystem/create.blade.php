@extends('business::layouts.master')

@section('title', 'Create Ticket')

@section('main_content')
<div class="container">
    <h1>Create Ticket</h1>
    <form action="{{ route('business.ticketSystem.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Open">Open</option>
                <option value="Closed">Closed</option>
                <option value="Pending">Pending</option>
            </select>
        </div>
        <div class="form-group">
            <label for="priority">Priority</label>
            <select name="priority" id="priority" class="form-control">
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>
        <div class="form-group">
            <label for="assigned_to">Assign To</label>
            <input type="number" name="assigned_to" id="assigned_to" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create Ticket</button>
    </form>
</div>
@endsection