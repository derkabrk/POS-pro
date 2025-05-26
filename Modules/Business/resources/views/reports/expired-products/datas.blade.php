@foreach ($expired_products as $product)
    <tr>
        <td class="align-middle text-center">{{ ($expired_products->currentPage() - 1) * $expired_products->perPage() + $loop->iteration }}</td>
        <td class="align-middle text-center">
            <img src="{{ asset($product->productPicture ?? 'assets/images/logo/upload2.jpg') }}" alt="Img" class="table-product-img rounded shadow-sm border" style="width: 48px; height: 48px; object-fit: cover;">
        </td>
        <td class="align-middle fw-semibold">{{ $product->productName }}</td>
        <td class="align-middle">{{ $product->productCode }}</td>
        <td class="align-middle">{{ $product->brand->brandName ?? '' }}</td>
        <td class="align-middle">{{ $product->category->categoryName ?? '' }}</td>
        <td class="align-middle">{{ $product->unit->unitName ?? '' }}</td>
        <td class="align-middle text-nowrap">{{ currency_format($product->productPurchasePrice, 'icon', 2, business_currency()) }}</td>
        <td class="align-middle text-nowrap">{{ currency_format($product->productSalePrice, 'icon', 2, business_currency()) }}</td>
        <td class="align-middle fw-bold {{ $product->productStock <= $product->alert_qty ? 'text-danger' : 'text-success' }}">{{ $product->productStock }}</td>
        <td class="align-middle {{ $product->expire_date < now()->toDateString() ? 'text-danger fw-bold' : '' }}">
            <span class="badge rounded-pill {{ $product->expire_date < now()->toDateString() ? 'bg-danger' : 'bg-secondary' }}">
                {{ formatted_date($product->expire_date) }}
            </span>
        </td>
        <td class="print-d-none align-middle">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown" class="btn btn-sm btn-light border-0">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#expire-product-report-view" class="product-view dropdown-item" data-bs-toggle="modal"
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
