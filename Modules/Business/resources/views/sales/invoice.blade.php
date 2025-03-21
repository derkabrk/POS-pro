@extends('business::layouts.blank')

@section('title')
    {{ __('Invoice') }}
@endsection

@section('main_content')
    <div class="invoice-container">
        <div class="invoice-content">
            {{-- Print Header --}}

            <div class="row py-2 d-flex align-items-start justify-content-between border-bottom print-container">

                <div class="col-md-6 d-flex align-items-center p-2">
                    <span class="Money-Receipt">{{ __('Sales Invoice') }}</span>
                </div>

                <div class="col-md-6 d-flex justify-content-end align-items-end">
                    <div class="d-flex gap-3">

                        <form action="{{ route('business.sales.mail', ['sale_id' => $sale->id]) }}" method="POST" class="ajaxform_instant_reload ">
                            @csrf

                            <button type="submit" class="btn  custom-print-btn"><img class="w-10 h-10" src="{{ asset('assets/img/email.svg') }}"><span class="text-white pl-1">Email</span>
                            </button>
                        </form>
                        <a class="pdf-btn print-btn" href="{{ route('business.sales.pdf', ['sale_id' => $sale->id]) }}">
                            <img class="w-10 h-10" src="{{ asset('assets/img/pdf.svg') }}">
                            PDF
                        </a>
                        <a class="print-btn-2 print-btn" onclick="window.print()"><img class="w-10 h-10" src="{{ asset('assets/img/print.svg') }}">Print</a>
                    </div>
                </div>
            </div>

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
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Bill To') }}</td>
                                <td class="text-start">: {{ $sale->party->name ?? 'Guest' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Mobile') }}</td>
                                <td class="text-start">: {{ $sale->business->phoneNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Address') }}</td>
                                <td class="text-start">: {{ $sale->party->phone ?? 'Guest' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Sells By') }}</td>
                                <td class="text-start">: {{ $sale->user->name ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Invoice') }}</td>
                                <td class="text-start"> : {{ $sale->invoiceNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Date') }}</td>
                                <td class="text-start">: {{ formatted_date($sale->saleDate ?? '') }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{  $sale->business->vat_name ?? '' }}</td>
                                @if(!empty($sale->business->vat_name))
                                <td class="text-start"> : {{ $sale->business->vat_no ?? '' }}</td>
                                @endif
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
                <div class="d-flex align-items-center justify-content-between position-relative">
                    <div>
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
                    <div>
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
                                        {{ currency_format(($sale->discountAmount + $total_discount), currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($subtotal + $sale->vat_amount - ($sale->discountAmount + $total_discount) + $sale->shipping_charge, 'icon', 2, business_currency()) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Sale Return --}}
                <div>
                    <table class="table table-striped">
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
                <div class="d-flex align-items-center justify-content-between position-relative">
                     <h2 class="word-amount">{{ amountInWords($total_return_amount) }}</h2>
                    <div>
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
                    <div>
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

                <div class="d-flex align-items-center justify-content-between position-relative">
                    <h2 class="word-amount">{{ amountInWords($subtotal) }}</h2>
                    <div>
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
                    <div>
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
                                        {{ currency_format($sale->vat_amount, 'icon', 2, business_currency()) }}
                                    </td>
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
                                        {{ currency_format($sale->totalAmount, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Paid Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->paidAmount, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Due') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($sale->dueAmount, currency:business_currency()) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="pdf-footer">
                <div class="in-signature-container d-flex align-items-center justify-content-between my-3 px-2">
                    <div class="in-signature">
                        <hr class="in-hr">
                        <h4>{{ __('Customer Signature') }}</h4>
                    </div>
                    <div class="in-signature">
                        <hr class="in-hr">
                        <h4>{{ __('Authorized Signature') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
