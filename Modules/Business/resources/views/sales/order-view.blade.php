@extends('business::layouts.master')

@section('title', 'Order Details')

@section('content')
@php
    $nextStatuses = \App\Models\Sale::getNextStatuses($sale->sale_status);
@endphp

@component('components.breadcrumb')
    @slot('li_1') Business @endslot
    @slot('title') Order Details @endslot
@endcomponent

<div class="row">
    <div class="col-xl-9">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title flex-grow-1 mb-0">Order #{{ $sale->tracking_id ?? 'N/A' }}</h5>
                    <div class="flex-shrink-0">
                        <!-- Status Control Buttons -->
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
                                    class="btn btn-sm {{ $statusOption['color'] }} text-white me-2 status-update-btn"
                                    data-status-name="{{ $statusOption['name'] }}"
                                >
                                    {{ $statusOption['name'] }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-nowrap align-middle table-borderless mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Product Details</th>
                                <th scope="col">Category</th>
                                <th scope="col">Item Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col" class="text-end">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productsWithDetails as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                @if (!empty($product['image']))
                                                    <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="img-fluid d-block">
                                                @else
                                                    <div class="avatar-title bg-light text-muted rounded d-flex align-items-center justify-content-center">
                                                        <i class="ri-image-line fs-16"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15">{{ $product['name'] }}</h5>
                                                <p class="text-muted mb-0">Product ID: <span class="fw-medium">{{ $product['id'] }}</span></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $product['category'] }}</td>
                                    <td>${{ number_format($product['price'], 2) }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td class="fw-medium text-end">
                                        ${{ number_format($product['subtotal'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="border-top border-top-dashed">
                                <td colspan="3"></td>
                                <td colspan="2" class="fw-medium p-0">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total :</td>
                                                <td class="text-end">${{ number_format($sale->subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping Charge :</td>
                                                <td class="text-end">${{ number_format($sale->shipping_charge, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Estimated Tax :</td>
                                                <td class="text-end">${{ number_format($sale->tax, 2) }}</td>
                                            </tr>
                                            <tr class="border-top border-top-dashed">
                                                <th scope="row">Total (USD) :</th>
                                                <th class="text-end">${{ number_format($sale->totalAmount, 2) }}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end card-->

        <div class="card">
            <div class="card-header">
                <div class="d-sm-flex align-items-center">
                    <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                    <div class="flex-shrink-0 mt-2 mt-sm-0">
                        @php
                            $status = \App\Models\Sale::STATUS[$sale->sale_status] ?? ['name' => 'Unknown', 'color' => 'bg-secondary'];
                        @endphp
                        <span class="badge {{ $status['color'] }} px-3 py-2 rounded-pill">
                            Current Status: {{ $status['name'] }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="profile-timeline">
                    <div class="accordion accordion-flush" id="orderStatusAccordion">
                        <div class="accordion-item border-0">
                            <div class="accordion-header" id="headingOrderInfo">
                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOrderInfo" aria-expanded="true" aria-controls="collapseOrderInfo">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 avatar-xs">
                                            <div class="avatar-title bg-primary rounded-circle">
                                                <i class="ri-shopping-bag-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-15 mb-0 fw-semibold">Order Information - <span class="fw-normal">{{ $sale->created_at->format('D, d M Y') }}</span></h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div id="collapseOrderInfo" class="accordion-collapse collapse show" aria-labelledby="headingOrderInfo" data-bs-parent="#orderStatusAccordion">
                                <div class="accordion-body ms-2 ps-5 pt-0">
                                    <h6 class="mb-1">Order has been placed.</h6>
                                    <p class="text-muted">{{ $sale->created_at->format('D, d M Y - h:iA') }}</p>
                                    
                                    <h6 class="mb-1">Payment Status: {{ $sale->payment_status ?? 'N/A' }}</h6>
                                    <p class="text-muted mb-0">Delivery Type: {{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end accordion-->
                </div>
            </div>
        </div><!--end card-->
    </div><!--end col-->

    <div class="col-xl-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title flex-grow-1 mb-0"><i class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i> Order Details</h5>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 vstack gap-3">
                    <li>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ri-hashtag me-2 align-middle text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fs-14 mb-1">Order ID</h6>
                                <p class="text-muted mb-0">{{ $sale->tracking_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ri-calendar-line me-2 align-middle text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fs-14 mb-1">Order Date</h6>
                                <p class="text-muted mb-0">{{ $sale->created_at->format('d M, Y') }}</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ri-truck-line me-2 align-middle text-muted fs-16"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fs-14 mb-1">Delivery Type</h6>
                                <p class="text-muted mb-0">{{ $sale->sale_type == 0 ? 'Physical' : ($sale->delivery_type == 0 ? 'Home' : 'StepDesk') }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!--end card-->

        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                    <div class="flex-shrink-0">
                        <a href="javascript:void(0);" class="link-secondary">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 vstack gap-3">
                    <li>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm rounded bg-light d-flex align-items-center justify-content-center">
                                    <i class="ri-user-line text-muted fs-16"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1">{{ $sale->party->name ?? 'N/A' }}</h6>
                                <p class="text-muted mb-0">Customer</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!--end card-->

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment Details</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Payment Status:</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">{{ $sale->payment_status ?? 'N/A' }}</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Subtotal:</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">${{ number_format($sale->subtotal, 2) }}</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Shipping:</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">${{ number_format($sale->shipping_charge, 2) }}</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Tax:</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0">${{ number_format($sale->tax, 2) }}</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <p class="text-muted mb-0">Total Amount:</p>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <h6 class="mb-0 text-success">${{ number_format($sale->totalAmount, 2) }}</h6>
                    </div>
                </div>
            </div>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->

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