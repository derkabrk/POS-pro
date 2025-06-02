<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Premium Store</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary-color: #405cf5;
            --primary-gradient: linear-gradient(135deg, #405cf5 0%, #3730a3 100%);
            --secondary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #6ee7b7 0%, #3b82f6 100%);
            --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --bg-light: #f8f9fa;
            --bg-dark: #212529;
            --text-muted: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            color: #1e293b;
            line-height: 1.6;
        }

        /* Landing Page Hero Section Style */
        .section {
            padding: 80px 0;
        }

        .pb-0 {
            padding-bottom: 0 !important;
        }

        .hero-section {
            background: var(--primary-gradient);
            position: relative;
            overflow: hidden;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.1);
        }

        .bg-overlay-pattern {
            background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                             radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);
        }

        .hero-shape-svg {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
        }

        .hero-shape-svg svg {
            width: 100%;
            height: 100%;
            fill: #f8fafc;
        }

        /* Typography from Landing */
        .display-6 {
            font-size: 3.5rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .lh-base {
            line-height: 1.6;
        }

        .lead {
            font-size: 1.25rem;
            font-weight: 300;
        }

        .ff-secondary {
            font-family: 'Inter', sans-serif;
        }

        /* Card Components */
        .card {
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-body {
            padding: 2rem;
        }

        /* Button Styles */
        .btn {
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            color: white;
        }

        .btn-soft-primary {
            background: rgba(64, 92, 245, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(64, 92, 245, 0.2);
        }

        .btn-soft-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-link {
            color: var(--text-muted);
            text-decoration: none;
        }

        .btn-link:hover {
            color: var(--primary-color);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Avatar and Icon Effects */
        .avatar-sm {
            width: 2.5rem;
            height: 2.5rem;
        }

        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .icon-effect {
            transition: all 0.3s ease;
        }

        .icon-effect:hover {
            transform: scale(1.1);
        }

        /* Badge Styles */
        .badge {
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.1);
        }

        .text-success {
            color: #22c55e;
        }

        /* Loading Animation */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
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

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Filter Section */
        .filter-section {
            background: white;
            padding: 2rem;
            margin: -3rem auto 3rem;
            max-width: 1000px;
            border: 1px solid #e2e8f0;
            position: relative;
            z-index: 10;
        }

        .filter-btn {
            border: 2px solid var(--primary-color);
            background: white;
            color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            margin: 0.25rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover, 
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Product Cards */
        .product-card {
            background: white;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            position: relative;
            border: 1px solid #e2e8f0;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            height: 200px;
            background: #f8fafc;
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
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--success-gradient);
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--success-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.75rem;
        }

        .product-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        /* Category Sections */
        .category-section {
            background: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .category-header {
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
            margin-bottom: 1.5rem;
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            color: #1e293b;
        }

        .category-title i {
            margin-right: 1rem;
            color: var(--primary-color);
        }

        /* Quantity Selector */
        .qty-selector {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
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
            color: var(--text-muted);
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .qty-btn:hover {
            color: var(--primary-color);
        }

        .qty-input {
            background: transparent;
            border: none;
            text-align: center;
            width: 50px;
            font-weight: 600;
            color: #1e293b;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            background: white;
            border: 1px solid #e2e8f0;
            position: sticky;
            top: 2rem;
            max-height: calc(100vh - 4rem);
            overflow-y: auto;
        }

        .cart-header {
            background: var(--primary-color);
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        .cart-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-total {
            padding: 1.5rem;
            background: #f8fafc;
        }

        /* Form Styles */
        .form-control {
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
            outline: 2px solid rgba(64, 92, 245, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        /* Enhanced Order Summary */
        .enhanced-order-summary {
            background: white;
            padding: 2rem;
            border: 1px solid #e2e8f0;
        }

        /* Animation Classes */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease forwards;
        }

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

        /* Input Group Styling */
        .input-group-text {
            background: white;
            border-color: #e2e8f0;
            color: var(--text-muted);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .display-6 {
                font-size: 2.5rem;
            }
            
            .filter-section {
                margin: -2rem 1rem 2rem;
                padding: 1.5rem;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .cart-sidebar {
                position: relative;
                margin-top: 2rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Status alerts */
        .alert {
            border: 1px solid;
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(64, 92, 245, 0.1) 0%, rgba(55, 48, 163, 0.1) 100%);
            color: var(--primary-color);
        }

        /* Table styling */
        .table {
            overflow: hidden;
        }

        .card-header {
        }

        /* Search input styling */
        .search-input {
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem 0.75rem 3rem;
            background: white;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            z-index: 10;
        }

        /* View All Button */
        .view-all-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    {{-- Dropshipper Financier Status --}}
    @isset($financier_status)
        <div class="container mt-4">
            <div class="alert alert-info text-center">
                <strong>Financier Status:</strong> {{ $financier_status ?? 'N/A' }}
            </div>
        </div>
    @endisset

    {{-- Dropshipper Sales/Orders --}}
    @isset($sales)
        <div class="container mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <strong>Your Recent Sales/Orders</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->party->name ?? '-' }}</td>
                                <td>${{ number_format($sale->totalAmount, 2) }}</td>
                                <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                <td>{{ $sale->isPaid ? 'Paid' : 'Unpaid' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">No sales/orders found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endisset

    <!-- Loading Screen -->
    <div class="loader-container" id="loader">
        <div class="text-center">
            <div class="loader"></div>
            <div class="loader-text text-white fs-5 mt-3">Loading Marketplace...</div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" style="display: none;">
        <!-- Marketplace Page -->
        <div id="marketplace-page">
            <!-- Hero Section -->
            <section class="section pb-0 hero-section" id="hero">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-sm-10">
                            <div class="text-center mt-lg-5 pt-5">
                                <h1 class="display-6 fw-semibold mb-3 lh-base text-white">
                                    {{ $business->companyName }} <span class="text-warning">Marketplace</span>
                                </h1>
                                <p class="lead text-white-50 lh-base">{{ $business->address ?? 'Premium quality products at your fingertips' }}</p>

                                <div class="d-flex gap-2 justify-content-center mt-4">
                                    <div class="text-white">
                                        <i class="ri-star-fill text-warning me-2"></i>
                                        <span>4.9/5 Rating • 10,000+ Happy Customers</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hero Shape -->
                <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1440 120">
                        <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z" fill="#f8fafc"></path>
                    </svg>
                </div>
            </section>

            <!-- Filter Section -->
            <div class="container">
                <div class="filter-section">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-3 mb-md-0 fw-semibold">Browse by Category</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center text-md-end">
                                <button class="filter-btn active" data-view="category">
                                    <i class="ri-layout-grid-line me-1"></i>Category View
                                </button>
                                <button class="filter-btn" data-view="all">
                                    <i class="ri-apps-line me-1"></i>All Products
                                </button>
                                @foreach($categories as $category)
                                    <button class="filter-btn" data-category="{{ $category->id }}">
                                        {{ $category->categoryName }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="position-relative">
                                <i class="ri-search-line search-icon"></i>
                                <input type="text" class="form-control search-input" placeholder="Search products..." id="search-input">
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
                                <div class="category-section mb-4 fade-in">
                                    <div class="category-header d-flex align-items-center justify-content-between">
                                        <h3 class="category-title">
                                            <i class="ri-bookmark-line"></i>
                                            {{ $category->categoryName }}
                                            <span class="badge bg-primary ms-2">
                                                {{ $products->where('category_id', $category->id)->count() }} items
                                            </span>
                                        </h3>
                                        <button class="btn btn-outline-primary btn-sm view-all-btn" 
                                                data-category-id="{{ $category->id }}" 
                                                data-category-url="{{ route('marketplace.category.viewall', ['business' => $business->subdomain, 'business_id' => $business->id, 'category_id' => $category->id]) }}">
                                            <i class="ri-eye-line me-1"></i>View All
                                        </button>
                                    </div>
                                    <div class="row g-4 category-products" data-category-id="{{ $category->id }}">
                                        @foreach($products->where('category_id', $category->id) as $product)
                                            <div class="col-md-6 col-lg-4 fade-in product-item" data-category="{{ $category->id }}">
                                                <div class="product-card">
                                                    <div class="product-image">
                                                        <img src="{{ $product->productPicture ? asset($product->productPicture) : asset('demo_images/default-product.png') }}" 
                                                             alt="{{ $product->productName }}" 
                                                             onerror="this.onerror=null;this.src='https://placehold.co/400x300/f8fafc/405cf5?text=No+Image';">
                                                        @if($product->productStock < 5)
                                                            <div class="product-badge">Low Stock</div>
                                                        @elseif($product->created_at && $product->created_at->gt(now()->subDays(14)))
                                                            <div class="product-badge">New</div>
                                                        @endif
                                                    </div>
                                                    <div class="product-info">
                                                        <h3 class="product-title">{{ $product->productName }}</h3>
                                                        <div class="product-price">${{ number_format($product->productSalePrice, 2) }}</div>
                                                        <p class="product-description">{{ $product->meta['description'] ?? 'Premium quality product with excellent features.' }}</p>
                                                        <div class="d-flex justify-content-between text-muted small mb-3">
                                                            <span><strong>Brand:</strong> {{ $product->brand->brandName ?? '-' }}</span>
                                                            <span><strong>Stock:</strong> {{ $product->productStock }} units</span>
                                                        </div>
                                                        <div class="qty-selector">
                                                            <button class="qty-btn" onclick="changeQty(this, -1)">
                                                                <i class="ri-subtract-line"></i>
                                                            </button>
                                                            <input type="number" class="qty-input" value="1" min="1" max="{{ $product->productStock }}">
                                                            <button class="qty-btn" onclick="changeQty(this, 1)">
                                                                <i class="ri-add-line"></i>
                                                            </button>
                                                        </div>
                                                        <button class="btn btn-primary w-100" onclick="addToCart(this)" 
                                                                data-id="{{ $product->id }}" 
                                                                data-name="{{ $product->productName }}" 
                                                                data-price="{{ $product->productSalePrice }}" 
                                                                data-stock="{{ $product->productStock }}">
                                                            <i class="ri-shopping-cart-line me-2"></i>Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- All Products View -->
                        <div id="all-products-view" style="display: none;">
                            <div class="row g-4" id="products-container">
                                <!-- All products will be shown here when "All Products" is selected -->
                            </div>
                        </div>
                    </div>

                    <!-- Cart Sidebar -->
                    <div class="col-lg-4">
                        <div class="cart-sidebar" id="cart-sidebar" style="display: none;">
                            <div class="cart-header">
                                <h5><i class="ri-shopping-cart-line me-2"></i>Your Cart</h5>
                            </div>
                            <div id="cart-items"></div>
                            <div class="cart-total">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Total: <span id="cart-total" class="text-primary">$0.00</span></h5>
                                </div>
                                <button class="btn btn-primary w-100" onclick="goToCheckout()">
                                    <i class="ri-secure-payment-line me-2"></i>Proceed to Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Page -->
        <div id="checkout-page" style="display: none;">
            <section class="section pb-0 hero-section">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container text-center text-white">
                    <h1 class="display-6 fw-semibold mb-3">Checkout</h1>
                    <button class="btn btn-outline-light" onclick="backToMarketplace()">
                        <i class="ri-arrow-left-line me-2"></i>Back to Marketplace
                    </button>
                </div>
                <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1440 120">
                        <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z" fill="#f8fafc"></path>
                    </svg>
                </div>
            </section>

            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-4"><i class="ri-user-line me-2"></i>Billing Information</h3>
                                <form id="checkout-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">First Name *</label>
                                                <input type="text" class="form-control" name="first_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last Name *</label>
                                                <input type="text" class="form-control" name="last_name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number *</label>
                                        <input type="tel" class="form-control" name="phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address *</label>
                                        <input type="text" class="form-control" name="address" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">City *</label>
                                                <input type="text" class="form-control" name="city" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">State *</label>
                                                <input type="text" class="form-control" name="state" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">ZIP Code *</label>
                                                <input type="text" class="form-control" name="zip" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Special Instructions</label>
                                        <textarea class="form-control" name="special_instructions" rows="3" placeholder="Any special delivery instructions..."></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="enhanced-order-summary">
                            <h4 class="mb-4"><i class="ri-file-list-line me-2"></i>Order Summary</h4>
                            <div id="checkout-items" class="mb-3"></div>
                            <hr>
                            <div class="summary-details mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span id="checkout-subtotal" class="fw-semibold">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <span class="fw-semibold text-warning">$10.00</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Tax (8%)</span>
                                    <span id="checkout-tax" class="fw-semibold text-success">$0.00</span>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center h4 mb-4">
                                <strong>Total</strong>
                                <strong id="checkout-total" class="text-primary">$0.00</strong>
                            </div>
                            <button class="btn btn-primary w-100 btn-lg" onclick="placeOrder()">
                                <i class="ri-check-line me-2"></i>Place Order
                            </button>
                            <div class="text-center mt-3">
                                <small class="text-muted">By placing your order, you agree to our <a href="#" class="text-decoration-none text-primary">Terms & Conditions</a>.</small>
                            </div>
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

        // Get businessId from a global JS variable or a data attribute
        const businessId = window.businessId || {{ $business->id }};

        // Loading Screen
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loader').style.opacity = '0';
                setTimeout(() => {
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('main-content').style.display = 'block';
                    
                    // Add staggered animation to products
                    const products = document.querySelectorAll('.fade-in');
                    products.forEach((product, index) => {
                        product.style.animationDelay = `${index * 0.1}s`;
                    });
                }, 500);
            }, 1500);
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
                    categoryView.style.display = 'block';
                    allProductsView.style.display = 'none';
                } else if (view === 'all') {
                    categoryView.style.display = 'none';
                    allProductsView.style.display = 'block';
                    showAllProducts();
                } else if (category) {
                    categoryView.style.display = 'none';
                    allProductsView.style.display = 'block';
                    filterProductsByCategory(category);
                }
            });
        });

        // Search functionality
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

        // Get all products data dynamically from Blade (PHP to JS)
        function getAllProductsData() {
            return window.allProductsData || [];
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
                            <div class="d-flex justify-content-between text-muted small mb-3">
                                <span><strong>Brand:</strong> ${product.brand}</span>
                                <span><strong>Stock:</strong> ${product.stock} units</span>
                            </div>
                            <div class="qty-selector">
                                <button class="qty-btn" onclick="changeQty(this, -1)">
                                    <i class="ri-subtract-line"></i>
                                </button>
                                <input type="number" class="qty-input" value="1" min="1" max="${product.stock}">
                                <button class="qty-btn" onclick="changeQty(this, 1)">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                            <button class="btn btn-primary w-100" onclick="addToCart(this)" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}" data-stock="${product.stock}">
                                <i class="ri-shopping-cart-line me-2"></i>Add to Cart
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
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="ri-check-line me-2"></i>Added!';
            btn.classList.add('btn-success');
            btn.classList.remove('btn-primary');
            
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
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
                        <div class="fw-bold text-primary">${itemTotal.toFixed(2)}</div>
                        <button class="btn btn-sm btn-outline-danger mt-1" onclick="removeFromCart(${index})">
                            <i class="ri-delete-bin-line"></i>
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
            saveCart();
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
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Back to Marketplace
        function backToMarketplace() {
            currentPage = 'marketplace';
            document.getElementById('checkout-page').style.display = 'none';
            document.getElementById('marketplace-page').style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
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
                checkoutItem.className = 'd-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded';
                checkoutItem.innerHTML = `
                    <span class="fw-medium">${item.name} × ${item.qty}</span>
                    <span class="text-primary fw-bold">${itemTotal.toFixed(2)}</span>
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
            btn.innerHTML = '<i class="ri-loader-4-line ri-spin me-2"></i>Processing...';
            btn.disabled = true;

            // Gather form data
            const formData = new FormData(form);
            const firstName = formData.get('first_name')?.trim();
            const lastName = formData.get('last_name')?.trim();
            if (!firstName || !lastName) {
                alert('First name and last name are required.');
                btn.innerHTML = originalText;
                btn.disabled = false;
                return;
            }
            const customer_name = firstName + ' ' + lastName;
            const customer_email = formData.get('email');
            const customer_phone = formData.get('phone');
            const customer_address = formData.get('address');
            const customer_city = formData.get('city');
            const customer_state = formData.get('state');
            const customer_zip = formData.get('zip');
            const customer_instructions = formData.get('special_instructions');

            // Send AJAX request to backend
            fetch(`/marketplace/${businessId}/checkout-order`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    cart: cart,
                    customer_name,
                    customer_email,
                    customer_phone,
                    customer_address,
                    customer_city,
                    customer_state,
                    customer_zip,
                    customer_instructions
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showOrderSuccessModal(data);
                    cart = [];
                    updateCartDisplay();
                    backToMarketplace();
                    form.reset();
                    localStorage.removeItem('marketplace_cart');
                } else {
                    alert('Order failed. Please try again.');
                }
            })
            .catch(() => {
                alert('Order failed. Please try again.');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }

        // Enhanced Order Success Modal
        function showOrderSuccessModal(data) {
            // Remove any existing modal
            const oldModal = document.getElementById('order-success-modal');
            if (oldModal) oldModal.remove();

            // Create modal HTML
            const modal = document.createElement('div');
            modal.id = 'order-success-modal';
            modal.innerHTML = `
                <div style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.8);z-index:99999;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(10px);">
                    <div style="background:white;padding:3rem 2rem;max-width:400px;width:90%;text-align:center;position:relative;animation:modalFadeIn 0.5s ease;border:1px solid #e2e8f0;">
                        <div style="background:var(--success-gradient);width:80px;height:80px;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem auto;">
                            <i class='ri-check-line' style='color:#fff;font-size:2.5rem;'></i>
                        </div>
                        <h2 style="color:#1e293b;font-family:'Inter',sans-serif;font-weight:700;font-size:2rem;margin-bottom:0.75rem;">Order Placed!</h2>
                        <p style="color:#64748b;font-size:1.1rem;margin-bottom:1.5rem;line-height:1.6;">Thank you for your purchase.<br>Your order <strong>#${data.order_id || 'ORD-' + Date.now()}</strong> has been received.</p>
                        <button id="close-order-success" style="background:var(--primary-gradient);color:#fff;border:none;padding:0.75rem 2rem;font-weight:600;font-size:1rem;transition:all 0.2s;cursor:pointer;">Continue Shopping</button>
                    </div>
                </div>
                <style>
                    @keyframes modalFadeIn {
                        from { opacity: 0; transform: scale(0.9) translateY(-20px); }
                        to { opacity: 1; transform: scale(1) translateY(0); }
                    }
                </style>
            `;
            document.body.appendChild(modal);
            document.getElementById('close-order-success').onclick = function() {
                modal.style.animation = 'modalFadeOut 0.3s ease forwards';
                setTimeout(() => modal.remove(), 300);
            };
        }

        // Save cart to localStorage
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

        // View All button functionality
        function attachViewAllListeners() {
            document.querySelectorAll('.view-all-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-category-url');
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
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

            // Attach event listeners
            attachViewAllListeners();

            // Add smooth scrolling for anchor links
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
        });
    </script>

    <script>
        window.allProductsData = @json($productsArray);
    </script>
</body>
</html>