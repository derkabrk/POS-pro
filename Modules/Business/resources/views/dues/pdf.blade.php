@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
    <div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
        @include('business::print.header')
        <h4 class="mt-2">{{ __('Due Pdf') }}</h4>
    </div>

    @push('css')
        @include('business::pdf.css')
    @endpush
@endsection

@section('pdf_content')
    <div class="in-container">
        <div class="in-content">
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
            <div class="invoice-header-content">
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Bill To') }}</td>
                                <td class="text-end">: {{ $party->name ?? 'Guest' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Mobile') }}</td>
                                <td class="text-end">: {{ $party->phone ?? 'Guest' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table class="table">
                        <tbody>
                            <tr class="in-table-row ">
                                <td class="text-end">{{ __('Receipt') }}</td>
                                <td class="text-end">: {{ $party->dueCollect->invoiceNumber ?? '' }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Date') }}</td>
                                <td class="text-end"> : {{ formatted_date($party->dueCollect->paymentDate ?? '') }}</td>
                            </tr>
                            <tr class="in-table-row">
                                <td class="text-end">{{ __('Collected By') }}</td>
                                <td class="text-end">: {{ $party->dueCollect->business->companyName ?? '' }}</td>
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
                        @php
                            $total_due = 0;
                            $total_pay_amount = 0;
                            $total_due_after_pay = 0;
                        @endphp
                        @foreach ($due_collects as $collect)
                            @php
                                $total_due += $collect->totalDue;
                                $total_pay_amount += $collect->payDueAmount;
                                $total_due_after_pay += $collect->dueAmountAfterPay;
                            @endphp
                            <tr class="in-table-body">
                                <td class="text-start">{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    {{ currency_format($collect->totalDue ?? 0, 'icon', 2, business_currency()) }}</td>
                                <td class="text-start">
                                    {{ currency_format($collect->payDueAmount ?? 0, 'icon', 2, business_currency()) }}</td>
                                <td class="text-start">
                                    {{ currency_format($collect->dueAmountAfterPay ?? 0, 'icon', 2, business_currency()) }}
                                </td>
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
                                <td class="text-end">{{ __('Payable Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">{{ $total_due }}</td>
                            </tr>

                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Received Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">{{ $total_pay_amount }}</td>
                            </tr>
                            <tr class="in-table-row-bottom">
                                <td class="text-end">{{ __('Due Amount') }}</td>
                                <td class="text-end">:</td>
                                <td class="text-end">{{ $total_due_after_pay }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pdf-footer">
                <div class="in-signature-container d-flex align-items-center justify-content-between">
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
