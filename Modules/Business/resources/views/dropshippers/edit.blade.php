@extends('business::layouts.master')

@section('title', 'Edit Dropshipper')

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
            <label for="expires" class="form-label">Expires</label>
            <input type="date" class="form-control" id="expires" name="expires" value="{{ old('expires', $dropshipper->expires ? $dropshipper->expires->format('Y-m-d') : '') }}">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('business.dropshippers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
