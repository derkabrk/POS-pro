@extends('layouts.master')

@section('title', 'Create Ticket')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Create New Ticket</h4>
                    <a href="{{ route('admin.ticketSystem.index') }}" class="add-order-btn rounded-2">
                        <i class="far fa-list me-1"></i> View Tickets
                    </a>
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('admin.ticketSystem.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <!-- Title -->
                            <div class="col-lg-6 mb-2">
                                <label for="title" class="form-label fw-bold">Title</label>
                                <input type="text" name="title" id="title" class="form-control shadow-sm" placeholder="Enter ticket title" required>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6 mb-2">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" name="email" id="email" class="form-control shadow-sm" placeholder="Enter email address" required>
                            </div>

                            <!-- Description -->
                            <div class="col-lg-12 mb-2">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea name="description" id="description" class="form-control shadow-sm" placeholder="Enter ticket description" rows="4" required></textarea>
                            </div>

                            <!-- Business -->
                            <div class="col-lg-6 mb-2">
                                <label for="business_id" class="form-label fw-bold">Business</label>
                                <select name="business_id" id="business_id" class="form-control shadow-sm" required>
                                    <option value="">Select a Business</option>
                                    @foreach ($businesses as $business)
                                        <option value="{{ $business->id }}">{{ $business->companyName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-6 mb-2">
                                <label for="status_id" class="form-label fw-bold">Status</label>
                                <select name="status_id" id="status_id" class="form-control shadow-sm" required>
                                    <option value="">Select a Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Priority -->
                            <div class="col-lg-6 mb-2">
                                <label for="priority" class="form-label fw-bold">Priority</label>
                                <select name="priority" id="priority" class="form-control shadow-sm" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="col-lg-6 mb-2">
                                <label for="category_id" class="form-label fw-bold">Category</label>
                                <select name="category_id" id="category_id" class="form-control shadow-sm" required>
                                    <option value="">Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Assign To -->
                            <div class="col-lg-6 mb-2">
                                <label for="assign_to" class="form-label fw-bold">Assign To</label>
                                <select name="assign_to" id="assign_to" class="form-control shadow-sm">
                                    <option value="">Select a User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="button-group text-center mt-5">
                            <button type="reset" class="theme-btn border-btn m-2">Cancel</button>
                            <button type="submit" class="theme-btn m-2 submit-btn">
                                <i class="fas fa-plus-circle me-1"></i> Create Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection