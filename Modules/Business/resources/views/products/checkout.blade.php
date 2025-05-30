@extends('business::layouts.master')

@section('title')
    {{ __('Checkout') }}
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">{{ __('Checkout') }}</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">{{ __('Your Cart') }}</div>
                <div class="card-body">
                    <ul class="list-group mb-3" id="checkout-cart-items"></ul>
                    <div class="mb-2">
                        <b>{{ __('Total:') }}</b> <span id="checkout-cart-total">0</span> {{ business_currency()->symbol }}
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Customer Information') }}</div>
                <div class="card-body">
                    <form id="checkout-form">
                        <div class="mb-3">
                            <label>{{ __('Your Name') }}</label>
                            <input type="text" name="customer_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="customer_email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="customer_phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>{{ __('Payment Method') }}</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">{{ __('Select Payment Method') }}</option>
                                <option value="cash">{{ __('Cash') }}</option>
                                <option value="card">{{ __('Card') }}</option>
                                <option value="mobile">{{ __('Mobile Payment') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">{{ __('Place Order') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('marketplace.show', request('business_id')) }}" class="btn btn-secondary mb-3 w-100">{{ __('Back to Marketplace') }}</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Load cart from localStorage
let cart = JSON.parse(localStorage.getItem('marketplace_cart') || '[]');
function renderCheckoutCart() {
    const cartItems = document.getElementById('checkout-cart-items');
    const cartTotal = document.getElementById('checkout-cart-total');
    cartItems.innerHTML = '';
    let total = 0;
    if (cart.length === 0) {
        cartItems.innerHTML = '<li class="list-group-item">{{ __('Your cart is empty.') }}</li>';
        cartTotal.textContent = 0;
        return;
    }
    cart.forEach(item => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `${item.name} x${item.qty} <span>${item.price * item.qty} {{ business_currency()->symbol }}</span>`;
        cartItems.appendChild(li);
        total += item.price * item.qty;
    });
    cartTotal.textContent = total;
}
renderCheckoutCart();

document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    if (cart.length === 0) return alert('Cart is empty!');
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
    window.location.href = '{{ route('marketplace.show', request('business_id')) }}';
});
</script>
@endpush
