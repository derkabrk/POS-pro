@foreach ($expired_products as $product)
    <tr class="admin-table-row">
        <td class="admin-table-cell">{{ ($expired_products->currentPage() - 1) * $expired_products->perPage() + $loop->iteration }}</td>

        <td class="admin-table-cell">
            <img src="{{ asset($product->productPicture ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="admin-table-img">
        </td>

        <td class="admin-table-cell">{{ $product->productName }}</td>
        <td class="admin-table-cell">{{ $product->productCode }}</td>
        <td class="admin-table-cell">{{ $product->brand->brandName ?? '' }}</td>
        <td class="admin-table-cell">{{ $product->category->categoryName ?? '' }}</td>
        <td class="admin-table-cell">{{ $product->unit->unitName ?? '' }}</td>
        <td class="admin-table-cell">{{ currency_format($product->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
        <td class="admin-table-cell">{{ currency_format($product->productSalePrice, 'icon', 2, business_currency()) }}</td>
        <td class="admin-table-cell {{ $product->productStock <= $product->alert_qty ? 'text-danger' : 'text-success' }}">{{ $product->productStock }}</td>
        <td class="admin-table-cell">{{ formatted_date($product->expire_date ?? '') }}</td>
        <td class="admin-table-cell print-d-none">
            <div class="dropdown admin-table-action">
                <button type="button" class="admin-action-btn" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#product-view" class="product-view admin-action-link" data-bs-toggle="modal"
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
                            data-low-stock="{{ $product->alert_qty }}"
                            data-expire-date="{{ formatted_date($product->expire_date) }}"
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
