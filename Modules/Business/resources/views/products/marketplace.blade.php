@extends('business::layouts.master')

@section('title')
    {{ __('Marketplace') }}
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-8">
            <div class="row" id="marketplace-products">
                @forelse($products as $product)
                @if($product->business_id == $business_id)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $product->productPicture ? asset('uploads/products/' . $product->productPicture) : asset('assets/images/icons/upload.png') }}" class="card-img-top" alt="{{ $product->productName }}" style="object-fit:cover; height:180px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-1">{{ $product->productName }}</h5>
                            <div class="mb-1 text-muted small">{{ $product->category->categoryName ?? '' }}</div>
                            <div class="mb-1 fw-bold">{{ $product->productSalePrice }} {{ business_currency()->symbol }}</div>
                            <div class="mb-2">{{ $product->productDescription ?? '' }}</div>
                            <ul class="list-unstyled mb-2 small">
                                <li><b>{{ __('Brand:') }}</b> {{ $product->brand->brandName ?? '-' }}</li>
                                <li><b>{{ __('Unit:') }}</b> {{ $product->unit->unitName ?? '-' }}</li>
                                <li><b>{{ __('Stock:') }}</b> {{ $product->productStock }}</li>
                            </ul>
                            <div class="input-group mb-2">
                                <span class="input-group-text">{{ __('Qty') }}</span>
                                <input type="number" min="1" max="{{ $product->productStock }}" value="1" class="form-control cart-qty" id="qty-{{ $product->id }}">
                            </div>
                            <button class="btn btn-primary mt-auto add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->productName }}" data-price="{{ $product->productSalePrice }}" data-stock="{{ $product->productStock }}">{{ __('Add to Cart') }}</button>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">{{ __('No products available for this business.') }}</div>
                </div>
                @endforelse
            </div>
        </div>
        <div class="col-lg-4">
            <div id="cart-summary" class="card sticky-top" style="top:90px; display:none;">
                <div class="card-header bg-success text-white">{{ __('Your Cart') }}</div>
                <div class="card-body">
                    <ul class="list-group mb-2" id="cart-items"></ul>
                    <div class="mb-3 text-end">
                        <b>{{ __('Total:') }}</b> <span id="cart-total">0</span> {{ business_currency()->symbol }}
                    </div>
                    <a href="#" id="checkout-btn" class="btn btn-success w-100">{{ __('Checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let cart = [];
function updateCartDisplay() {
    const cartSummary = document.getElementById('cart-summary');
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    cartItems.innerHTML = '';
    let total = 0;
    if (cart.length === 0) {
        cartSummary.style.display = 'none';
        return;
    }
    cartSummary.style.display = 'block';
    cart.forEach(item => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `<span>${item.name} <span class='badge bg-secondary ms-2'>x${item.qty}</span></span> <span class='fw-bold'>${item.price * item.qty} {{ business_currency()->symbol }}</span>`;
        cartItems.appendChild(li);
        total += item.price * item.qty;
    });
    cartTotal.textContent = total;
}
document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const price = parseFloat(this.dataset.price);
        const stock = parseInt(this.dataset.stock);
        const qty = parseInt(document.getElementById('qty-' + id).value);
        if (qty < 1 || qty > stock) return alert('Invalid quantity');
        const existing = cart.find(item => item.id === id);
        if (existing) {
            existing.qty += qty;
            if (existing.qty > stock) existing.qty = stock;
        } else {
            cart.push({id, name, price, qty, stock});
        }
        updateCartDisplay();
    });
});
document.getElementById('checkout-btn').addEventListener('click', function(e) {
    e.preventDefault();
    if(cart.length === 0) return alert('Cart is empty!');
    localStorage.setItem('marketplace_cart', JSON.stringify(cart));
    window.location.href = '/marketplace/checkout?business_id={{ $business_id }}';
});
</script>
@endpush
