
@section('title')
    {{ __('Marketplace') }}
@endsection

@section('css')
@endsection

@section('content')
<div class="marketplace-header bg-primary-gradient text-white rounded-bottom-4 shadow-sm mb-4 text-center py-5">
    <div class="marketplace-title display-5 fw-bold mb-2">{{ __('Marketplace') }}</div>
    <div class="marketplace-business h5 mb-0 opacity-75">{{ $businessName ?? __('Business') }}</div>
</div>
<div class="container-fluid py-4 d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div class="row w-100 justify-content-center mt-4">
        <div class="col-xl-9 col-lg-10 col-md-11">
            <h2 class="text-center mb-3 fw-bold fs-3 text-primary">{{ __('Marketplace for Store') }}</h2>
            <div class="row justify-content-center g-3">
                <div class="col-lg-8 col-md-7">
                    <div class="row g-3 justify-content-center" id="marketplace-products">
                        @forelse($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                            <div class="card h-100 border-0 shadow-sm rounded-4 w-100 p-2 marketplace-product-card">
                                <img src="{{ $product->productPicture ? asset('uploads/products/' . $product->productPicture) : asset('assets/images/icons/upload.png') }}" class="card-img-top rounded-top-4 mx-auto object-fit-cover" alt="{{ $product->productName }}" style="height:110px; width:100%; max-width:180px;">
                                <div class="card-body d-flex flex-column p-2">
                                    <h5 class="card-title mb-1 text-center fw-semibold text-primary fs-6">{{ $product->productName }}</h5>
                                    <div class="mb-1 text-muted small text-center">{{ $product->category->categoryName ?? '' }}</div>
                                    <div class="mb-1 fw-bold text-center fs-6 text-success">{{ $product->productSalePrice }} {{ business_currency()->symbol }}</div>
                                    <div class="mb-2 text-center text-secondary small">{{ $product->productDescription ?? '' }}</div>
                                    <ul class="list-unstyled mb-2 small text-center">
                                        <li><b>{{ __('Brand:') }}</b> {{ $product->brand->brandName ?? '-' }}</li>
                                        <li><b>{{ __('Unit:') }}</b> {{ $product->unit->unitName ?? '-' }}</li>
                                        <li><b>{{ __('Stock:') }}</b> {{ $product->productStock }}</li>
                                    </ul>
                                    <div class="input-group mb-2 justify-content-center" style="max-width:120px; margin:auto;">
                                        <span class="input-group-text bg-light border-0 px-2 py-1 small">{{ __('Qty') }}</span>
                                        <input type="number" min="1" max="{{ $product->productStock }}" value="1" class="form-control cart-qty text-center border-0 bg-light px-2 py-1 small" id="qty-{{ $product->id }}" style="max-width:50px;">
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
                    <div id="cart-summary" class="card sticky-top w-100 shadow border-0 rounded-4 marketplace-cart-summary" style="top:90px; display:none; max-width:320px; min-width:220px;">
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
        const card = this.closest('.card');
        const id = this.dataset.id;
        const name = this.dataset.name;
        const price = parseFloat(this.dataset.price);
        const stock = parseInt(this.dataset.stock);
        // Always get the qty input inside the same card
        const qtyInput = card.querySelector('.cart-qty');
        const qty = parseInt(qtyInput.value);
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
    // Save cart to localStorage and redirect
    localStorage.setItem('marketplace_cart', JSON.stringify(cart));
    window.location.href = '/marketplace/checkout?business_id={{ $business_id }}';
});
// On page load, restore cart from localStorage if available
window.addEventListener('DOMContentLoaded', function() {
    try {
        const savedCart = JSON.parse(localStorage.getItem('marketplace_cart') || '[]');
        if (Array.isArray(savedCart) && savedCart.length > 0) {
            cart = savedCart;
            updateCartDisplay();
        }
    } catch (e) {}
});
</script>
@endpush
