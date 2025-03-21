<table>
    <thead>
        <tr>
            <th>{{ __('SL') }}.</th>
            <th>{{ __('Invoice Number') }}</th>
            <th>{{ __('Party Name') }}</th>
            <th>{{ __('Total Due') }}</th>
            <th>{{ __('Pay Due Amount') }}</th>
            <th>{{ __('Payment Type') }}</th>
            <th>{{ __('Payment Date') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transcations as $transcation)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $transcation->invoiceNumber }}</td>
            <td>{{ $transcation->party?->name }}</td>
            <td>{{ currency_format($transcation->totalDue, 'icon', 2, business_currency()) }}</td>
            <td>{{ currency_format($transcation->payDueAmount, 'icon', 2, business_currency()) }}</td>
            <td>{{ $transcation->paymentType }}</td>
            <td>{{ formatted_date($transcation->paymentDate) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
