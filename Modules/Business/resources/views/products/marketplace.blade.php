@extends('business::layouts.master')

@section('title')
    {{ __('Marketplace') }}
@endsection

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="text-center mb-4 fw-bold">{{ __('Marketplace for Store') }}</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-4" id="marketplace-products">
                        @forelse($products as $product)
                        <div class="col-md-6 col-xl-4 d-flex align-items-stretch">
                            <div class="card h-100 shadow border-0 rounded-4 w-100" style="transition: box-shadow 0.2s;">
                                <img src="{{ $product->productPicture ? asset('uploads/products/' . $product->productPicture) : asset('assets/images/icons/upload.png') }}" class="card-img-top rounded-top-4" alt="{{ $product->productName }}" style="object-fit:cover; height:180px;">
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title mb-2 text-center fw-bold text-primary">{{ $product->productName }}</h5>
                                    <div class="mb-1 text-muted small text-center">{{ $product->category->categoryName ?? '' }}</div>
                                    <div class="mb-2 fw-bold text-center fs-5 text-success">{{ $product->productSalePrice }} {{ business_currency()->symbol }}</div>
                                    <div class="mb-3 text-center text-secondary small">{{ $product->productDescription ?? '' }}</div>
                                    <ul class="list-unstyled mb-3 small text-center">
                                        <li><b>{{ __('Brand:') }}</b> {{ $product->brand->brandName ?? '-' }}</li>
                                        <li><b>{{ __('Unit:') }}</b> {{ $product->unit->unitName ?? '-' }}</li>
                                        <li><b>{{ __('Stock:') }}</b> {{ $product->productStock }}</li>
                                    </ul>
                                    <div class="input-group mb-3 justify-content-center">
                                        <span class="input-group-text bg-light border-0">{{ __('Qty') }}</span>
                                        <input type="number" min="1" max="{{ $product->productStock }}" value="1" class="form-control cart-qty text-center border-0 bg-light" id="qty-{{ $product->id }}" style="max-width:80px;">
                                    </div>
                                    <button class="btn btn-primary mt-auto add-to-cart-btn w-100 rounded-pill py-2 fw-semibold shadow-sm" data-id="{{ $product->id }}" data-name="{{ $product->productName }}" data-price="{{ $product->productSalePrice }}" data-stock="{{ $product->productStock }}">{{ __('Add to Cart') }}</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">{{ __('No products available for this business.') }}</div>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-start justify-content-center">
                    <div id="cart-summary" class="card sticky-top w-100 shadow border-0 rounded-4" style="top:90px; display:none; max-width:350px;">
                        <div class="card-header bg-success text-white text-center rounded-top-4 fw-bold fs-5">{{ __('Your Cart') }}</div>
                        <div class="card-body p-4">
                            <ul class="list-group mb-3" id="cart-items"></ul>
                            <div class="mb-4 text-end">
                                <b class="fs-6">{{ __('Total:') }}</b> <span id="cart-total" class="fs-5 fw-bold">0</span> <span class="text-success fw-bold">{{ business_currency()->symbol }}</span>
                            </div>
                            <a href="#" id="checkout-btn" class="btn btn-success w-100 rounded-pill py-2 fw-semibold shadow-sm">{{ __('Checkout') }}</a>
                        </div>
                    </div>
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
