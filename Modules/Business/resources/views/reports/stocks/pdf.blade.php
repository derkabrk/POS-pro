@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
<div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
    @include('business::print.header')
    <h4 class="mt-2">{{ __('Stock Report List') }}</h4>
</div>
@endsection

@section('pdf_content')
    <table class="styled-table">
        <thead>
            <tr>
                <th>{{ __('SL') }}.</th>
                <th class="text-start">{{ __('Product') }}</th>
                <th class="text-start">{{ __('Cost') }}</th>
                <th class="text-start">{{ __('Qty') }}</th>
                <th class="text-start">{{ __('Sale') }}</th>
                <th class="text-start">{{ __('Stock Value') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td class="text-start">{{ $stock->productName }}</td>
                <td class="text-start">{{ currency_format($stock->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ $stock->productStock }}</td>
                <td class="text-start">{{ currency_format($stock->productSalePrice, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ currency_format($stock->productSalePrice * $stock->productStock, 'icon', 2, business_currency()) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
