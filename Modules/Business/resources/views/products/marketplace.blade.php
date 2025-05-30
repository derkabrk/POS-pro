@extends('business::layouts.master')

@section('title')
    {{ __('Marketplace') }}
@endsection

@section('content')
<div class="container-fluid">
    <a href="{{ route('marketplace.show', $business_id) }}" class="btn btn-primary mb-3">{{ __('Go to Marketplace Home') }}</a>
    <h2 class="mb-4">{{ __('Marketplace for Store') }}: <span id="store-name"></span></h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <!-- Cart Summary -->
            <div id="cart-summary" class="card mb-3" style="display:none;">
                <div class="card-header">{{ __('Your Cart') }}</div>
                <div class="card-body">
                    <ul class="list-group mb-2" id="cart-items"></ul>
                    <div class="mb-2">
                        <b>{{ __('Total:') }}</b> <span id="cart-total">0</span> {{ business_currency()->symbol }}
                    </div>
                    <a href="#" id="checkout-btn" class="btn btn-success w-100">{{ __('Checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="marketplace-products">
        @foreach($products as $product)
        @if($product->business_id == $business_id)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ $product->productPicture ? asset('uploads/products/' . $product->productPicture) : asset('assets/images/icons/upload.png') }}" class="card-img-top" alt="{{ $product->productName }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->productName }}</h5>
                    <p class="card-text">{{ $product->category->categoryName ?? '' }}</p>
                    <p class="card-text">{{ $product->productSalePrice }} {{ business_currency()->symbol }}</p>
                    <p class="card-text">{{ $product->productDescription ?? '' }}</p>
                    <ul>
                        <li><b>{{ __('Brand:') }}</b> {{ $product->brand->brandName ?? '-' }}</li>
                        <li><b>{{ __('Unit:') }}</b> {{ $product->unit->unitName ?? '-' }}</li>
                        <li><b>{{ __('Stock:') }}</b> {{ $product->productStock }}</li>
                    </ul>
                    <div class="mb-2">
                        <label>{{ __('Quantity') }}</label>
                        <input type="number" min="1" max="{{ $product->productStock }}" value="1" class="form-control cart-qty" id="qty-{{ $product->id }}">
                    </div>
                    <button class="btn btn-primary w-100 add-to-cart-btn" data-id="{{ $product->id }}" data-name="{{ $product->productName }}" data-price="{{ $product->productSalePrice }}" data-stock="{{ $product->productStock }}">{{ __('Add to Cart') }}</button>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>

<!-- Cart & Checkout JS -->
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
        li.innerHTML = `${item.name} x${item.qty} <span>${item.price * item.qty} {{ business_currency()->symbol }}</span>`;
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
    // Redirect to checkout page with cart data (simulate for now)
    localStorage.setItem('marketplace_cart', JSON.stringify(cart));
    window.location.href = '/marketplace/checkout?business_id={{ $business_id }}';
});
</script>
@endpush
