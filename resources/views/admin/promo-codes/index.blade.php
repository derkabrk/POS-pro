@extends('layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Promo Codes</h4>
    <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-primary">Create Promo Code</a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Percentage</th>
            <th>Valid From</th>
            <th>Valid To</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($promoCodes as $promoCode)
            <tr>
                <td>{{ $promoCode->id }}</td>
                <td>{{ $promoCode->code }}</td>
                <td>{{ $promoCode->percentage }}%</td>
                <td>{{ $promoCode->valid_from }}</td>
                <td>{{ $promoCode->valid_to }}</td>
                <td>
                    @if($promoCode->active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.promo-codes.edit', $promoCode) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.promo-codes.destroy', $promoCode) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this promo code?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $promoCodes->links() }}
@endsection
