@foreach ($stocks as $stock)
    <tr>
        <td>{{ ($stocks->currentPage() - 1) * $stocks->perPage() + $loop->iteration }}</td>
        <td class="text-start">{{ $stock->productName }}</td>
        <td class="text-start">{{ currency_format($stock->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
        @if ($stock->productStock <= $stock->alert_qty)
            <td class="text-danger text-start">{{ $stock->productStock }}</td>
        @else
            <td class="text-success text-start">{{ $stock->productStock }}</td>
        @endif
        <td class="text-start">{{ currency_format($stock->productSalePrice, 'icon', 2, business_currency()) }}</td>
        <td class="text-start">{{ currency_format($stock->productPurchasePrice * $stock->productStock, 'icon', 2, business_currency()) }}</td>
    </tr>
@endforeach
