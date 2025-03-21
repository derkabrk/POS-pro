@foreach ($products as $product)
    <tr>
        <td class="w-60 checkbox d-print-none">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $product->id }}">
        </td>
        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>

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

        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#product-view" class="product-view" data-bs-toggle="modal"
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
                    <li>
                        <a href="{{ route('business.products.edit', $product->id) }}">
                            <i class="fal fa-edit"></i>
                            {{ __('Edit') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('business.products.destroy', $product->id) }}" class="confirm-action"
                            data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
