<table>
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
                <td class="text-start">{{ formatted_date($income_report->incomeDate) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
