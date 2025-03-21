@forelse ($products as $product)
    <div id="single-product" class="single-product {{ $product->id }}" data-product_id="{{ $product->id }}"
        data-default_price="{{ $product->productSalePrice }}" data-product_code="{{ $product->productCode }}"
        data-product_unit_id="{{ $product->unit->id ?? null }}"
        data-product_unit_name="{{ $product->unit->unitName ?? null }}"
        data-product_image="{{ $product->productPicture }}" data-route="{{ route('business.carts.store') }}">
        <div class="pro-img w-100">
            <img src="{{ asset($product->productPicture ?? 'assets/images/products/box.svg') }}" alt="">
        </div>
        <div class="product-con">
            <h6 class="pro-title product_name">{{ $product->productName }}</h6>
            <p class="pro-category">{{ $product->category->name ?? '' }}</p>
            <div class="price">
                <h6 class="pro-price product_price">
                    {{ currency_format($product->productSalePrice, 'icon', 2, business_currency()) }}</h6>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-danger not-found mt-1" role="alert">
        No product found
    </div>
@endforelse
