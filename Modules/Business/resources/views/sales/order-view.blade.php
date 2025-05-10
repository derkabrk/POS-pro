@extends('business::layouts.master')

@section('title', 'Order Details')

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-primary">{{ __('Order Details') }}</h4>
                    <a href="{{ route('business.sales.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Sales') }}
                    </a>
                </div>

                <!-- Layout: Left (Products & Totals) | Right (Client & Order Info) -->
                <div class="row g-4">
                    <!-- Left Side: Products & Totals -->
                    <div class="col-lg-8">
                        <!-- Product Details -->
                        <div class="table-responsive mb-4">
                            <h5 class="fw-bold text-secondary">{{ __('Products') }}</h5>
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
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
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="fw-bold text-secondary">{{ __('Subtotal') }}</h6>
                                    <p class="mb-0">${{ number_format($sale->subtotal, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="fw-bold text-secondary">{{ __('Shipping Charge') }}</h6>
                                    <p class="mb-0">${{ number_format($sale->shipping_charge, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="fw-bold text-secondary">{{ __('Tax') }}</h6>
                                    <p class="mb-0">${{ number_format($sale->tax, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-3 border rounded bg-light">
                                    <h6 class="fw-bold text-secondary">{{ __('Total Amount') }}</h6>
                                    <p class="fw-bold text-success mb-0">${{ number_format($sale->totalAmount, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Client & Order Info -->
                    <div class="col-lg-4">
                        <div class="p-3 border rounded bg-light mb-4">
                            <h6 class="fw-bold text-secondary">{{ __('Order ID') }}</h6>
                            <p class="mb-0">{{ $sale->tracking_id ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 border rounded bg-light mb-4">
                            <h6 class="fw-bold text-secondary">{{ __('Order Date') }}</h6>
                            <p class="mb-0">{{ $sale->created_at->format('d M, Y') }}</p>
                        </div>
                        <div class="p-3 border rounded bg-light mb-4">
                            <h6 class="fw-bold text-secondary">{{ __('Customer Name') }}</h6>
                            <p class="mb-0">{{ $sale->party->name ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 border rounded bg-light mb-4">
                            <h6 class="fw-bold text-secondary">{{ __('Delivery Type') }}</h6>
                            <p class="mb-0">{{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}</p>
                        </div>
                        <div class="p-3 border rounded bg-light mb-4">
                            <h6 class="fw-bold text-secondary">{{ __('Payment Status') }}</h6>
                            <p class="mb-0">{{ $sale->payment_status ?? 'N/A' }}</p>
                        </div>
                        <div class="p-3 border rounded bg-light">
                            <h6 class="fw-bold text-secondary">{{ __('Order Status') }}</h6>
                            @php
                                $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                            @endphp
                            <span class="badge {{ $status['color'] }} px-3 py-2 rounded-pill">
                                {{ $status['name'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection