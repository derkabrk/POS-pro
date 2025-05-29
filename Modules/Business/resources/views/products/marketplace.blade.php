@extends('business::layouts.master')

@section('title')
    {{ __('Marketplace') }}
@endsection

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">{{ __('Marketplace for Store') }}: <span id="store-name"></span></h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="POST" action="">
                @csrf
                <div class="mb-2">
                    <label>{{ __('Your Name') }}</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ $customer['name'] ?? '' }}" required>
                </div>
                <div class="mb-2">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="customer_email" class="form-control" value="{{ $customer['email'] ?? '' }}">
                </div>
                <div class="mb-2">
                    <label>{{ __('Phone') }}</label>
                    <input type="text" name="customer_phone" class="form-control" value="{{ $customer['phone'] ?? '' }}">
                </div>
                <input type="hidden" name="business_id" value="{{ $business_id }}">
            </form>
        </div>
        <div class="col-md-6">
            <h5>{{ __('Order History') }}</h5>
            <ul class="list-group">
                @forelse($orderHistory as $order)
                    <li class="list-group-item">
                        @php $orderProducts = json_decode($order->products, true); @endphp
                        <b>{{ __('Order #:') }}</b> {{ $order->id }}<br>
                        <b>{{ __('Date:') }}</b> {{ $order->created_at->format('Y-m-d H:i') }}<br>
                        <b>{{ __('Total:') }}</b> {{ $order->totalAmount }} {{ business_currency()->symbol }}<br>
                        <b>{{ __('Products:') }}</b>
                        <ul>
                            @foreach($orderProducts as $op)
                                <li>{{ $op['productName'] }} (x{{ $op['quantity'] }}) - {{ $op['price'] }} {{ business_currency()->symbol }}</li>
                            @endforeach
                        </ul>
                    </li>
                @empty
                    <li class="list-group-item">{{ __('No orders yet.') }}</li>
                @endforelse
            </ul>
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
                    <form action="{{ route('marketplace.order.submit', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="business_id" value="{{ $business_id }}">
                        <div class="mb-2">
                            <label>{{ __('Quantity') }}</label>
                            <input type="number" name="quantity" min="1" max="{{ $product->productStock }}" value="1" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>{{ __('Your Name') }}</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ $customer['name'] ?? '' }}" required>
                        </div>
                        <div class="mb-2">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="customer_email" class="form-control" value="{{ $customer['email'] ?? '' }}">
                        </div>
                        <div class="mb-2">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="customer_phone" class="form-control" value="{{ $customer['phone'] ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-success w-100">{{ __('Order Now') }}</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection
