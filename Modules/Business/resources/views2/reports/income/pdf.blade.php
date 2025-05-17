@extends('business::layouts.pdf.pdf_layout')

@section('pdf_title')
<div class="table-header justify-content-center border-0 d-none d-block d-print-block  text-center">
    @include('business::print.header')
    <h4 class="mt-2">{{ __('Income Report List') }}</h4>
</div>
@endsection

@section('pdf_content')
    <table class="styled-table">
        <thead>
            <tr>
                <th>{{ __('SL') }}.</th>
                <th class="text-start">{{ __('Amount') }}</th>
                <th class="text-start">{{ __('Category') }}</th>
                <th class="text-start">{{ __('Income For') }}</th>
                <th class="text-start">{{ __('Payment Type') }}</th>
                <th class="text-start">{{ __('Reference Number') }}</th>
                <th class="text-start">{{ __('Income Date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($income_reports as $income_report)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td class="text-start">{{ currency_format($income_report->amount, 'icon', 2, business_currency()) }}</td>
                    <td class="text-start">{{ $income_report->category->categoryName }}</td>
                    <td class="text-start">{{ $income_report->incomeFor }}</td>
                    <td class="text-start">{{ $income_report->paymentType }}</td>
                    <td class="text-start">{{ $income_report->referenceNo }}</td>
                    <td class="text-start">{{ formatted_date($income_report->incomeDate, 'icon', 2, business_currency()) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
