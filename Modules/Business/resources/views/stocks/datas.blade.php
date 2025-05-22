@foreach ($stocks as $stock)
<tr>
    <td>{{ ($stocks->currentPage() - 1) * $stocks->perPage() + $loop->iteration }}</td>
    <td class="text-start fw-semibold">
        <span class="d-block">{{ $stock->productName }}</span>
        <small class="text-muted">{{ $stock->productCode }}</small>
    </td>
    <td class="text-start">{{ currency_format($stock->productPurchasePrice, currency : business_currency()) }}</td>
    <td class="text-start">
        <span class="badge {{ $stock->productStock <= $stock->alert_qty ? 'bg-danger' : 'bg-success' }} px-2 py-1">
            {{ $stock->productStock }}
        </span>
    </td>
    <td class="text-center">{{ currency_format($stock->productSalePrice, currency : business_currency()) }}</td>
    <td class="text-end fw-semibold">{{ currency_format($stock->productPurchasePrice * $stock->productStock, currency : business_currency()) }}</td>
</tr>
@endforeach
<tr class="table-secondary">
    <td colspan="5" class="text-end fw-bold">{{ __('Total Stock Value:') }}</td>
    <td class="text-end fw-bold">{{ currency_format($total_stock_value, currency : business_currency()) }}</td>
</tr>
