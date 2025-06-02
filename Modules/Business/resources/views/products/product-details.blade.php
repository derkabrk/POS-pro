@extends('layouts.web.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Image & Gallery -->
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card product-card p-3">
                <div class="product-image text-center">
                    <img src="{{ $product->productPicture ? asset($product->productPicture) : asset('demo_images/default-product.png') }}" 
                         alt="{{ $product->productName }}" 
                         class="img-fluid rounded"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x300/f8fafc/405cf5?text=No+Image';">
                    @if($product->productStock < 5)
                        <div class="product-badge">Low Stock</div>
                    @elseif($product->created_at && $product->created_at->gt(now()->subDays(14)))
                        <div class="product-badge">New</div>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary"><i class="ri-arrow-left-line me-1"></i>Back to Marketplace</a>
            </div>
        </div>
        <!-- Product Details & Order Form -->
        <div class="col-lg-6">
            <div class="card product-card p-4">
                <h2 class="product-title mb-2">{{ $product->productName }}</h2>
                <div class="product-price mb-2">${{ number_format($product->productSalePrice, 2) }}</div>
                <div class="mb-3 text-muted small">
                    <span><strong>Brand:</strong> {{ $product->brand->brandName ?? '-' }}</span> |
                    <span><strong>Stock:</strong> {{ $product->productStock }} units</span>
                </div>
                <p class="product-description mb-4">{{ $product->meta['description'] ?? 'Premium quality product with excellent features.' }}</p>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <hr>
                <form id="order-form" method="POST" action="{{ route('marketplace.product.order', ['business' => $business->subdomain, 'business_id' => $business->id, 'product_id' => $product->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <div class="qty-selector">
                            <button type="button" class="qty-btn" onclick="changeQty(this, -1)"><i class="ri-subtract-line"></i></button>
                            <input type="number" class="qty-input" name="quantity" value="1" min="1" max="{{ $product->productStock }}">
                            <button type="button" class="qty-btn" onclick="changeQty(this, 1)"><i class="ri-add-line"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Name *</label>
                        <input type="text" class="form-control" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="customer_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="tel" class="form-control" name="customer_phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address *</label>
                        <input type="text" class="form-control" name="customer_address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Special Instructions</label>
                        <textarea class="form-control" name="special_instructions" rows="2" placeholder="Any special delivery instructions..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        <i class="ri-shopping-bag-3-line me-2"></i>Order Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function changeQty(btn, change) {
        const qtyInput = btn.parentElement.querySelector('.qty-input');
        let currentQty = parseInt(qtyInput.value);
        const max = parseInt(qtyInput.getAttribute('max'));
        const min = parseInt(qtyInput.getAttribute('min'));
        const newQty = currentQty + change;
        if (newQty >= min && newQty <= max) {
            qtyInput.value = newQty;
        }
    }
    document.getElementById('order-form')?.addEventListener('submit', function(e) {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="ri-loader-4-line ri-spin me-2"></i>Processing...';
    });
</script>
@endpush
