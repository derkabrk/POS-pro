<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Premium Store</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Saira:wght@400;600;700&display=swap');
        :root {
            --main-color: #8c68cd;
            --primary-gradient: linear-gradient(135deg, var(--main-color) 0%, #4b3269 100%);
            --secondary-gradient: linear-gradient(135deg, #b993d6 0%, #8ca6db 100%);
            --success-gradient: linear-gradient(135deg, #6ee7b7 0%, #3b82f6 100%);
            --card-shadow: 0 10px 30px rgba(0,0,0,0.25);
            --hover-shadow: 0 20px 40px rgba(0,0,0,0.35);
            --border-radius: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Saira', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #232136 0%, #2d223f 100%);
            min-height: 100vh;
            color: #f3f3fa;
        }

        /* Loading Animation */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }

        .loader {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loader-text {
            color: white;
            font-size: 1.2rem;
            margin-top: 20px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        /* Header Styles */
        .marketplace-header {
            background: var(--primary-gradient);
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .marketplace-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="30" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="15" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.2" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .marketplace-title {
            font-size: 3.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 15px;
        }

        .business-name {
            font-size: 1.5rem;
            opacity: 0.9;
            font-weight: 300;
        }

        /* Filter Section */
        .filter-section {
            background: #2d223f;
            border-radius: var(--border-radius);
            padding: 20px;
            margin: -30px auto 30px;
            max-width: 800px;
            box-shadow: var(--card-shadow);
            z-index: 10;
            position: relative;
        }

        .filter-btn {
            border: 2px solid #8c68cd;
            background: #232136;
            color: #8c68cd;
            border-radius: 50px;
            padding: 10px 20px;
            margin: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--main-color);
            color: #fff;
            border-color: var(--main-color);
        }

        /* Category Sections */
        .category-section {
            background: #2d223f;
            color: #f3f3fa;
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border-left: 5px solid transparent;
            transition: all 0.3s ease;
        }

        .category-section:nth-child(1) { border-left-color: #667eea; }
        .category-section:nth-child(2) { border-left-color: #28a745; }
        .category-section:nth-child(3) { border-left-color: #17a2b8; }
        .category-section:nth-child(4) { border-left-color: #ffc107; }

        .category-header {
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .category-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .category-title i {
            font-size: 2rem;
        }

        .category-title .badge {
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        /* Product Cards */
        .product-card {
            background: #232136;
            color: #f3f3fa;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--hover-shadow);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(45deg, #2d223f, #232136);
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--success-gradient);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-info {
            padding: 20px;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #e0d7f7;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--success-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .product-description {
            color: #e0d7f7;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .product-details {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .qty-selector {
            background: #2d223f;
            border: 2px solid #4b3269;
            border-radius: 50px;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            max-width: 120px;
        }

        .qty-btn {
            background: none;
            border: none;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            transition: color 0.3s ease;
        }

        .qty-btn:hover {
            color: #667eea;
        }

        .qty-input {
            border: none;
            text-align: center;
            width: 50px;
            font-weight: 600;
        }

        .add-to-cart-btn {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .add-to-cart-btn:active {
            transform: scale(0.98);
        }

        /* Cart Sidebar */
        .cart-sidebar {
            background: #232136;
            color: #f3f3fa;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }

        .cart-header {
            background: var(--main-color);
            color: #fff;
            padding: 20px;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            text-align: center;
            font-weight: 600;
        }

        .cart-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-total {
            padding: 20px;
            background: #2d223f;
            color: #f3f3fa;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        .checkout-btn {
            background: var(--success-gradient);
            border: none;
            color: white;
            padding: 15px;
            border-radius: 50px;
            font-weight: 600;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
        }

        /* Checkout Page */
        .checkout-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 15px;
        }

        .checkout-form {
            background: #2d223f;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #e0d7f7;
            margin-bottom: 8px;
        }

        .form-control {
            background: #2d223f;
            color: #f3f3fa;
            border: 2px solid #4b3269;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 0 0.2rem rgba(140, 104, 205, 0.25);
            background: #2d223f;
            color: #fff;
        }

        .input-group-text {
            background: #2d223f;
            color: #b993d6;
            border: 1px solid #4b3269;
        }

        .loader-container {
            background: var(--primary-gradient);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .marketplace-title {
                font-size: 2.5rem;
            }
            
            .filter-section {
                margin: -20px 15px 20px;
                padding: 15px;
            }
            
            .product-card {
                margin-bottom: 20px;
            }
            
            .cart-sidebar {
                position: relative;
                margin-top: 30px;
            }
        }

        /* Animation Classes */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .fade-in:nth-child(1) { animation-delay: 0.1s; }
        .fade-in:nth-child(2) { animation-delay: 0.2s; }
        .fade-in:nth-child(3) { animation-delay: 0.3s; }
        .fade-in:nth-child(4) { animation-delay: 0.4s; }
        .fade-in:nth-child(5) { animation-delay: 0.5s; }
        .fade-in:nth-child(6) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-bounce {
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 20%, 60%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            80% { transform: translateY(-5px); }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loader-container" id="loader">
        <div class="text-center">
            <div class="loader"></div>
            <div class="loader-text">Loading Marketplace...</div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" style="display: none;">
        <!-- Marketplace Page -->
        <div id="marketplace-page">
            <!-- Header -->
            <header class="marketplace-header">
                <div class="container text-center text-white">
                    <h1 class="marketplace-title">{{ $business->companyName }} Marketplace</h1>
                    <p class="business-name">{{ $business->address ?? '' }}</p>
                    <div class="mt-4">
                        <i class="fas fa-star text-warning me-2"></i>
                        <span>4.9/5 Rating • 10,000+ Happy Customers</span>
                    </div>
                </div>
            </header>

            <!-- Filter Section -->
            <div class="container">
                <div class="filter-section">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-3 mb-md-0">Browse by Category</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center text-md-end">
                                <button class="filter-btn active" data-view="category">Category View</button>
                                <button class="filter-btn" data-view="all">All Products</button>
                                @foreach($categories as $category)
                                    <button class="filter-btn" data-category="{{ $category->id }}">{{ $category->categoryName }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Category View -->
                        <div id="category-view">
                            @foreach($categories as $category)
                                <div class="category-section mb-5">
                                    <div class="category-header d-flex align-items-center justify-content-between mb-4">
                                        <h3 class="category-title">
                                            <i class="fas fa-tag text-primary me-3"></i>
                                            {{ $category->categoryName }}
                                            <span class="badge bg-primary ms-2">
                                                {{ $products->where('category_id', $category->id)->count() }} items
                                            </span>
                                        </h3>
                                        <button class="btn btn-outline-primary btn-sm">View All</button>
                                    </div>
                                    <div class="row g-3">
                                        @foreach($products->where('category_id', $category->id) as $product)
                                            <div class="col-md-6 col-lg-4 fade-in">
                                                <div class="product-card">
                                                    <div class="product-image">
                                                        <img src="{{ $product->productPicture ? asset($product->productPicture) : asset('demo_images/default-product.png') }}" alt="{{ $product->productName }}">
                                                        @if($product->productStock < 5)
                                                            <div class="product-badge">Low Stock</div>
                                                        @elseif($product->created_at && $product->created_at->gt(now()->subDays(14)))
                                                            <div class="product-badge">New</div>
                                                        @endif
                                                    </div>
                                                    <div class="product-info">
                                                        <h3 class="product-title">{{ $product->productName }}</h3>
                                                        <div class="product-price">${{ number_format($product->productSalePrice, 2) }}</div>
                                                        <p class="product-description">{{ $product->meta['description'] ?? '' }}</p>
                                                        <div class="product-details">
                                                            <small><strong>Brand:</strong> {{ $product->brand->brandName ?? '-' }}</small><br>
                                                            <small><strong>Stock:</strong> {{ $product->productStock }} units</small>
                                                        </div>
                                                        <div class="qty-selector">
                                                            <button class="qty-btn" onclick="changeQty(this, -1)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" class="qty-input" value="1" min="1" max="{{ $product->productStock }}">
                                                            <button class="qty-btn" onclick="changeQty(this, 1)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <button class="add-to-cart-btn" onclick="addToCart(this)" data-id="{{ $product->id }}" data-name="{{ $product->productName }}" data-price="{{ $product->productSalePrice }}" data-stock="{{ $product->productStock }}">
                                                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- All Products View (Original Grid) -->
                        <div id="all-products-view" style="display: none;">
                            <div class="row" id="products-container">
                                <!-- All products will be shown here when "All Products" is selected -->
                                {{-- Dynamic content will be injected by JS if needed --}}
                            </div>
                        </div>
                    </div>

                    <!-- Cart Sidebar -->
                    <div class="col-lg-4">
                        <div class="cart-sidebar" id="cart-sidebar" style="display: none;">
                            <div class="cart-header">
                                <h5><i class="fas fa-shopping-cart me-2"></i>Your Cart</h5>
                            </div>
                            <div id="cart-items"></div>
                            <div class="cart-total">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Total: <span id="cart-total">$0.00</span></h5>
                                </div>
                                <button class="checkout-btn" onclick="goToCheckout()">
                                    <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Page -->
        <div id="checkout-page" style="display: none;">
            <header class="marketplace-header py-4">
                <div class="container text-center text-white">
                    <h1 class="h2">Checkout</h1>
                    <button class="btn btn-outline-light mt-2" onclick="backToMarketplace()">
                        <i class="fas fa-arrow-left me-2"></i>Back to Marketplace
                    </button>
                </div>
            </header>

            <div class="checkout-container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-form">
                            <h3 class="mb-4"><i class="fas fa-user me-2"></i>Billing Information</h3>
                            <form id="checkout-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">First Name *</label>
                                            <input type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Last Name *</label>
                                            <input type="text" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Address *</label>
                                    <input type="text" class="form-control" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">City *</label>
                                            <input type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">State *</label>
                                            <input type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">ZIP Code *</label>
                                            <input type="text" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="mt-4 mb-3"><i class="fas fa-credit-card me-2"></i>Payment Information</h4>
                                
                                <div class="form-group">
                                    <label class="form-label">Payment Method</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment" id="credit-card" checked>
                                                <label class="form-check-label" for="credit-card">
                                                    <i class="fas fa-credit-card me-2"></i>Credit Card
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment" id="paypal">
                                                <label class="form-check-label" for="paypal">
                                                    <i class="fab fa-paypal me-2"></i>PayPal
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="payment" id="cash">
                                                <label class="form-check-label" for="cash">
                                                    <i class="fas fa-money-bill me-2"></i>Cash on Delivery
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="card-details">
                                    <div class="form-group">
                                        <label class="form-label">Card Number *</label>
                                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Expiry Date *</label>
                                                <input type="text" class="form-control" placeholder="MM/YY" maxlength="5">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">CVV *</label>
                                                <input type="text" class="form-control" placeholder="123" maxlength="4">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Special Instructions</label>
                                    <textarea class="form-control" rows="3" placeholder="Any special delivery instructions..."></textarea>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="order-summary">
                            <h4 class="mb-4"><i class="fas fa-receipt me-2"></i>Order Summary</h4>
                            <div id="checkout-items"></div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span id="checkout-subtotal">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Shipping:</span>
                                <span>$10.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Tax:</span>
                                <span id="checkout-tax">$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between h5">
                                <strong>Total:</strong>
                                <strong id="checkout-total">$0.00</strong>
                            </div>
                            <button class="place-order-btn" onclick="placeOrder()">
                                <i class="fas fa-check me-2"></i>Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = [];
        let currentPage = 'marketplace';

        // Loading Screen
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loader').style.opacity = '0';
                setTimeout(() => {
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('main-content').style.display = 'block';
                }, 500);
            }, 2000);
        });

        // Category Filtering
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const view = this.getAttribute('data-view');
                const category = this.getAttribute('data-category');
                
                const categoryView = document.getElementById('category-view');
                const allProductsView = document.getElementById('all-products-view');

                if (view === 'category') {
                    // Show category view
                    categoryView.style.display = 'block';
                    allProductsView.style.display = 'none';
                } else if (view === 'all') {
                    // Show all products in grid
                    categoryView.style.display = 'none';
                    allProductsView.style.display = 'block';
                    showAllProducts();
                } else if (category) {
                    // Show specific category products
                    categoryView.style.display = 'none';
                    allProductsView.style.display = 'block';
                    filterProductsByCategory(category);
                }
            });
        });

        // Show all products in grid view
        function showAllProducts() {
            const container = document.getElementById('products-container');
            container.innerHTML = getAllProductsHTML();
        }

        // Filter products by specific category
        function filterProductsByCategory(category) {
            const container = document.getElementById('products-container');
            const allProducts = getAllProductsData();
            
            const filteredProducts = allProducts.filter(product => product.category === category);
            container.innerHTML = generateProductsHTML(filteredProducts);
        }

        // Get all products data
        function getAllProductsData() {
            return [
                {
                    id: '1',
                    name: 'Premium Wireless Headphones',
                    price: '299.99',
                    stock: '15',
                    category: 'electronics',
                    image: 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400',
                    description: 'High-quality noise-canceling headphones with premium sound quality.',
                    brand: 'AudioTech',
                    badge: 'New'
                },
                {
                    id: '2',
                    name: 'Latest Smartphone Pro',
                    price: '899.99',
                    stock: '8',
                    category: 'electronics',
                    image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400',
                    description: 'Cutting-edge smartphone with advanced camera and performance.',
                    brand: 'TechPro',
                    badge: 'Hot'
                },
                {
                    id: '6',
                    name: 'Gaming Laptop Ultra',
                    price: '1299.99',
                    stock: '5',
                    category: 'electronics',
                    image: 'https://images.unsplash.com/photo-1593642702821-c8da7659772c?w=400',
                    description: 'High-performance gaming laptop with RTX graphics and fast SSD storage.',
                    brand: 'GameTech',
                    badge: 'Sale'
                },
                {
                    id: '3',
                    name: 'Designer Cotton T-Shirt',
                    price: '49.99',
                    stock: '25',
                    category: 'clothing',
                    image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
                    description: 'Premium cotton t-shirt with modern design and comfortable fit.',
                    brand: 'FashionCo',
                    badge: ''
                },
                {
                    id: '7',
                    name: 'Classic Denim Jacket',
                    price: '89.99',
                    stock: '18',
                    category: 'clothing',
                    image: 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400',
                    description: 'Timeless denim jacket with vintage wash and perfect fit.',
                    brand: 'DenimCo',
                    badge: 'Trending'
                },
                {
                    id: '4',
                    name: 'Advanced JavaScript Guide',
                    price: '39.99',
                    stock: '12',
                    category: 'books',
                    image: 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400',
                    description: 'Comprehensive guide to modern JavaScript development and best practices.',
                    brand: 'TechBooks',
                    badge: ''
                },
                {
                    id: '8',
                    name: 'UI/UX Design Principles',
                    price: '45.99',
                    stock: '20',
                    category: 'books',
                    image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                    description: 'Master the art of user interface and experience design with practical examples.',
                    brand: 'DesignBooks',
                    badge: 'Bestseller'
                },
                {
                    id: '5',
                    name: 'Smart Self-Watering Plant Pot',
                    price: '79.99',
                    stock: '20',
                    category: 'home',
                    image: 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400',
                    description: 'Intelligent plant pot with automatic watering system and mobile app control.',
                    brand: 'GreenTech',
                    badge: ''
                },
                {
                    id: '9',
                    name: 'Premium Kitchen Utensil Set',
                    price: '129.99',
                    stock: '15',
                    category: 'home',
                    image: 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400',
                    description: 'Professional-grade kitchen utensils made from stainless steel with ergonomic design.',
                    brand: 'KitchenPro',
                    badge: 'Popular'
                }
            ];
        }

        // Generate HTML for products
        function generateProductsHTML(products) {
            return products.map((product, index) => `
                <div class="col-md-6 col-lg-4 mb-4 fade-in product-item" data-category="${product.category}" style="animation-delay: ${index * 0.1}s">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="${product.image}" alt="${product.name}">
                            ${product.badge ? `<div class="product-badge">${product.badge}</div>` : ''}
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">${product.name}</h3>
                            <div class="product-price">${product.price}</div>
                            <p class="product-description">${product.description}</p>
                            <div class="product-details">
                                <small><strong>Brand:</strong> ${product.brand}</small><br>
                                <small><strong>Stock:</strong> ${product.stock} units</small>
                            </div>
                            <div class="qty-selector">
                                <button class="qty-btn" onclick="changeQty(this, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="qty-input" value="1" min="1" max="${product.stock}">
                                <button class="qty-btn" onclick="changeQty(this, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCart(this)" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}" data-stock="${product.stock}">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Get all products HTML
        function getAllProductsHTML() {
            const allProducts = getAllProductsData();
            return generateProductsHTML(allProducts);
        }

        // Quantity Controls
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

        // Add to Cart
        function addToCart(btn) {
            const card = btn.closest('.product-card');
            const qtyInput = card.querySelector('.qty-input');
            
            const item = {
                id: btn.getAttribute('data-id'),
                name: btn.getAttribute('data-name'),
                price: parseFloat(btn.getAttribute('data-price')),
                qty: parseInt(qtyInput.value),
                stock: parseInt(btn.getAttribute('data-stock'))
            };

            // Check if item already exists in cart
            const existingItem = cart.find(cartItem => cartItem.id === item.id);
            if (existingItem) {
                existingItem.qty += item.qty;
                if (existingItem.qty > existingItem.stock) {
                    existingItem.qty = existingItem.stock;
                }
            } else {
                cart.push(item);
            }

            // Add bounce animation to cart
            const cartSidebar = document.getElementById('cart-sidebar');
            cartSidebar.classList.add('cart-bounce');
            setTimeout(() => cartSidebar.classList.remove('cart-bounce'), 600);

            // Reset quantity to 1
            qtyInput.value = 1;

            updateCartDisplay();
            
            // Show success feedback
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Added!';
            btn.style.background = 'var(--success-gradient)';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart';
                btn.style.background = 'var(--primary-gradient)';
            }, 1000);
        }

        // Update Cart Display
        function updateCartDisplay() {
            const cartSidebar = document.getElementById('cart-sidebar');
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');

            if (cart.length === 0) {
                cartSidebar.style.display = 'none';
                return;
            }

            cartSidebar.style.display = 'block';
            cartItems.innerHTML = '';

            let total = 0;
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.qty;
                total += itemTotal;

                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div>
                        <div class="fw-semibold">${item.name}</div>
                        <small class="text-muted">${item.price.toFixed(2)} × ${item.qty}</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">${itemTotal.toFixed(2)}</div>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                cartItems.appendChild(cartItem);
            });

            cartTotal.textContent = `${total.toFixed(2)}`;
        }

        // Remove from Cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }

        // Go to Checkout
        function goToCheckout() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            currentPage = 'checkout';
            document.getElementById('marketplace-page').style.display = 'none';
            document.getElementById('checkout-page').style.display = 'block';
            updateCheckoutSummary();
        }

        // Back to Marketplace
        function backToMarketplace() {
            currentPage = 'marketplace';
            document.getElementById('checkout-page').style.display = 'none';
            document.getElementById('marketplace-page').style.display = 'block';
        }

        // Update Checkout Summary
        function updateCheckoutSummary() {
            const checkoutItems = document.getElementById('checkout-items');
            const subtotalEl = document.getElementById('checkout-subtotal');
            const taxEl = document.getElementById('checkout-tax');
            const totalEl = document.getElementById('checkout-total');

            checkoutItems.innerHTML = '';
            let subtotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                const checkoutItem = document.createElement('div');
                checkoutItem.className = 'd-flex justify-content-between mb-2';
                checkoutItem.innerHTML = `
                    <span>${item.name} × ${item.qty}</span>
                    <span>${itemTotal.toFixed(2)}</span>
                `;
                checkoutItems.appendChild(checkoutItem);
            });

            const shipping = 10.00;
            const tax = subtotal * 0.08; // 8% tax
            const total = subtotal + shipping + tax;

            subtotalEl.textContent = `${subtotal.toFixed(2)}`;
            taxEl.textContent = `${tax.toFixed(2)}`;
            totalEl.textContent = `${total.toFixed(2)}`;
        }

        // Payment Method Toggle
        document.querySelectorAll('input[name="payment"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const cardDetails = document.getElementById('card-details');
                if (this.id === 'credit-card') {
                    cardDetails.style.display = 'block';
                } else {
                    cardDetails.style.display = 'none';
                }
            });
        });

        // Format Card Number
        document.querySelector('input[placeholder="1234 5678 9012 3456"]')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // Format Expiry Date
        document.querySelector('input[placeholder="MM/YY"]')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // Place Order
        function placeOrder() {
            const form = document.getElementById('checkout-form');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Show loading state
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            btn.disabled = true;

            // Simulate order processing
            setTimeout(() => {
                alert('Order placed successfully! Thank you for your purchase.');
                cart = [];
                updateCartDisplay();
                backToMarketplace();
                
                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // Reset form
                form.reset();
            }, 3000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Add some initial animation delays for products
            const products = document.querySelectorAll('.product-item');
            products.forEach((product, index) => {
                product.style.animationDelay = `${index * 0.1}s`;
            });

            // Restore cart from localStorage if available
            try {
                const savedCart = JSON.parse(localStorage.getItem('marketplace_cart') || '[]');
                if (Array.isArray(savedCart) && savedCart.length > 0) {
                    cart = savedCart;
                    updateCartDisplay();
                }
            } catch (e) {
                console.log('No saved cart found');
            }
        });

        // Save cart to localStorage whenever it changes
        function saveCart() {
            try {
                localStorage.setItem('marketplace_cart', JSON.stringify(cart));
            } catch (e) {
                console.log('Could not save cart to localStorage');
            }
        }

        // Override updateCartDisplay to also save cart
        const originalUpdateCartDisplay = updateCartDisplay;
        updateCartDisplay = function() {
            originalUpdateCartDisplay();
            saveCart();
        };

        // Add smooth scrolling for better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add search functionality
        function addSearchBar() {
            const filterSection = document.querySelector('.filter-section .row');
            const searchHtml = `
                <div class="col-12 mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search products..." id="search-input">
                    </div>
                </div>
            `;
            filterSection.insertAdjacentHTML('afterbegin', searchHtml);

            // Add search functionality
            document.getElementById('search-input').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const products = document.querySelectorAll('.product-item');

                products.forEach(product => {
                    const productName = product.querySelector('.product-title').textContent.toLowerCase();
                    const productDesc = product.querySelector('.product-description').textContent.toLowerCase();
                    
                    if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                        product.style.display = 'block';
                    } else {
                        product.style.display = 'none';
                    }
                });
            });
        }

        // Initialize search bar
        setTimeout(addSearchBar, 100);
    </script>
</body>
</html>