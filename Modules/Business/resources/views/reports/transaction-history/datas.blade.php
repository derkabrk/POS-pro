@foreach($transactions as $transcation)
    <tr>
        <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
        <td class="text-start"><a href="{{ route('business.collect.dues.invoice', $transcation->party_id) }}" class="text-primary" target="_blank">{{ $transcation->invoiceNumber }}</a></td>
        <td class="text-start">{{ $transcation->party?->name }}</td>
        <td class="text-start">{{ currency_format($transcation->totalDue, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($transcation->payDueAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ $transcation->payment_type_id != null ? $transcation->payment_type->name ?? '' : $transcation->paymentType }}</td>
        <td class="text-start">{{ formatted_date($transcation->paymentDate) }}</td>
    </tr>
@endforeach
