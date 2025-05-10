@extends('layouts.master')

@section('title', 'Create Ticket')

@section('main_content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create Ticket</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ticketSystem.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-6">
                        <label for="title" class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" id="title" class="form-control shadow-sm" placeholder="Enter ticket title" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="email" class="form-control shadow-sm" placeholder="Enter email address" required>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea name="description" id="description" class="form-control shadow-sm" placeholder="Enter ticket description" rows="4" required></textarea>
                    </div>

                    <!-- Business -->
                    <div class="col-md-6">
                        <label for="business_id" class="form-label fw-semibold">Business</label>
                        <select name="business_id" id="business_id" class="form-control shadow-sm" required>
                            <option value="">Select a Business</option>
                            @foreach ($businesses as $business)
                                <option value="{{ $business->id }}">{{ $business->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status_id" class="form-label fw-semibold">Status</label>
                        <select name="status_id" id="status_id" class="form-control shadow-sm" required>
                            <option value="">Select a Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Priority -->
                    <div class="col-md-6">
                        <label for="priority" class="form-label fw-semibold">Priority</label>
                        <select name="priority" id="priority" class="form-control shadow-sm" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">Category</label>
                        <select name="category_id" id="category_id" class="form-control shadow-sm" required>
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-danger shadow-sm">
                        <i class="fas fa-plus-circle me-1"></i> Create Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection