@extends('business::layouts.master')

@section('title')
    {{ __('Pos Sale') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/calculator.css') }}">
@endpush

@section('main_content')
    <div class="container-fluid">
        <div class="grid row p-lr2 sales-main-container">
            <div class="sales-container">
                <!-- Quick Action Section -->
                <div class="quick-act-header">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <div class="mb-2 mb-sm-0">
                            <h4 class='quick-act-title'>{{ __('Quick Action') }}</h4>
                        </div>
                        <div class="quick-actions-container">
                            <a href="{{ route('business.products.index') }}"
                                class='save-product-btn d-flex align-items-center gap-1'>
                                <img src="{{ asset('assets/images/icons/product.svg') }}" alt="">
                                {{ __('Product List') }}
                            </a>

                            <a href="{{ route('business.sales.index', ['today' => true]) }}"
                                class='sales-btn d-flex align-items-center gap-1'>
                                <img src="{{ asset('assets/images/icons/sales.svg') }}" alt="">
                                {{ __('Today Sales') }}
                            </a>

                            <button data-bs-toggle="modal" data-bs-target="#calculatorModal"
                                class='calculator-btn d-flex align-items-center gap-1'>
                                <img src="{{ asset('assets/images/icons/calculator.svg') }}" alt="">
                                {{ __('Calculator') }}
                            </button>

                            <a href="{{ route('business.dashboard.index') }}"
                                class='dashboard-btn d-flex align-items-center gap-1'>
                                <img src="{{ asset('assets/images/icons/dashboard.svg') }}" alt="">
                                {{ __('Dashboard') }}
                            </a>
                        </div>
                    </div>
                </div>
                <form action="{{ route('business.sales.update', $sale->id) }}" method="post" enctype="multipart/form-data"
                    class="ajaxform">
                    @csrf
                    @method('put')
                    <div class="mt-4 mb-3">
                        <div class="row g-3">
                            <!-- First Row -->
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <input type="date" name="saleDate" class="form-control"
                                        value="{{ formatted_date($sale->saleDate, 'Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="invoiceNumber" value="{{ $sale->invoiceNumber }}"
                                    class="form-control" placeholder="{{ __('Invoice no') }}.">
                            </div>
                            <div class="col-12 ">
                                <div class="input-group">
                                    <select name="party_id" class="form-select customer-select"
                                        aria-label="Select Customer">
                                        <option value="">{{ __('Select Customer') }}</option>
                                        <option class="guest-option" value="guest" @selected($sale->party_id === null || $sale->party_id === 'guest')>
                                            {{ __('Guest') }}</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" data-type="{{ $customer->type }}"
                                                @selected($sale->party_id == $customer->id)>{{ $customer->name }} ({{ $customer->type }}{{ $customer->due ? ' ' . currency_format($customer->due, currency:business_currency()) : '' }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <a href="{{ route('business.parties.create', ['type' => 'Customer']) }}"
                                        class="btn btn-danger d-flex justify-content-center align-items-center"
                                        type="button">
                                        <img src="{{ asset('assets/images/icons/plus-square.svg') }}" alt="">
                                    </a>
                                </div>
                            </div>
                            <div
                                class="col-12 mt-3 {{ $sale->party_id === null || $sale->party_id === 'guest' ? '' : 'd-none' }} guest_phone">
                                <input type="text" name="customer_phone" class="form-control" id="customer_phone"
                                    placeholder="{{ __('Enter Customer Phone Number') }}"
                                    value="{{ $sale->meta['customer_phone'] ?? '' }}">
                            </div>

                        </div>
                    </div>
                    <div class="cart-payment">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="border table-background">{{ __('Image') }}</th>
                                        <th class="border table-background">{{ __('Items') }}</th>
                                        <th class="border table-background">{{ __('Code') }}</th>
                                        <th class="border table-background">{{ __('Unit') }}</th>
                                        <th class="border table-background">{{ __('Sale Price') }}</th>
                                        <th class="border table-background">{{ __('Qty') }}</th>
                                        <th class="border table-background">{{ __('Sub Total') }}</th>
                                        <th class="border table-background">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class='text-start' id="cart-list">
                                    @include('business::sales.cart-list')
                                </tbody>
                            </table>
                        </div>

                        <div class="hr-container">
                            <hr>
                        </div>

                        <!-- Make Payment Section start -->
                        <div class="grid row py-3 payment-section">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="amount-info-container">
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Receive Amount') }}</h6>
                                        <input name="receive_amount" type="number" step="any" id="receive_amount"
                                            value="{{ $sale->paidAmount }}" min="0" class="form-control"
                                            placeholder="0">
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Change Amount') }}</h6>
                                        <input type="number" step="any" id="change_amount" class="form-control"
                                            placeholder="0" readonly>
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Due Amount') }}</h6>
                                        <input type="number" step="any" id="due_amount" class="form-control"
                                            placeholder="0" readonly>
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Payment Type') }}</h6>
                                        <select name="payment_type_id" class="form-select" id='form-ware'>
                                            @foreach($payment_types as $type)
                                            {{-- If payment_type_id does not exist compare with paymantType --}}
                                            <option value="{{ $type->id }}" @selected($sale->payment_type_id == $type->id || ($sale->payment_type_id === null && $sale->paymentType == $type->name))>
                                                {{ $type->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Note') }}</h6>
                                        <input type="text" name="note" value="{{ $sale->meta['note'] ?? '' }}"
                                            class="form-control" placeholder="{{ __('Type note...') }}">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="save-btn cancel-sale-btn"
                                        data-route="{{ route('business.carts.remove-all') }}">{{ __('Cancel') }}</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="payment-container mb-3 amount-info-container">
                                    <div class="mb-2 d-flex align-items-center justify-content-between">
                                        <h6>{{ __('Sub Total') }}</h6>
                                        <h6 class="fw-bold" id="sub_total">
                                            {{ currency_format(0, 'icon', 2, business_currency()) }}</h6>
                                    </div>
                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Vat') }}</h6>
                                        <div class="col-6 w-100 d-flex justify-content-between gap-2">
                                            <div class="d-flex d-flex align-items-center gap-2">
                                                <select name="vat_id" class="form-select vat_select" id='form-ware'>
                                                    <option value="">{{ __('Select') }}</option>
                                                    @foreach($vats as $vat)
                                                        <option value="{{ $vat->id }}" data-rate="{{ $vat->rate }}" @selected($sale->vat_id == $vat->id)>{{ $vat->name }} ({{ $vat->rate }}%)</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="number" step="any" name="vat_amount" id="vat_amount"
                                                   value="{{ ($sale->vat_amount ?? 0) != 0 ? $sale->vat_amount : (($sale->vat_percent ?? 0) != 0 ? $sale->vat_percent : 0) }}"
                                                   min="0" class="form-control right-start-input" placeholder="{{ __('0') }}" readonly>
                                        </div>
                                    </div>

                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Discount') }}</h6>
                                        <div class="col-6 w-100 d-flex justify-content-between gap-2">
                                            <div class="d-flex d-flex align-items-center gap-2">
                                                <select name="discount_type" class="form-select discount_type" id='form-ware'>
                                                    <option value="flat" @selected($sale->discount_type == 'flat')>{{ __('Flat') }} ({{ business_currency()->symbol }})</option>
                                                    <option value="percent" @selected($sale->discount_type == 'percent')>{{ __('Percent (%)') }}</option>
                                                </select>
                                            </div>
                                            <input type="number" step="any" name="discountAmount" value="{{ $sale->discount_type == 'percent' ? $sale->discount_percent : $sale->discountAmount }}" id="discount_amount" min="0" class="right-start-input form-control" placeholder="{{ __('0') }}">
                                        </div>
                                    </div>

                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Shipping Charge') }}</h6>
                                        <div class="col-12">
                                            <input type="number" step="any" name="shipping_charge" value="{{ $sale->shipping_charge }}" id="shipping_charge" class="form-control right-start-input" placeholder="0">
                                        </div>
                                    </div>

                                    <div class=" d-flex align-items-center justify-content-between fw-bold">
                                        <div class="fw-bold">{{ __('Total Amount') }}</div>
                                        <h6 class='fw-bold' id="total_amount">
                                            {{ currency_format(0, 'icon', 2, business_currency()) }}</h6>
                                    </div>

                                </div>
                                <div class="mt-2">
                                    <button class="submit-btn payment-btn">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </div>
                        <!-- Make Payment Section end -->
                    </div>
                </form>
            </div>
            <div class=" main-container">
                <!-- Products Header -->
                <div class="products-header">
                    <div class="container-fluid p-0">
                        <div class="row g-2 w-100 align-items-center search-product">
                            <div class="w-100">
                                <!-- Search Input and Add Button -->
                                <form action="{{ route('business.sales.product-filter') }}" method="post" class="product-filter" table="#products-list">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="text" name="search" class="form-control search-input"
                                            placeholder="{{ __('Search product...') }}">
                                        <button class="btn btn-search">
                                            <i class="far fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="w-100 d-flex align-items-center gap-2">
                                <!-- Category Button -->
                                <a data-bs-toggle="offcanvas" data-bs-target="#category-search-modal"
                                    aria-controls="offcanvasRight"
                                    class="btn btn-category w-100">{{ __('Category') }}</a>
                                <!-- Brand Button -->
                                <a data-bs-toggle="offcanvas" data-bs-target="#brand-search-modal"
                                    aria-controls="offcanvasRight" class="btn btn-brand w-100">{{ __('Brand') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="products-container">
                    <div class="p-3 scroll-card">
                        <div class="search-product-card products gap-2 @if (count($products) === 1) single-product @endif product-list-container"
                            id="products-list">
                            @include('business::sales.product-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $currency = business_currency();
    @endphp
    {{-- Hidden input fields to store currency details --}}
    <input type="hidden" id="currency_symbol" value="{{ $currency->symbol }}">
    <input type="hidden" id="currency_position" value="{{ $currency->position }}">
    <input type="hidden" id="currency_code" value="{{ $currency->code }}">

    <input type="hidden" id="get_product" value="{{ route('business.products.prices') }}">
    <input type="hidden" value="{{ route('business.carts.index') }}" id="get-cart">
    <input type="hidden" value="{{ route('business.sales.cart-data') }}" id="get-cart-data">
    <input type="hidden" value="{{ route('business.carts.remove-all') }}" id="clear-cart">
@endsection

@push('modal')
    @include('business::sales.calculator')
    @include('business::sales.category-search')
    @include('business::sales.brand-search')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/sale.js') }}"></script>
    <script src="{{ asset('assets/js/custom/calculator.js') }}"></script>
@endpush
