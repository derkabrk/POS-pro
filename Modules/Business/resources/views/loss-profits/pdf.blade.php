@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
<div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
    @include('business::print.header')
    <h4 class="mt-2">{{ __('Loss Profit List') }}</h4>
</div>
@endsection

@section('pdf_content')
    <table class="styled-table">
        <thead>
            <tr class="in-table-header">
                <th class="text-start head-red">{{ __('SL') }}.</th>
                <th class="text-start head-red">{{ __('Invoice') }}</th>
                <th class="text-start head-red">{{ __('Name') }}</th>
                <th class="text-start head-red">{{ __('Total') }}</th>
                <th class="text-start head-black">{{ __('Loss/Profit') }}</th>
                <th class="text-start head-black">{{ __('Date') }}</th>
                <th class="text-start head-black">{{ __('Status') }}</th>
            </tr>
        </thead>
        <tbody class="in-table-body-container">
            @foreach ($loss_profits as $loss_profit)
                <tr class="in-table-body">
                    <td class="text-start">{{ $loop->index + 1 }}</td>
                    <td class="text-start">{{ $loss_profit->invoiceNumber }}</td>
                    <td class="text-start">{{ $loss_profit->party?->name }}</td>
                    <td class="text-start">{{ currency_format($loss_profit->totalAmount, 'icon', 2, business_currency()) }}</td>
                    <td>
                        <span
                            class="{{ $loss_profit->lossProfit < 0 ? 'bg-danger' : 'bg-success' }} text-white px-2 py-1 rounded d-inline-block">
                            {{ currency_format($loss_profit->lossProfit, 'icon', 2, business_currency()) }}
                        </span>
                    </td>
                    <td class="text-start">{{ formatted_date($loss_profit->created_at) }}</td>
                    <td class="text-start">
                        <span
                            class="{{ $loss_profit->dueAmount == 0 ? 'bg-success text-white px-2 py-1 rounded' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'bg-warning text-white px-2 py-1 rounded' : 'bg-danger text-white px-2 py-1 rounded') }}">
                            {{ $loss_profit->dueAmount == 0 ? 'Paid' : ($loss_profit->dueAmount > 0 && $loss_profit->dueAmount < $loss_profit->totalAmount ? 'Partial Paid' : 'Unpaid') }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
