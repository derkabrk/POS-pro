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
                    <span class="Money-Receipt">{{ __('Money Receipt') }}</span>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-end">
                    <div class="d-flex gap-3 ">

                        <form action="{{ route('business.collect.dues.mail', $party->id) }}" method="POST"
                            class="ajaxform_instant_reload">
                            @csrf
                            <button type="submit" class="btn  custom-print-btn"><img class="w-10 h-10"
                                    src="{{ asset('assets/img/email.svg') }}"><span class="pl-1">Email</span> </button>
                        </form>

                        <a href="{{ route('business.collect.dues.pdf', ['due_id' => $party->id]) }}"
                            class="pdf-btn print-btn">
                            <img class="w-10 h-10" src="{{ asset('assets/img/pdf.svg') }}">
                            PDF</a>

                        <a class="print-btn-2 print-btn" onclick="window.print()"><img class="w-10 h-10"
                                src="{{ asset('assets/img/print.svg') }}">{{ __('Print') }}</a>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center gap-3 print-logo-container">
                <!-- Left Side: Logo and Content -->
                <div class="d-flex align-items-center gap-2 logo">
                    <img class="invoice-logo"
                        src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/default.svg') ?? '' }}"
                        alt="Logo">
                    <div>
                        <div>
                            <h3 class="mb-0">{{ auth()->user()->name ?? '' }}</h3>
                        </div>
                        <span class="text-start">{{ __('Mobile') }}</span>
                        <span class="text-start">: {{ auth()->user()->phone ?? '' }}</span>
                    </div>
                </div>

                <!-- Right Side: Invoice -->
                <h3 class="right-invoice mb-0 align-self-center ">{{ __('MONEY RECEIPT') }}</h3>
            </div>
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Bill To') }}</td>
                                <td class="text-start">: {{ $party->name ?? 'Guest' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{ __('Mobile') }}</td>
                                <td class="text-start">: {{ $party->phone ?? 'Guest' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Receipt') }}</td>
                                <td class="text-start ">: {{ $party->dueCollect->invoiceNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Date') }}</td>
                                <td class="text-start">: {{ formatted_date($party->dueCollect->paymentDate ?? '') }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start ">{{ __('Collected By') }}</td>
                                <td class="text-start">: {{ $party->dueCollect->business->companyName ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-start">{{  $party->dueCollect->business->vat_name ?? '' }}</td>
                                @if(!empty($party->dueCollect->business->vat_name))
                                    <td class="text-start"> : {{ $party->dueCollect->business->vat_no ?? '' }}</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr class="in-table-header">
                            <th class="head-red text-start">{{ __('SL') }}</th>
                            <th class="head-red text-start">{{ __('Total Due') }}</th>
                            <th class="head-black text-start">{{ __('Payment Amount') }}</th>
                            <th class="head-black text-start">{{ __('Remaining Due') }}</th>
                        </tr>
                    </thead>
                    <tbody class="in-table-body-container">
                            <tr class="in-table-body">
                                <td class="text-start">1</td>
                                <td class="text-start">
                                    {{ currency_format($due_collect->totalDue ?? 0, 'icon', 2, business_currency()) }}</td>
                                <td class="text-start">
                                    {{ currency_format($due_collect->payDueAmount ?? 0, 'icon', 2, business_currency()) }}</td>
                                <td class="text-start">
                                    {{ currency_format($due_collect->dueAmountAfterPay ?? 0, 'icon', 2, business_currency()) }}
                                </td>
                            </tr>
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
                                <td class="text-end">{{ __('Payable Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($due_collect->totalDue ?? 0, 'icon', 2, business_currency()) }}</td>
                                </td>
                            </tr>

                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Received Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($due_collect->payDueAmount ?? 0, 'icon', 2, business_currency()) }}</td>
                                </td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Due Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">
                                    {{ currency_format($due_collect->dueAmountAfterPay ?? 0, 'icon', 2, business_currency()) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pdf-footer">
                <div class="in-signature-container d-flex align-items-center justify-content-between">
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
