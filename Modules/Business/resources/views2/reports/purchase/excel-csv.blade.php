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
        @foreach ($purchases as $purchase)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td class="text-start">{{ $purchase->invoiceNumber }}</td>
                <td class="text-start">{{ $purchase->party?->name }}</td>
                <td class="text-start">{{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ currency_format($purchase->discountAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ currency_format($purchase->dueAmount, 'icon', 2, business_currency()) }}</td>
                <td class="text-start">{{ $purchase->paymentType }}</td>
                <td class="text-start">{{ formatted_date($purchase->purchaseDate) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
