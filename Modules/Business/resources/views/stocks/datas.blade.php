@foreach ($stocks as $stock)
    <tr>
        <td>{{ ($stocks->currentPage() - 1) * $stocks->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $stock->productName }}</td>
        <td class="text-start">{{ currency_format($stock->productPurchasePrice, currency : business_currency()) }}</td>
        <td class="{{ $stock->productStock <= $stock->alert_qty ? 'text-danger' : 'text-success' }} text-start">
            {{ $stock->productStock }}
        </td>
        <td class="text-center">{{ currency_format($stock->productSalePrice, currency : business_currency()) }}</td>
        <td class="text-end">{{ currency_format($stock->productPurchasePrice * $stock->productStock, currency : business_currency()) }}</td>
    </tr>
@endforeach
<tr>
    <td colspan="5" class="text-end"><strong>{{ __('Total Stock Value:') }}</strong></td>
    <td class="text-end"><strong>{{ currency_format($total_stock_value, currency : business_currency()) }}</strong></td>
</tr>
