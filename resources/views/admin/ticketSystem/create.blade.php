@extends('layouts.master')

@section('title', 'Create Ticket')

@section('content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>{{ __('Create New Ticket') }}</h4>
                    <a href="{{ route('admin.ticketSystem.index') }}" class="add-order-btn rounded-2">
                        <i class="far fa-list me-1"></i> {{ __('View Tickets') }}
                    </a>
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('admin.ticketSystem.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <!-- Title -->
                            <div class="col-lg-6 mb-2">
                                <label for="title" class="form-label fw-bold">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" class="form-control shadow-sm" placeholder="{{ __('Enter ticket title') }}" required>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6 mb-2">
                                <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control shadow-sm" placeholder="{{ __('Enter email address') }}" required>
                            </div>

                            <!-- Description -->
                            <div class="col-lg-12 mb-2">
                                <label for="description" class="form-label fw-bold">{{ __('Description') }}</label>
                                <textarea name="description" id="description" class="form-control shadow-sm" placeholder="{{ __('Enter ticket description') }}" rows="4" required></textarea>
                            </div>

                            <!-- Business -->
                            <div class="col-lg-6 mb-2">
                                <label for="business_id" class="form-label fw-bold">{{ __('Business') }}</label>
                                <select name="business_id" id="business_id" class="form-control shadow-sm" required>
                                    <option value="">{{ __('Select a Business') }}</option>
                                    @foreach ($businesses as $business)
                                        <option value="{{ $business->id }}">{{ $business->companyName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-6 mb-2">
                                <label for="status_id" class="form-label fw-bold">{{ __('Status') }}</label>
                                <select name="status_id" id="status_id" class="form-control shadow-sm" required>
                                    <option value="">{{ __('Select a Status') }}</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Priority -->
                            <div class="col-lg-6 mb-2">
                                <label for="priority" class="form-label fw-bold">{{ __('Priority') }}</label>
                                <select name="priority" id="priority" class="form-control shadow-sm" required>
                                    <option value="Low">{{ __('Low') }}</option>
                                    <option value="Medium">{{ __('Medium') }}</option>
                                    <option value="High">{{ __('High') }}</option>
                                </select>
                            </div>

                            <!-- Category -->
                            <div class="col-lg-6 mb-2">
                                <label for="category_id" class="form-label fw-bold">{{ __('Category') }}</label>
                                <select name="category_id" id="category_id" class="form-control shadow-sm" required>
                                    <option value="">{{ __('Select a Category') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-1"></i> {{ __('Create Ticket') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection