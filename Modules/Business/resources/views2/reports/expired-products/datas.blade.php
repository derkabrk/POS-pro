@foreach ($expired_products as $product)
    <tr>
        <td>{{ ($expired_products->currentPage() - 1) * $expired_products->perPage() + $loop->iteration }}</td>

        <td>
            <img src="{{ asset($product->productPicture ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="table-product-img">
        </td>

        <td>{{ $product->productName }}</td>
        <td>{{ $product->productCode }}</td>
        <td>{{ $product->brand->brandName ?? '' }}</td>
        <td>{{ $product->category->categoryName ?? '' }}</td>
        <td>{{ $product->unit->unitName ?? '' }}</td>
        <td>{{ currency_format($product->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
        <td>{{ currency_format($product->productSalePrice, 'icon', 2, business_currency()) }}</td>
        <td class="{{ $product->productStock <= $product->alert_qty ? 'text-danger' : 'text-success' }}">{{ $product->productStock }}</td>
        <td class="{{ $product->expire_date < now()->toDateString() ? 'text-danger' : '' }}">
            {{ formatted_date($product->expire_date) }}
        </td>

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#expire-product-report-view" class="product-view" data-bs-toggle="modal"
                            data-name="{{ $product->productName }}"
                            data-image="{{ asset($product->productPicture ?? 'assets/images/logo/upload2.jpg') }}"
                            data-code="{{ $product->productCode }}"
                            data-brand="{{ $product->brand->brandName ?? '' }}"
                            data-category="{{ $product->category->categoryName ?? '' }}"
                            data-unit="{{ $product->unit->unitName ?? '' }}"
                            data-purchase-price="{{ currency_format($product->productPurchasePrice, 'icon', 2, business_currency()) }}"
                            data-sale-price="{{ currency_format($product->productSalePrice, 'icon', 2, business_currency()) }}"
                            data-wholesale-price="{{ currency_format($product->productWholeSalePrice, 'icon', 2, business_currency()) }}"
                            data-dealer-price="{{ currency_format($product->productDealerPrice, 'icon', 2, business_currency()) }}"
                            data-stock="{{ $product->productStock }}"
                            data-expire_date="{{ formatted_date($product->expire_date) }}"
                            data-manufacturer="{{ $product->productManufacturer }}">
                            <i class="fal fa-eye"></i>
                            {{ __('View') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
