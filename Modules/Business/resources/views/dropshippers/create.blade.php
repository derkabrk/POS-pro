@extends('business::layouts.master')


@section('title', 'Add New Dropshipper')

@section('content')
<div class="container">
    <h1>Add New Dropshipper</h1>
    <form action="{{ route('business.dropshippers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="store" class="form-label">Store</label>
            <input type="text" class="form-control" id="store" name="store" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="total_orders" class="form-label">Total Orders</label>
            <input type="number" class="form-control" id="total_orders" name="total_orders" value="0">
        </div>
        <div class="mb-3">
            <label for="delivered" class="form-label">Delivered</label>
            <input type="number" class="form-control" id="delivered" name="delivered" value="0">
        </div>
        <div class="mb-3">
            <label for="returned" class="form-label">Returned</label>
            <input type="number" class="form-control" id="returned" name="returned" value="0">
        </div>
        <div class="mb-3">
            <label for="pending" class="form-label">Pending</label>
            <input type="number" class="form-control" id="pending" name="pending" value="0">
        </div>
        <div class="mb-3">
            <label for="available" class="form-label">Available</label>
            <input type="number" step="0.01" class="form-control" id="available" name="available" value="0">
        </div>
        <div class="mb-3">
            <label for="paid" class="form-label">Paid</label>
            <input type="number" step="0.01" class="form-control" id="paid" name="paid" value="0">
        </div>
        <div class="mb-3">
            <label for="cashout" class="form-label">Cashout</label>
            <input type="number" step="0.01" class="form-control" id="cashout" name="cashout" value="0">
        </div>
        <div class="mb-3">
            <label for="expires" class="form-label">Expires</label>
            <input type="date" class="form-control" id="expires" name="expires">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
