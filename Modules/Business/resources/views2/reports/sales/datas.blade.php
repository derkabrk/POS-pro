@foreach($sales as $sale)
    <tr>
        <td>{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $sale->invoiceNumber }}</td>
        <td class="text-start">{{ $sale->party?->name }}</td>
        <td class="text-start">{{ currency_format($sale->totalAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($sale->discountAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($sale->paidAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($sale->dueAmount, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ $sale->payment_type_id != null ? $sale->payment_type->name ?? '' : $sale->paymentType }}</td>
        <td class="text-start">{{ formatted_date($sale->saleDate) }}</td>
    </tr>
@endforeach
