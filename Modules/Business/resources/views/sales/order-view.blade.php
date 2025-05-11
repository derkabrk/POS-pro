@extends('business::layouts.master')

@section('title', 'Order Details')

@section('main_content')
@php
    $nextStatuses = \App\Models\Sale::getNextStatuses($sale->sale_status);
@endphp
<div class="erp-table-section py-5 px-4">
    <div class="container-fluid">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-primary">{{ __('Order Details') }}</h4>
                    <a href="{{ route('business.sales.index') }}" class="btn btn-primary text-white px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i> {{ __('Back to Sales') }}
                    </a>
                </div>

                <!-- Layout: Left (Client & Order Info) | Right (Products & Totals) -->
                <div class="row g-5">
                    <!-- Left Side: Client & Order Info -->
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-secondary mb-4">{{ __('Client & Order Info') }}</h5>
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Order ID') }}:</span>
                            <span class="fw-bold">{{ $sale->tracking_id ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Order Date') }}:</span>
                            <span class="fw-bold">{{ $sale->created_at->format('d M, Y') }}</span>
                        </div>
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Customer Name') }}:</span>
                            <span class="fw-bold">{{ $sale->party->name ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Delivery Type') }}:</span>
                            <span class="fw-bold">{{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}</span>
                        </div>
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Payment Status') }}:</span>
                            <span class="fw-bold">{{ $sale->payment_status ?? 'N/A' }}</span>
                        </div>
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Order Status') }}:</span>
                            @php
                                $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                            @endphp
                            <span class="badge {{ $status['color'] }} px-4 py-2 rounded-pill shadow-sm">
                                {{ $status['name'] }}
                            </span>
                        </div>
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Status Control') }}:</span>
                            <div>
                                @foreach ($nextStatuses as $nextStatus)
                                    @php
                                        $statusOption = \App\Models\Sale::STATUS[$nextStatus] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                                    @endphp
                                    <button 
                                        class="btn btn-sm {{ $statusOption['color'] }} text-white px-3 py-2 rounded-pill shadow-sm me-2 mb-2 update-status-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateStatusModal"
                                        data-sale-id="{{ $sale->id }}"
                                        data-next-status="{{ $nextStatus }}"
                                    >
                                        {{ $statusOption['name'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Products & Totals -->
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-secondary mb-4">{{ __('Products') }}</h5>
                        <div class="table-responsive mb-4">
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
                        <h5 class="fw-bold text-secondary mb-4">{{ __('Order Totals') }}</h5>
                        <div class="mb-3">
                            <span class="text-muted d-block mb-1">{{ __('Subtotal') }}:</span>
                            <span class="fw-bold">${{ number_format($sale->subtotal, 2) }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted d-block mb-1">{{ __('Shipping Charge') }}:</span>
                            <span class="fw-bold">${{ number_format($sale->shipping_charge, 2) }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted d-block mb-1">{{ __('Tax') }}:</span>
                            <span class="fw-bold">${{ number_format($sale->tax, 2) }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted d-block mb-1 fw-bold">{{ __('Total Amount') }}:</span>
                            <span class="fw-bold text-success">${{ number_format($sale->totalAmount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection