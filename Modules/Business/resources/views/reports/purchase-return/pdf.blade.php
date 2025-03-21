@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
<div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
    @include('business::print.header')
    <h4 class="mt-2">{{ __('Purchase Return Report List') }}</h4>
</div>
@endsection

@section('pdf_content')
    <table class="styled-table">
        <thead>
            <tr>
                <th>{{ __('SL') }}.</th>
                <th>{{ __('Invoice No') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Paid') }}</th>
                <th>{{ __('Return Amount') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
            <td>
                @php
                    $total_return_amount = $purchase->purchaseReturns->sum('total_return_amount');
                @endphp
            </td>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('business.sales.invoice', $purchase->id) }}" target="_blank" class="text-primary">
                        {{ $purchase->invoiceNumber }}
                    </a>
                </td>
                <td>{{ formatted_date($purchase->purchaseDate) }}</td>
                <td>{{ $purchase->party->name ?? '' }}</td>
                <td>{{ $purchase->totalAmount }}</td>
                <td>{{ $purchase->paidAmount }}</td>
                <td>{{ currency_format($total_return_amount ?? 0, 'icon', 2, business_currency()) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
