@extends('business::layouts.master')

@section('title', 'Sale Details')

@section('main_content')
    <div class="container">
        <h3>Sale Details</h3>
        <p><strong>Invoice No:</strong> {{ $sale->invoiceNumber }}</p>
        <p><strong>Customer:</strong> {{ $sale->party->name ?? 'N/A' }}</p>
        <p><strong>Payment Type:</strong> {{ $sale->payment_type->name ?? 'N/A' }}</p>
        <p><strong>Total Amount:</strong> {{ $sale->totalAmount }}</p>
    </div>
@endsection
