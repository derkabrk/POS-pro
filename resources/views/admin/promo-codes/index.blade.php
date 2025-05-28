@extends('layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>{{ __('Promo Codes') }}</h4>
    <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-primary">{{ __('Create Promo Code') }}</a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Code') }}</th>
            <th>{{ __('Percentage') }}</th>
            <th>{{ __('Valid From') }}</th>
            <th>{{ __('Valid To') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
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
                        <span class="badge bg-success">{{ __('Active') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.promo-codes.edit', $promoCode) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                    <form action="{{ route('admin.promo-codes.destroy', $promoCode) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Delete this promo code?') }}')">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $promoCodes->links() }}
@endsection
