@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header"><h4>{{ __('Create Promo Code') }}</h4></div>
    <div class="card-body">
        <form action="{{ route('admin.promo-codes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="code" class="form-label">{{ __('Code') }}</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="percentage" class="form-label">{{ __('Percentage (%)') }}</label>
                <input type="number" name="percentage" id="percentage" class="form-control" min="1" max="100" value="{{ old('percentage') }}" required>
                @error('percentage') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="valid_from" class="form-label">{{ __('Valid From') }}</label>
                <input type="datetime-local" name="valid_from" id="valid_from" class="form-control" value="{{ old('valid_from') }}">
                @error('valid_from') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="valid_to" class="form-label">{{ __('Valid To') }}</label>
                <input type="datetime-local" name="valid_to" id="valid_to" class="form-control" value="{{ old('valid_to') }}">
                @error('valid_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="active" class="form-label">{{ __('Status') }}</label>
                <select name="active" id="active" class="form-control">
                    <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                    <option value="0" {{ old('active', 1) == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
            <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>
</div>
@endsection
