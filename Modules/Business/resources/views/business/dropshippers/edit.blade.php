@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit Dropshipper</h1>
    <form action="{{ route('business.dropshippers.update', $dropshipper->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="store" class="form-label">Store</label>
            <input type="text" class="form-control" id="store" name="store" value="{{ old('store', $dropshipper->store) }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $dropshipper->phone) }}">
        </div>
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $dropshipper->full_name) }}" required>
        </div>
        <div class="mb-3">
            <label for="total_orders" class="form-label">Total Orders</label>
            <input type="number" class="form-control" id="total_orders" name="total_orders" value="{{ old('total_orders', $dropshipper->total_orders) }}">
        </div>
        <div class="mb-3">
            <label for="delivered" class="form-label">Delivered</label>
            <input type="number" class="form-control" id="delivered" name="delivered" value="{{ old('delivered', $dropshipper->delivered) }}">
        </div>
        <div class="mb-3">
            <label for="returned" class="form-label">Returned</label>
            <input type="number" class="form-control" id="returned" name="returned" value="{{ old('returned', $dropshipper->returned) }}">
        </div>
        <div class="mb-3">
            <label for="pending" class="form-label">Pending</label>
            <input type="number" class="form-control" id="pending" name="pending" value="{{ old('pending', $dropshipper->pending) }}">
        </div>
        <div class="mb-3">
            <label for="available" class="form-label">Available</label>
            <input type="number" step="0.01" class="form-control" id="available" name="available" value="{{ old('available', $dropshipper->available) }}">
        </div>
        <div class="mb-3">
            <label for="paid" class="form-label">Paid</label>
            <input type="number" step="0.01" class="form-control" id="paid" name="paid" value="{{ old('paid', $dropshipper->paid) }}">
        </div>
        <div class="mb-3">
            <label for="cashout" class="form-label">Cashout</label>
            <input type="number" step="0.01" class="form-control" id="cashout" name="cashout" value="{{ old('cashout', $dropshipper->cashout) }}">
        </div>
        <div class="mb-3">
            <label for="expires" class="form-label">Expires</label>
            <input type="date" class="form-control" id="expires" name="expires" value="{{ old('expires', $dropshipper->expires ? $dropshipper->expires->format('Y-m-d') : '') }}">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('business.dropshippers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
