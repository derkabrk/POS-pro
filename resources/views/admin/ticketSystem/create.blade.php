@extends('layouts.master')

@section('title', 'Tickets')

@section('main_content')
<div class="container">
    <h1>Create Ticket</h1>
    <form action="{{ route('admin.ticketSystem.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter ticket title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter ticket description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" required>
        </div>

        <div class="mb-3">
            <label for="business_id" class="form-label">Business</label>
            <select name="business_id" id="business_id" class="form-control" required>
                <option value="">Select a Business</option>
                @foreach ($businesses as $business)
                    <option value="{{ $business->id }}">{{ $business->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select name="status_id" id="status_id" class="form-control" required>
                <option value="">Select a Status</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priority</label>
            <select name="priority" id="priority" class="form-control" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-danger">
            <i class="fas fa-plus-circle me-1"></i> Create Ticket
        </button>
    </form>
</div>
@endsection