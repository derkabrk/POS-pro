@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
    <div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
        @include('business::print.header')
        <h4 class="sale-invoice">{{ __('Sales Invoice') }}</h4>
    </div>
    @push('css')
        @include('business::pdf.css')
    @endpush
@endsection

@section('pdf_content')

    <div class="in-container">
        <div class="in-content">
            {{-- Print Header --}}

            <div class="d-flex justify-content-between align-items-center gap-3 print-logo-container">
                {{-- Left Side: Logo and Content --}}
                <div class="d-flex align-items-center gap-2 logo">
                    <img class="invoice-logo"
                        src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/default.svg') ?? '' }}"
                        alt="Logo">
                    <div>
                        <h3 class="mb-0">{{ $sale->business->companyName ?? '' }}</h3>
                    </div>
                </div>

                {{-- Right Side: Invoice --}}
                <h3 class="right-invoice mb-0 align-self-center">{{ __('INVOICE') }}</h3>
            </div>
            <div class="invoice-header-content">
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Bill To') }}</td>
                                <td class="text-end">: {{ $sale->party->name ?? 'Guest' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Mobile') }}</td>
                                <td class="text-end">: {{ $sale->business->phoneNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Address') }}</td>
                                <td class="text-end">: {{ $sale->party->phone ?? 'Guest' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row ">
                                <td class="text-end">{{ __('Sells By') }}</td>
                                <td class="text-end">: {{ $sale->user->name ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Invoice') }}</td>
                                <td class="text-end"> : {{ $sale->invoiceNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Date') }}</td>
                                <td class="text-end">: {{ formatted_date($sale->saleDate ?? '') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            @if (!$sale_returns->isEmpty())
                {{-- Sales --}}
                <div class="table-content">
                    <table class="table table-striped">
                        <thead>
                            <tr class="in-table-header">
                                <th class="head-red text-center">{{ __('SL') }}</th>
                                <th class="head-red text-start">{{ __('Item') }}</th>
                                <th class="head-black text-center">{{ __('Quantity') }}</th>
                                <th class="head-black text-end">{{ __('Unit Price') }}</th>
                                <th class="head-black text-end">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        @php
                            $subtotal = 0;
                        @endphp
                        <tbody class="in-table-body-container">
                            @foreach ($sale->details as $detail)
                                @php
                                    $productTotal = ($detail->price ?? 0) * ($detail->quantities ?? 0); // if $detail->quantities is 0 then use selas return er return_qty here
                                    $subtotal += $productTotal;
                                @endphp
                                <tr class="in-table-body">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $detail->product->productName ?? '' }}</td>
                                    <td class="text-center">{{ $detail->quantities ?? '' }}</td>
                                    <td class="text-end">
                                        {{ currency_format($detail->price ?? 0, 'icon', 2, business_currency()) }}</td>
                                    <td class="text-end">
                                        {{ currency_format($productTotal, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="in-bottom-content">
                    <div class="left-content">
                        <table class="table">
                            <tbody>
                                <tr class="in-table-row">
                                    <td class="text-start"></td>
                                </tr>
                                <tr class="in-table-row">
                                    <td class="text-start"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="right-content">
                        <table class="table">
                            <tbody>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Subtotal') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">{{ currency_format($subtotal, 'icon', 2, business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Vat') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->vat_amount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Shipping Charge') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->shipping_charge, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Discount') }}
                                        @if($sale->discount_type == 'percent')
                                            ({{ $sale->discount_percent }}%)
                                        @endif
                                    </td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->discountAmount, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($subtotal + $sale->vat_amount + $sale->discountAmount + $sale->vat_amount, 'icon', 2, business_currency()) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Sale Return --}}
                <div>
                    <table class="table table-striped pdf-table">
                        <thead>
                            <tr class="in-table-header">
                                <th class="head-red text-center">{{ __('SL') }}</th>
                                <th class="head-red text-start">{{ __('Date') }}</th>
                                <th class="head-black text-start">{{ __('Returned Item') }}</th>
                                <th class="head-black text-center">{{ __('Quantity') }}</th>
                                <th class="head-black text-end">{{ __('Total Amount') }}</th>
                            </tr>
                        </thead>
                        @php $total_return_amount = 0; @endphp
                        <tbody class="in-table-body-container">
                            @foreach ($sale_returns as $key => $return)
                                @foreach ($return->details as $detail)
                                    @php
                                        $total_return_amount += $detail->return_amount ?? 0;
                                    @endphp
                                    <tr class="in-table-body">
                                        <td class=" text-center">{{ $loop->iteration }}</td>
                                        <td class=" text-start">{{ formatted_date($return->return_date) }}</td>
                                        <td class=" text-start">{{ $detail->saleDetail->product->productName ?? '' }}</td>
                                        <td class=" text-center">{{ $detail->return_qty ?? 0 }}</td>
                                        <td class=" text-end">
                                            {{ currency_format($detail->return_amount ?? 0, 'icon', 2, business_currency()) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="in-bottom-content">
                    <h2 class="word-amount">{{ amountInWords($total_return_amount) }}</h2>
                    <div class="left-content">
                        <table class="table">
                            <tbody>
                                <tr class="in-table-row">
                                    <td class="text-start"></td>
                                </tr>
                                <tr class="in-table-row">
                                    <td class="text-start"></td>
                                </tr>
                                <tr class="in-table-row">
                                    <td class="text-start">{{ __('Paid by') }} : {{ $sale->payment_type_id != null ? $sale->payment_type->name ?? '' : $sale->paymentType }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="right-content">
                        <table class="table">
                            <tbody>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Total Return Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($total_return_amount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end total-amound">{{ __('Payable Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($sale->totalAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Paid Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->paidAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Due') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->dueAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                {{-- Sales --}}
                <div>
                    <table class="table table-striped">
                        <thead>
                            <tr class="in-table-header">
                                <th class="head-red text-center">{{ __('SL') }}</th>
                                <th class="head-red text-start">{{ __('Item') }}</th>
                                <th class="head-black text-center">{{ __('Quantity') }}</th>
                                <th class="head-black text-end">{{ __('Unit Price') }}</th>
                                <th class="head-black text-end">{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        @php $subtotal = 0; @endphp
                        <tbody class="in-table-body-container">
                            @foreach ($sale->details as $detail)
                                @php
                                    $productTotal = ($detail->price ?? 0) * ($detail->quantities ?? 0);
                                    $subtotal += $productTotal;
                                @endphp
                                <tr class="in-table-body">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $detail->product->productName ?? '' }}</td>
                                    <td class="text-center">{{ $detail->quantities ?? '' }}</td>
                                    <td class="text-end">
                                        {{ currency_format($detail->price ?? 0, 'icon', 2, business_currency()) }}</td>
                                    <td class="text-end">
                                        {{ currency_format($productTotal, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="in-bottom-content">
                    <h2 class="word-amount">{{ amountInWords($subtotal) }}</h2>
                    <div class="left-content">
                        <table class="table">
                            <tbody>
                                <tr class="in-table-row">
                                    <td class="text-start"></td>
                                </tr>
                                <tr class="in-table-row">
                                    <td class="text-start"></td>
                                </tr>
                                <tr class="in-table-row">
                                    <td class="text-start">{{ __('Paid by') }} : {{ $sale->payment_type_id != null ? $sale->payment_type->name ?? '' : $sale->paymentType }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="right-content">
                        <table class="table">
                            <tbody>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Subtotal') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">{{ currency_format($subtotal, 'icon', 2, business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Vat') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->vat_amount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Shipping Charge') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->shipping_charge, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Discount') }}
                                        @if($sale->discount_type == 'percent')
                                            ({{ $sale->discount_percent }}%)
                                        @endif
                                    </td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->discountAmount, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($sale->totalAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Paid Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->paidAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Due') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->dueAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="pdf-footer">
                <div class="in-signature-container d-flex align-items-center justify-content-between my-3 px-2">
                    <div class="in-signature left-content">
                        <hr class="in-hr">
                        <h4>{{ __('Customer Signature') }}</h4>
                    </div>
                    <div class="in-signature right-content">
                        <hr class="in-hr">
                        <h4>{{ __('Authorized Signature') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
