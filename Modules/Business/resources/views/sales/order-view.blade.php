@extends('business::layouts.master')

@section('title', 'Order Details')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm">
            <div class="card-bodys">
                <div class="table-header p-16 d-flex justify-content-between align-items-center">
                    <h4>{{ __('Order Details') }}</h4>
                    <a href="{{ route('business.sales.index') }}" class="btn btn-primary text-white">
                        <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Sales') }}
                    </a>
                </div>
                <div class="p-16">
                    <!-- Order Summary -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Order ID') }}:</h6>
                            <p>{{ $sale->tracking_id ?? 'N/A' }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Order Date') }}:</h6>
                            <p>{{ $sale->created_at->format('d M, Y') }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Customer Name') }}:</h6>
                            <p>{{ $sale->party->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Delivery Type') }}:</h6>
                            <p>{{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Payment Status') }}:</h6>
                            <p>{{ $sale->payment_status ?? 'N/A' }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Order Status') }}:</h6>
                            @php
                                $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                            @endphp
                            <span class="badge {{ $status['color'] }}">
                                {{ $status['name'] }}
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
                                @foreach ($sale->details as $detail)
                                    <tr>
                                        <td>{{ $detail->product->productName ?? 'N/A' }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>${{ number_format($detail->unit_price, 2) }}</td>
                                        <td>${{ number_format($detail->quantity * $detail->unit_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Totals -->
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Subtotal') }}:</h6>
                            <p>${{ number_format($sale->subtotal, 2) }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Shipping Charge') }}:</h6>
                            <p>${{ number_format($sale->shipping_charge, 2) }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Tax') }}:</h6>
                            <p>${{ number_format($sale->tax, 2) }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="fw-bold">{{ __('Total Amount') }}:</h6>
                            <p class="fw-bold text-success">${{ number_format($sale->totalAmount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection