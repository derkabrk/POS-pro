<table>
    <thead>
        <tr>
            <th class="text-start">{{ __('SL') }}.</th>
            <th class="text-start">{{ __('Product') }}</th>
            <th class="text-start">{{ __('Cost') }}</th>
            <th class="text-start">{{ __('Qty') }}</th>
            <th class="text-start">{{ __('Sale') }}</th>
            <th class="text-start">{{ __('Stock Value') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stocks as $stock)
        <tr>
            <td class="text-start">{{ $loop->index+1 }}</td>
            <td class="text-start">{{ $stock->productName }}</td>
            <td class="text-start">{{ currency_format($stock->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
            <td class="text-start">{{ $stock->productStock }}</td>
            <td class="text-start">{{ currency_format($stock->productSalePrice, 'icon', 2, business_currency()) }}</td>
            <td class="text-start">{{ currency_format($stock->productSalePrice * $stock->productStock, 'icon', 2, business_currency()) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
