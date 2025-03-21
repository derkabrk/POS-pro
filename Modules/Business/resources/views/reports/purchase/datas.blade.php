@foreach($purchases as $purchase)
    <tr>
        <td>{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $purchase->invoiceNumber }}</td>
        <td class="text-start">{{ $purchase->party?->name }}</td>
        <td class="text-start">{{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($purchase->discountAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($purchase->dueAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ $purchase->payment_type_id != null ? $purchase->payment_type->name ?? '' : $purchase->paymentType }}</td>
        <td class="text-start">{{ formatted_date($purchase->purchaseDate) }}</td>
    </tr>
@endforeach
