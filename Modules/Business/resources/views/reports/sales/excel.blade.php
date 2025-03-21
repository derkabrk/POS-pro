<table>
    <thead>
        <tr>
            <th>{{ __('SL') }}.</th>
            <th class="text-start">{{ __('Invoice No') }}</th>
            <th class="text-start">{{ __('Party Name') }}</th>
            <th class="text-start">{{ __('Total Amount') }}</th>
            <th class="text-start">{{ __('Discount Amount') }}</th>
            <th class="text-start">{{ __('Paid Amount') }}</th>
            <th class="text-start">{{ __('Due Amount') }}</th>
            <th class="text-start">{{ __('Payment Type') }}</th>
            <th class="text-start">{{ __('Sale Date') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td class="text-start">{{ $sale->invoiceNumber }}</td>
                <td class="text-start">{{ $sale->party?->name }}</td>
                <td class="text-start">{{ currency_format($sale->totalAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ currency_format($sale->discountAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ currency_format($sale->paidAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ currency_format($sale->dueAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ $sale->paymentType }}</td>
                <td class="text-start">{{ formatted_date($sale->saleDate) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
