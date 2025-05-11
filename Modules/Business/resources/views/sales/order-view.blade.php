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
                    <!-- Status Control Buttons -->
                    <div>
                        @foreach ($nextStatuses as $nextStatus)
                            @php
                                $statusOption = \App\Models\Sale::STATUS[$nextStatus] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                            @endphp
                            <form 
                                action="{{ route('business.sales.updatestatus') }}" 
                                method="POST" 
                                class="d-inline status-update-form"
                            >
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                                <input type="hidden" name="sale_status" value="{{ $nextStatus }}">
                                 <input type="hidden" name="redirect_from" value="confirm_user">
                                <button 
                                    type="button" 
                                    class="btn btn-sm {{ $statusOption['color'] }} text-white px-3 py-2 rounded-pill shadow-sm me-2 mb-2 status-update-btn"
                                    data-status-name="{{ $statusOption['name'] }}"
                                >
                                    {{ $statusOption['name'] }}
                                </button>
                            </form>
                        @endforeach
                    </div>
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
                        <hr> <!-- Divider -->
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Order Date') }}:</span>
                            <span class="fw-bold">{{ $sale->created_at->format('d M, Y') }}</span>
                        </div>
                        <hr> <!-- Divider -->
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Customer Name') }}:</span>
                            <span class="fw-bold">{{ $sale->party->name ?? 'N/A' }}</span>
                        </div>
                        <hr> <!-- Divider -->
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Delivery Type') }}:</span>
                            <span class="fw-bold">{{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}</span>
                        </div>
                        <hr> <!-- Divider -->
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Payment Status') }}:</span>
                            <span class="fw-bold">{{ $sale->payment_status ?? 'N/A' }}</span>
                        </div>
                        <hr> <!-- Divider -->
                        <div class="mb-4">
                            <span class="text-muted d-block mb-1">{{ __('Order Status') }}:</span>
                            @php
                                $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                            @endphp
                            <span class="badge {{ $status['color'] }} px-4 py-2 rounded-pill shadow-sm">
                                {{ $status['name'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Right Side: Products & Totals -->
                    <div class="col-lg-6">
                        <h5 class="fw-bold text-secondary mb-4">{{ __('Products') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Product Image') }}</th>
                                        <th>{{ __('Product ID') }}</th>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productsWithDetails as $product)
                                        <tr>
                                            <td>
                                                @if (!empty($product['image']))
                                                    <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                @else
                                                    <span class="text-muted">{{ __('No Image') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $product['id'] }}</td>
                                            <td>{{ $product['name'] }}</td>
                                            <td>{{ $product['category'] }}</td>
                                            <td>{{ $product['quantity'] }}</td>
                                            <td>${{ number_format($product['price'], 2) }}</td>
                                            <td>${{ number_format($product['subtotal'], 2) }}</td>
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

<!-- Add JavaScript for Confirmation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.status-update-btn');
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const statusName = this.getAttribute('data-status-name');
                const form = this.closest('form');
                if (confirm(`Are you sure you want to change the status to "${statusName}"?`)) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection