@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Dropshippers List</h1>
    <a href="{{ route('business.dropshippers.create') }}" class="btn btn-primary mb-3">Add New Dropshipper</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Store</th>
                <th>Phone</th>
                <th>Full Name</th>
                <th>Total Orders</th>
                <th>Delivered</th>
                <th>Returned</th>
                <th>Pending</th>
                <th>Available</th>
                <th>Paid</th>
                <th>Cashout</th>
                <th>Expires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dropshippers as $dropshipper)
            <tr>
                <td>{{ $dropshipper->id }}</td>
                <td>{{ $dropshipper->store }}</td>
                <td>{{ $dropshipper->phone }}</td>
                <td>{{ $dropshipper->full_name }}</td>
                <td>{{ $dropshipper->total_orders }}</td>
                <td>{{ $dropshipper->delivered }}</td>
                <td>{{ $dropshipper->returned }}</td>
                <td>{{ $dropshipper->pending }}</td>
                <td>{{ $dropshipper->available }}</td>
                <td>{{ $dropshipper->paid }}</td>
                <td>{{ $dropshipper->cashout }}</td>
                <td>{{ $dropshipper->expires }}</td>
                <td>
                    <a href="{{ route('business.dropshippers.edit', $dropshipper->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('business.dropshippers.destroy', $dropshipper->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this dropshipper?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
