@foreach($products as $product)
    <div id="single-product" class="single-product {{ $product->id }}"
        data-product_id="{{ $product->id }}"
        data-product_code="{{ $product->productCode }}"
        data-product_unit_id="{{ $product->unit->id ?? null }}"
        data-product_unit_name="{{ $product->unit->unitName ?? null }}"
        data-product_image="{{ $product->productPicture }}"
        data-brand = "{{ $product->brand->brandName ?? ''  }}"
        data-stock = "{{ $product->productStock  }}"
        data-purchase_price = "{{ $product->productPurchasePrice  }}"
        data-sales_price = "{{ $product->productSalePrice  }}"
        data-whole_sale_price = "{{ $product->productWholeSalePrice  }}"
        data-dealer_price = "{{ $product->productDealerPrice  }}"
    >
        <div class="pro-img">
            <img class='w-100 rounded' src="{{ asset($product->productPicture ?? 'assets/images/products/box.svg') }}" alt="">
        </div>
        <div class="product-con">
            <h6 class="pro-title product_name">{{ $product->productName }}</h6>
            <p class="pro-category">{{ $product->category->categoryName ?? '' }}</p>
            <div class="price">
                <h6 class="pro-price product_price">{{ currency_format($product->productPurchasePrice, 'icon', 2, business_currency()) }}</h6>
            </div>
        </div>
    </div>
@endforeach
