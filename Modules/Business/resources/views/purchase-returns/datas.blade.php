@foreach($purchases as $purchase)
        @php
            $total_return_amount = $purchase->purchaseReturns->sum('total_return_amount');
        @endphp
    <tr>
        <td>{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
        <td>
            <a href="{{ route('business.purchases.invoice', $purchase->id) }}" target="_blank" class="text-primary">
                {{ $purchase->invoiceNumber }}
            </a>
        </td>
        <td>{{ formatted_date($purchase->purchaseDate) }}</td>
        <td>{{ $purchase->party->name ?? '' }}</td>
        <td>{{ currency_format($purchase->totalAmount , 'icon', 2, business_currency()) }}</td>
        <td>{{ currency_format($purchase->paidAmount, 'icon', 2, business_currency()) }}</td>
        <td>{{ currency_format($total_return_amount ?? 0, 'icon', 2, business_currency()) }}</td>
    </tr>
@endforeach
