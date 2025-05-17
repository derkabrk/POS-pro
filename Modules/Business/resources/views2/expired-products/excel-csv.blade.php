<table>
    <thead>
        <tr>
            <th>{{ __('SL') }}. </th>
            <th>{{ __('Image') }} </th>
            <th>{{ __('Product Name') }} </th>
            <th>{{ __('Code') }} </th>
            <th>{{ __('Brand') }} </th>
            <th>{{ __('Category') }} </th>
            <th>{{ __('Unit') }} </th>
            <th>{{ __('Purchase price') }}</th>
            <th>{{ __('Sale price') }}</th>
            <th>{{ __('Stock') }}</th>
            <th>{{ __('Expired Date') }}</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($expired_products as $product)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td><img src="{{ asset($product->productPicture ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="table-product-img"></td>
                <td>{{ $product->productName }}</td>
                <td>{{ $product->productCode }}</td>
                <td>{{ $product->brand->brandName ?? '' }}</td>
                <td>{{ $product->category->categoryName ?? '' }}</td>
                <td>{{ $product->unit->unitName ?? '' }}</td>
                <td>{{ currency_format($product->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
                <td>{{ currency_format($product->productSalePrice, 'icon', 2, business_currency()) }}</td>
                <td>{{ $product->productStock }}</td>
                <td>{{ formatted_date($product->expire_date ?? '') }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
