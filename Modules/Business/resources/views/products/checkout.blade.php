@extends('business::layouts.master')

@section('title')
    {{ __('Checkout') }}
@endsection

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center py-4" style="min-height:calc(100vh - 80px);">
    <div class="row w-100 justify-content-center" style="margin-top:40px;">
        <div class="col-xl-7 col-lg-8 col-md-10">
            <h2 class="text-center mb-3 fw-bold" style="font-size:1.4rem;">{{ __('Checkout') }}</h2>
            <div class="row g-3 justify-content-center">
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 rounded-4 mb-3 p-2">
                        <div class="card-header bg-success text-white text-center rounded-top-4 fw-bold fs-6 py-2">{{ __('Your Cart') }}</div>
                        <div class="card-body p-3">
                            <ul class="list-group mb-2 small" id="checkout-cart-items"></ul>
                            <div class="mb-2 text-end">
                                <b class="fs-6">{{ __('Total:') }}</b> <span id="checkout-cart-total" class="fs-6 fw-bold">0</span> <span class="text-success fw-bold">{{ business_currency()->symbol }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 rounded-4 p-2">
                        <div class="card-header text-center fw-bold fs-6 py-2">{{ __('Customer Information') }}</div>
                        <div class="card-body p-3">
                            <form id="checkout-form">
                                <div class="mb-2">
                                    <label class="form-label small">{{ __('Your Name') }}</label>
                                    <input type="text" name="customer_name" class="form-control form-control-sm" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">{{ __('Email') }}</label>
                                    <input type="email" name="customer_email" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">{{ __('Phone') }}</label>
                                    <input type="text" name="customer_phone" class="form-control form-control-sm">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">{{ __('Payment Method') }}</label>
                                    <select name="payment_method" class="form-control form-control-sm" required>
                                        <option value="">{{ __('Select Payment Method') }}</option>
                                        <option value="cash">{{ __('Cash') }}</option>
                                        <option value="card">{{ __('Card') }}</option>
                                        <option value="mobile">{{ __('Mobile Payment') }}</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100 rounded-pill py-1 fw-semibold shadow-sm" style="font-size:0.95rem;">{{ __('Place Order') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 d-flex align-items-start justify-content-center">
                    <a href="/" class="btn btn-secondary mb-3 w-100 rounded-pill py-1 fw-semibold shadow-sm" style="font-size:0.95rem;">{{ __('Back to Marketplace') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = [];
    try {
        cart = JSON.parse(localStorage.getItem('marketplace_cart') || '[]');
    } catch (e) { cart = []; }
    function renderCheckoutCart() {
        const cartItems = document.getElementById('checkout-cart-items');
        const cartTotal = document.getElementById('checkout-cart-total');
        cartItems.innerHTML = '';
        let total = 0;
        if (!cart || cart.length === 0) {
            cartItems.innerHTML = '<li class="list-group-item text-center small">{{ __('Your cart is empty.') }}</li>';
            cartTotal.textContent = 0;
            return;
        }
        cart.forEach(item => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `<span>${item.name} <span class='badge bg-secondary ms-2'>x${item.qty}</span></span> <span class='fw-bold'>${item.price * item.qty} {{ business_currency()->symbol }}</span>`;
            cartItems.appendChild(li);
            total += item.price * item.qty;
        });
        cartTotal.textContent = total;
    }
    renderCheckoutCart();
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!cart || cart.length === 0) return alert('Cart is empty!');
            const formData = new FormData(this);
            const data = {
                cart,
                customer_name: formData.get('customer_name'),
                customer_email: formData.get('customer_email'),
                customer_phone: formData.get('customer_phone'),
                payment_method: formData.get('payment_method'),
                business_id: '{{ request('business_id') }}'
            };
            // Debug: show data in console
            console.log('Order Data:', data);
            alert('Order placed! (Demo)');
            localStorage.removeItem('marketplace_cart');
            window.location.href = '/';
        });
    }
});
</script>
@endsection
