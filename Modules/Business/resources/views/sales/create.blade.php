@extends('business::layouts.master')

@section('title')
    {{ __('Pos Sale') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/calculator.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('Quick Action') }}</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('business.products.index') }}" class="btn btn-primary">
                                <i class="fas fa-box"></i> {{ __('Product List') }}
                            </a>
                            <a href="{{ route('business.sales.index', ['today' => true]) }}" class="btn btn-success">
                                <i class="fas fa-chart-line"></i> {{ __('Today Sales') }}
                            </a>
                            <button data-bs-toggle="modal" data-bs-target="#calculatorModal" class="btn btn-warning">
                                <i class="fas fa-calculator"></i> {{ __('Calculator') }}
                            </button>
                            <a href="{{ route('business.dashboard.index') }}" class="btn btn-info">
                                <i class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('business.sales.store') }}" method="post" enctype="multipart/form-data" class="ajaxform">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="invoiceNumber" class="form-label">{{ __('Invoice no') }}</label>
                                    <input type="text" name="invoiceNumber" value="{{ $invoice_no }}" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="saleDate" class="form-label">{{ __('Sale Date') }}</label>
                                    <input type="date" name="saleDate" class="form-control" value="{{ now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="party_id" class="form-label">{{ __('Select Customer') }}</label>
                                <div class="input-group">
                                    <select name="party_id" class="form-select customer-select">
                                        <option value="">{{ __('Select Customer') }}</option>
                                        <option class="guest-option" value="guest" {{ request('customer_id') == 'guest' ? 'selected' : '' }}>
                                            {{ __('Guest') }}
                                        </option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" data-type="{{ $customer->type }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->type }} {{ $customer->due ? ' ' . currency_format($customer->due, currency:business_currency()) : '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <a href="#customer-create-modal" data-bs-toggle="modal" class="btn btn-danger">
                                        <i class="fas fa-plus-square"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3" id="shipping-service-container" style="display: none;">
                                <label for="shipping_service" class="form-label">{{ __('Select Shipping Service') }}</label>
                                <select name="shipping_service_id" class="form-select shipping-select" id="shipping_service">
                                    <option value="">{{ __('Select Shipping Service') }}</option>
                                    @foreach ($shippings as $shipping)
                                        <option value="{{ $shipping->id }}" data-wilayas="{{ json_encode($shipping->shipping_wilayas) }}">
                                            {{ $shipping->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="wilaya-container" style="display: none; margin-top: 10px;">
                                <label for="wilaya-select" class="form-label">{{ __('Select Wilaya') }}</label>
                                <select name="shipping_wilaya_id" class="form-select" id="wilaya-select">
                                    <option value="">{{ __('Select Wilaya') }}</option>
                                </select>
                            </div>
                            <div id="commune-container" style="display: none; margin-top: 10px;">
                                <label for="commune-select" class="form-label">{{ __('Select Commune') }}</label>
                                <select name="commune_id" class="form-select" id="commune-select">
                                    <option value="">{{ __('Select Commune') }}</option>
                                </select>
                            </div>
                            <div class="mb-3 d-none guest_phone">
                                <label for="customer_phone" class="form-label">{{ __('Enter Customer Phone Number') }}</label>
                                <input type="text" name="customer_phone" class="form-control">
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Image') }}</th>
                                            <th>{{ __('Items') }}</th>
                                            <th>{{ __('Code') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th>{{ __('Sale Price') }}</th>
                                            <th>{{ __('Qty') }}</th>
                                            <th>{{ __('Sub Total') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-list">
                                        @include('business::sales.cart-list')
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sale_type" class="form-label">{{ __('Sale Type') }}</label>
                                        <select name="sale_type" class="form-select" id="form">
                                            <option value="1">{{ __('E-commerce Sale') }}</option>
                                            <option value="0">{{ __('Physical Sale') }}</option>
                                        </select>
                                    </div>
                                    <div id="amount-info-container" style="display: none;">
                                        <div class="mb-3">
                                            <label for="receive_amount" class="form-label">{{ __('Receive Amount') }}</label>
                                            <input name="receive_amount" type="number" step="any" id="receive_amount" min="0" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="change_amount" class="form-label">{{ __('Change Amount') }}</label>
                                            <input type="number" step="any" id="change_amount" class="form-control" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="due_amount" class="form-label">{{ __('Due Amount') }}</label>
                                            <input type="number" step="any" id="due_amount" class="form-control" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="payment_type_id" class="form-label">{{ __('Payment Type') }}</label>
                                            <select name="payment_type_id" class="form-select">
                                                @foreach($payment_types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="shipping-container" style="display: none;">
                                        <div class="mb-3">
                                            <label for="delivery_type" class="form-label">{{ __('Delivery Type') }}</label>
                                            <select name="delivery_type" class="form-select">
                                                <option value="1">{{ __('StopDesk') }}</option>
                                                <option value="0">{{ __('Home') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="parcel_type" class="form-label">{{ __('Parcel Type') }}</label>
                                            <select name="parcel_type" class="form-select">
                                                <option value="1">{{ __('New Order') }}</option>
                                                <option value="0">{{ __('Exchange') }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="delivery_address" class="form-label">{{ __('Delivery Address') }}</label>
                                            <input type="text" name="delivery_address" class="form-control">
                                        </div>
                                    </div>
                                    <button class="btn btn-danger" data-route="{{ route('business.carts.remove-all') }}">{{ __('Cancel') }}</button>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <span>{{ __('Sub Total') }}</span>
                                                <span id="sub_total">{{ currency_format(0, 'icon', 2, business_currency()) }}</span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="vat_id" class="form-label">{{ __('Vat') }}</label>
                                                <div class="input-group">
                                                    <select name="vat_id" class="form-select">
                                                        @foreach($vats as $vat)
                                                            <option value="{{ $vat->id }}" data-rate="{{ $vat->rate }}">{{ $vat->name }} ({{ $vat->rate }}%)</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="number" step="any" name="vat_amount" id="vat_amount" min="0" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="discount_type" class="form-label">{{ __('Discount') }}</label>
                                                <div class="input-group">
                                                    <select name="discount_type" class="form-select">
                                                        <option value="flat">{{ __('Flat') }} ({{ business_currency()->symbol }})</option>
                                                        <option value="percent">{{ __('Percent (%)') }}</option>
                                                    </select>
                                                    <input type="number" step="any" name="discountAmount" id="discount_amount" min="0" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="shipping_charge" class="form-label">{{ __('Shipping Charge') }}</label>
                                                <input type="number" step="any" name="shipping_charge" id="shipping_charge" class="form-control">
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>{{ __('Total Amount') }}</span>
                                                <span id="total_amount">{{ currency_format(0, 'icon', 2, business_currency()) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-3">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $currency = business_currency();
    @endphp
    <input type="hidden" id="currency_symbol" value="{{ $currency->symbol }}">
    <input type="hidden" id="currency_position" value="{{ $currency->position }}">
    <input type="hidden" id="currency_code" value="{{ $currency->code }}">
    <input type="hidden" id="get_product" value="{{ route('business.products.prices') }}">
    <input type="hidden" value="{{ route('business.carts.index') }}" id="get-cart">
    <input type="hidden" value="{{ route('business.sales.cart-data') }}" id="get-cart-data">
    <input type="hidden" value="{{ route('business.carts.remove-all') }}" id="clear-cart">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const saleTypeSelect = document.getElementById("form");
            const amount_infoContainer = document.getElementById("amount-info-container");
            const shippingServiceDiv = document.getElementById("shipping-service-container");
            const shippingContainer = document.getElementById("shipping-container");

            function toggleShippingService() {
                if (saleTypeSelect.value === "1") {
                    shippingServiceDiv.style.display = "block";
                    amount_infoContainer.style.display = "none";
                    shippingContainer.style.display = "block";
                } else {
                    shippingServiceDiv.style.display = "none";
                    amount_infoContainer.style.display = "block";
                    shippingContainer.style.display = "none";
                }
            }

            saleTypeSelect.addEventListener("change", toggleShippingService);
            toggleShippingService();
        });

        document.addEventListener("DOMContentLoaded", function () {
            const shippingServiceSelect = document.getElementById("shipping_service");
            const wilayaSelect = document.getElementById("wilaya-select");
            const communeSelect = document.getElementById("commune-select");
            const wilayaContainer = document.getElementById("wilaya-container");
            const communeContainer = document.getElementById("commune-container");

            let allWilayas = @json($wilayas ?? []);
            let allCommunes = @json($communes ?? []);

            if (!Array.isArray(allCommunes)) {
                allCommunes = [];
            }

            if (!Array.isArray(allWilayas)) {
                allWilayas = [];
            }

            shippingServiceSelect.addEventListener("change", function () {
                let selectedShipping = shippingServiceSelect.options[shippingServiceSelect.selectedIndex];
                let shippingWilayas = selectedShipping.getAttribute("data-wilayas");

                wilayaSelect.innerHTML = '<option value="">{{ __('Select Wilaya') }}</option>';
                communeSelect.innerHTML = '<option value="">{{ __('Select Commune') }}</option>';
                communeContainer.style.display = "none";

                if (shippingWilayas) {
                    let selectedWilayaIds = JSON.parse(shippingWilayas);
                    let matchedWilayas = allWilayas.filter(wilaya => selectedWilayaIds.includes(parseInt(wilaya.id)));

                    matchedWilayas.forEach(wilaya => {
                        let option = document.createElement("option");
                        option.value = wilaya.id;
                        option.textContent = wilaya.name;
                        wilayaSelect.appendChild(option);
                    });

                    wilayaContainer.style.display = "block";
                } else {
                    wilayaContainer.style.display = "none";
                }
            });

            wilayaSelect.addEventListener("change", function () {
                let selectedWilayaId = wilayaSelect.value;

                communeSelect.innerHTML = '<option value="">{{ __('Select Commune') }}</option>';

                if (selectedWilayaId) {
                    if (allCommunes.length > 0) {
                        let matchedCommunes = allCommunes.filter(commune => commune.wilaya_id == selectedWilayaId);

                        matchedCommunes.forEach(commune => {
                            let option = document.createElement("option");
                            option.value = commune.id;
                            option.textContent = commune.name;
                            communeSelect.appendChild(option);
                        });

                        communeContainer.style.display = "block";
                    }
                } else {
                    communeContainer.style.display = "none";
                }
            });
        });
    </script>
@endsection

@push('modal')
    @include('business::sales.calculator')
    @include('business::sales.category-search')
    @include('business::sales.brand-search')
    @include('business::sales.customer-create')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/sale.js') }}"></script>
    <script src="{{ asset('assets/js/custom/math.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/calculator.js') }}"></script>
@endpush