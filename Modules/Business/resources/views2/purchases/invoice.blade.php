@extends('business::layouts.blank')

@section('title')
    {{ __('Invoice') }}
@endsection

@section('main_content')
    <div class="invoice-container">
        <div class="invoice-content position-relative">
            <div class="row py-2 d-flex align-items-start justify-content-between border-bottom print-container">

                <div class="col-md-6 d-flex align-items-center p-2">
                    <span class="Money-Receipt">{{ __('Purchase Invoice') }}</span>
                </div>

                <div class="col-md-6 d-flex justify-content-end align-items-end">
                    <div class="d-flex gap-3 ">
                        <form action="{{ route('business.purchases.mail', ['purchase_id' => $purchase->id]) }}" method="POST"
                            class="ajaxform_instant_reload">
                            @csrf
                            <button type="submit" class="btn  custom-print-btn"><img class="w-10 h-10"
                                    src="{{ asset('assets/img/email.svg') }}"><span class="pl-1">Email</span> </button>
                        </form>
                        <a href="{{ route('business.purchases.pdf', ['purchase_id' => $purchase->id]) }}"
                            class="pdf-btn print-btn">
                            <img class="w-10 h-10" src="{{ asset('assets/img/pdf.svg') }}">
                            PDF</a>
                        <a class="print-btn-2 print-btn" onclick="window.print()"><img class="w-10 h-10"
                                src="{{ asset('assets/img/print.svg') }}">{{ __('Print') }}</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3 print-logo-container">
                {{-- Left Side: Logo and Content --}}
                <div class="d-flex align-items-center gap-2 logo">
                    <img class="invoice-logo"
                        src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/default.svg') ?? '' }}">
                    <div>
                        <h3>{{ $purchase->business->companyName ?? '' }}</h3>
                        <p>{{ __('Mobile') }}: {{ $purchase->business->phoneNumber ?? '' }}</p>
                    </div>
                </div>

                {{-- Right Side: Invoice --}}
                <h3 class="right-invoice ">{{ __('INVOICE') }}</h3>
            </div>

            <div class="d-flex align-items-start justify-content-between mt-3">
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Supplier Name') }}</td>
                                <td class="text-start ">: {{ $purchase->party->name ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Mobile') }}</td>
                                <td class="text-start">: {{ $purchase->party->phone ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Sells By') }}</td>
                                <td class="text-start ">: {{ $purchase->user->name ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Invoice') }}</td>
                                <td class="text-start">: {{ $purchase->invoiceNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Date') }}</td>
                                <td class="text-start">: {{ formatted_date($purchase->purchaseDate ?? '') }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{  $purchase->business->vat_name ?? '' }}</td>
                                @if(!empty($purchase->business->vat_name))
                                    <td class="text-start"> : {{ $purchase->business->vat_no ?? '' }}</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if (!$purchase_returns->isEmpty())
                {{-- purchases --}}
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
                        @php
                            $subtotal = 0;
                        @endphp
                        <tbody class="in-table-body-container">
                            @foreach ($purchase->details as $detail)
                                @php
                                    $productTotal = ($detail->productPurchasePrice ?? 0) * ($detail->quantities ?? 0);
                                    $subtotal += $productTotal;
                                @endphp
                                <tr class="in-table-body">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $detail->product->productName ?? '' }}</td>
                                    <td class="text-center">{{ $detail->quantities ?? '' }}</td>
                                    <td class="text-end">
                                        {{ currency_format($detail->productPurchasePrice ?? 0, 'icon', 2, business_currency()) }}
                                    </td>
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
                                        {{ currency_format($purchase->vat_amount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Shipping Charge') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->shipping_charge, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Discount') }}
                                        @if($purchase->discount_type == 'percent')
                                            ({{ $purchase->discount_percent }}%)
                                        @endif
                                    </td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->discountAmount + $total_discount, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($subtotal + $purchase->vat_amount - ($purchase->discountAmount + $total_discount) + $purchase->shipping_charge, 'icon', 2, business_currency()) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- purchase Return --}}
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
                            @foreach ($purchase_returns as $key => $return)
                                @foreach ($return->details as $detail)
                                    @php
                                        $total_return_amount += $detail->return_amount ?? 0;
                                    @endphp
                                    <tr class="in-table-body">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ formatted_date($return->return_date) }}</td>
                                        <td class="text-start">{{ $detail->purchaseDetail->product->productName ?? '' }}
                                        </td>
                                        <td class="text-center">{{ $detail->return_qty ?? 0 }}</td>
                                        <td class="text-end">
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
                                    <td class="text-start">{{ __('Paid by') }} : {{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}</td>
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
                                        {{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Paid Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Due') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->dueAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                {{-- purchases --}}
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
                            @foreach ($purchase->details as $detail)
                                @php
                                    $productTotal = ($detail->productPurchasePrice ?? 0) * ($detail->quantities ?? 0);
                                    $subtotal += $productTotal;
                                @endphp
                                <tr class="in-table-body">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $detail->product->productName ?? '' }}</td>
                                    <td class="text-center">{{ $detail->quantities ?? '' }}</td>
                                    <td class="text-end">
                                        {{ currency_format($detail->productPurchasePrice ?? 0, 'icon', 2, business_currency()) }}
                                    </td>
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
                                    <td class="text-start">{{ __('Paid by') }} : {{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}</td>
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
                                        {{ currency_format($purchase->vat_amount, 'icon', 2, business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Shipping Charge') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->shipping_charge, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Discount') }}
                                        @if($purchase->discount_type == 'percent')
                                            ({{ $purchase->discount_percent }}%)
                                        @endif
                                    </td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->discountAmount, currency:business_currency()) }}
                                    </td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end total-amound">{{ __('Total Amount') }}</td>
                                    <td class="text-end total-amound">:</td>
                                    <td class="text-end total-amound">
                                        {{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Paid Amount') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                                <tr class="in-table-row-bottom">
                                    <td class="text-end">{{ __('Due') }}</td>
                                    <td class="text-end">:</td>
                                    <td class="text-end">
                                        {{ currency_format($purchase->dueAmount, 'icon', 2, business_currency()) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif


            <div class="pdf-footer">
                <div class="in-signature-container d-flex align-items-center justify-content-between ">
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
