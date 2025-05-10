@extends('business::layouts.master')

@section('title', 'Order Details')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>{{ __('Order Details') }}</h4>
                    <a href="{{ route('business.orders.index') }}" class="btn btn-primary text-white">
                        <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Orders') }}
                    </a>
                </div>
                <div class="p-16">
                    <!-- Order Summary -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Order ID') }}:</h6>
                            <p>{{ $order->invoiceNumber }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Order Date') }}:</h6>
                            <p>{{ $order->saleDate }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Customer Name') }}:</h6>
                            <p>{{ $order->party->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Delivery Type') }}:</h6>
                            <p>{{ $order->delivery_type == 1 ? 'Physical' : 'E-commerce' }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Payment Status') }}:</h6>
                            <p>{{ $order->payment_status }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Order Status') }}:</h6>
                            <span class="badge {{ $order->getStatusColorAttribute() }}">
                                {{ $order->getStatusNameAttribute() }}
                            </span>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle shadow-sm">
                            <thead>
                                <tr>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Unit Price') }}</th>
                                    <th>{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>{{ number_format($product->pivot->unit_price, 2) }}</td>
                                        <td>{{ number_format($product->pivot->quantity * $product->pivot->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Totals -->
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Subtotal') }}:</h6>
                            <p>{{ number_format($order->subtotal, 2) }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Shipping Charge') }}:</h6>
                            <p>{{ number_format($order->shipping_charge, 2) }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Tax') }}:</h6>
                            <p>{{ number_format($order->tax, 2) }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Total Amount') }}:</h6>
                            <p class="fw-bold text-success">{{ number_format($order->totalAmount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection