@extends('business::layouts.blank')

@section('title')
    {{ __('Subscriptions Report') }}
@endsection

@section('main_content')
    <div class="invoice-container">
        <div class="invoice-content">

            <div class="row py-2 d-flex align-items-start justify-content-between border-bottom print-container">

                <div class="col-md-6 d-flex align-items-center p-2">
                    <span class="Money-Receipt">{{ __('Subscription Report') }}</span>
                </div>


                <div class="col-md-6 d-flex justify-content-end align-items-end">
                    <div class="d-flex gap-3">
                        <a class="print-btn-2 print-btn" onclick="window.print()"><img class="w-10 h-10" src="{{ asset('assets/img/print.svg') }}">Print</a>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center gap-3 print-logo-container">
                <div class="d-flex align-items-center gap-2 logo">
                    <img class="invoice-logo" src="{{ asset(get_business_option('business-settings')['invoice_logo'] ?? 'assets/images/default.svg') ?? '' }}" alt="Logo">
                    <div>
                        <h3 class="mb-0">{{ $subscriber->business?->companyName ?? '' }}</h3>
                    </div>
                </div>
                <h3 class="right-invoice mb-0 align-self-center">{{ __('INVOICE') }}</h3>
            </div>


            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <table class="table">
                        <tbody>
                        <tr class="in-table-row">
                            <td class="text-start">{{ __('Bill To') }}</td>
                            <td class="text-start">: {{ $subscriber->business?->companyName ?? '' }}</td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start">{{ __('Mobile') }}</td>
                            <td class="text-start">:  {{ $subscriber->business?->phoneNumber ?? '' }} </td>
                        </tr>
                        <tr class="in-table-row">
                            <td class="text-start">{{ __('Address') }}</td>
                            <td class="text-start">: {{ $subscriber->business?->address ?? '' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div>
                <table class="table table-striped">
                    <thead>
                        <tr class="in-table-header">
                            <th class="head-red text-center">{{ __('SL') }}</th>
                            <th class="head-red text-center">{{ __('Business Name') }}</th>
                            <th class="head-black text-center">{{ __('Package Name') }}</th>
                            <th class="head-black text-center">{{ __('Started') }}</th>
                            <th class="head-black text-center">{{ __('End') }}</th>
                            <th class="head-black text-center">{{ __('Gateway Name') }}</th>
                        </tr>
                    </thead>

                    <tbody class="in-table-body-container">


                        <tr class="in-table-body">
                            <td class="text-center">1</td>
                            <td class="text-center">{{ $subscriber->business->companyName ?? 'N/A' }}</td>
                            <td class="text-center">{{  $subscriber->plan->subscriptionName ?? 'N/A' }}</td>
                            <td class="text-center">{{ formatted_date($subscriber->created_at) }}</td>
                            <td class="text-center">{{ $subscriber->created_at ? formatted_date($subscriber->created_at->addDays($subscriber->duration)) : '' }}</td>
                            <td class="text-center">{{ $subscriber->gateway->name ?? 'N/A' }}</td>
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

            </div>

        </div>
    </div>
@endsection
