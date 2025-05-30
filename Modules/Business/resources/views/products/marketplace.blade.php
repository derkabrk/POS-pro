@extends('business::layouts.master')

@section('title')
    {{ __('Marketplace') }}
@endsection

@section('content')
<style>
/* Hide default layout elements for single-page marketplace */
header, .sidebar, .footer, #footer, .main-footer, .app-sidebar, .app-header, .layout-footer, .layout-header {
    display: none !important;
}
body, html {
    background: #f7f8fa !important;
}
.marketplace-header {
    background: linear-gradient(90deg, #4f8cff 0%, #38cfa6 100%);
    color: #fff;
    border-radius: 0 0 2rem 2rem;
    box-shadow: 0 4px 24px rgba(79,140,255,0.08);
    padding: 2.5rem 1rem 2rem 1rem;
    margin-bottom: 2.5rem;
    text-align: center;
    position: relative;
}
.marketplace-header .marketplace-title {
    font-size: 2.1rem;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
}
.marketplace-header .marketplace-business {
    font-size: 1.2rem;
    font-weight: 400;
    opacity: 0.95;
    margin-bottom: 0;
}
</style>
<div class="marketplace-header">
    <div class="marketplace-title">{{ __('Marketplace') }}</div>
    <div class="marketplace-business">{{ $businessName ?? __('Business') }}</div>
</div>
<div class="container-fluid py-4 d-flex flex-column align-items-center justify-content-center" style="min-height:calc(100vh - 80px);">
    <div class="row w-100 justify-content-center" style="margin-top:40px;">
        <div class="col-xl-9 col-lg-10 col-md-11">
            <h2 class="text-center mb-3 fw-bold" style="font-size:1.6rem;">{{ __('Marketplace for Store') }}</h2>
            <div class="row justify-content-center g-3">
                <div class="col-lg-8 col-md-7">
                    <div class="row g-3 justify-content-center" id="marketplace-products">
                        @forelse($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                            <div class="card h-100 shadow border-0 rounded-4 w-100 p-2" style="transition: box-shadow 0.2s; min-width:220px; max-width:320px; margin:auto;">
                                <img src="{{ $product->productPicture ? asset('uploads/products/' . $product->productPicture) : asset('assets/images/icons/upload.png') }}" class="card-img-top rounded-top-4 mx-auto" alt="{{ $product->productName }}" style="object-fit:cover; height:110px; width:100%; max-width:180px;">
                                <div class="card-body d-flex flex-column p-2">
                                    <h5 class="card-title mb-1 text-center fw-semibold text-primary" style="font-size:1.1rem;">{{ $product->productName }}</h5>
                                    <div class="mb-1 text-muted small text-center">{{ $product->category->categoryName ?? '' }}</div>
                                    <div class="mb-1 fw-bold text-center fs-6 text-success">{{ $product->productSalePrice }} {{ business_currency()->symbol }}</div>
                                    <div class="mb-2 text-center text-secondary small" style="font-size:0.9rem;">{{ $product->productDescription ?? '' }}</div>
                                    <ul class="list-unstyled mb-2 small text-center" style="font-size:0.85rem;">
                                        <li><b>{{ __('Brand:') }}</b> {{ $product->brand->brandName ?? '-' }}</li>
                                        <li><b>{{ __('Unit:') }}</b> {{ $product->unit->unitName ?? '-' }}</li>
                                        <li><b>{{ __('Stock:') }}</b> {{ $product->productStock }}</li>
                                    </ul>
                                    <div class="input-group mb-2 justify-content-center" style="max-width:120px; margin:auto;">
                                        <span class="input-group-text bg-light border-0 px-2 py-1" style="font-size:0.9rem;">{{ __('Qty') }}</span>
                                        <input type="number" min="1" max="{{ $product->productStock }}" value="1" class="form-control cart-qty text-center border-0 bg-light px-2 py-1" id="qty-{{ $product->id }}" style="max-width:50px; font-size:0.9rem;">
                                    </div>
                                    <button class="btn btn-primary mt-auto add-to-cart-btn w-100 rounded-pill py-1 fw-semibold shadow-sm" style="font-size:0.95rem;">{{ __('Add to Cart') }}</button>
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
                <div class="col-lg-4 col-md-5 d-flex align-items-start justify-content-center">
                    <div id="cart-summary" class="card sticky-top w-100 shadow border-0 rounded-4" style="top:90px; display:none; max-width:320px; min-width:220px;">
                        <div class="card-header bg-success text-white text-center rounded-top-4 fw-bold fs-6 py-2">{{ __('Your Cart') }}</div>
                        <div class="card-body p-3">
                            <ul class="list-group mb-2" id="cart-items"></ul>
                            <div class="mb-3 text-end">
                                <b class="fs-6">{{ __('Total:') }}</b> <span id="cart-total" class="fs-6 fw-bold">0</span> <span class="text-success fw-bold">{{ business_currency()->symbol }}</span>
                            </div>
                            <a href="#" id="checkout-btn" class="btn btn-success w-100 rounded-pill py-1 fw-semibold shadow-sm" style="font-size:0.95rem;">{{ __('Checkout') }}</a>
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
