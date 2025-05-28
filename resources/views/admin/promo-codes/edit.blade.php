@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header"><h4>Edit Promo Code</h4></div>
    <div class="card-body">
        <form action="{{ route('admin.promo-codes.update', $promoCode) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="code" class="form-label">Code</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $promoCode->code) }}" required>
                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="percentage" class="form-label">Percentage (%)</label>
                <input type="number" name="percentage" id="percentage" class="form-control" min="1" max="100" value="{{ old('percentage', $promoCode->percentage) }}" required>
                @error('percentage') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="valid_from" class="form-label">Valid From</label>
                <input type="datetime-local" name="valid_from" id="valid_from" class="form-control" value="{{ old('valid_from', $promoCode->valid_from ? date('Y-m-d\TH:i', strtotime($promoCode->valid_from)) : '') }}">
                @error('valid_from') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="valid_to" class="form-label">Valid To</label>
                <input type="datetime-local" name="valid_to" id="valid_to" class="form-control" value="{{ old('valid_to', $promoCode->valid_to ? date('Y-m-d\TH:i', strtotime($promoCode->valid_to)) : '') }}">
                @error('valid_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="active" class="form-label">Status</label>
                <select name="active" id="active" class="form-control">
                    <option value="1" {{ old('active', $promoCode->active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('active', $promoCode->active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
