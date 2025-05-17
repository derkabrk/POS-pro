@extends('business::layouts.master')

@section('title')
    {{ __('Purchase') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/calculator.css') }}">
@endpush

@section('main_content')
    <div class="container-fluid">
        <div class="grid row sales-main-container  p-lr2">
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
                            <a href="{{ route('business.purchases.index', ['today' => true]) }}"
                                class='sales-btn d-flex align-items-center gap-1'>
                                <img src="{{ asset('assets/images/icons/sales.svg') }}" alt="">
                                {{ __('Today Purchase') }}
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
                <form action="{{ route('business.purchases.update', $purchase->id) }}" method="post"
                    enctype="multipart/form-data" class="ajaxform">
                    @csrf
                    @method('put')
                    <div class="mt-4 mb-3">
                        <div class="row g-3">
                            <!-- First Row -->

                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <input type="date" name="purchaseDate" class="form-control"
                                        value="{{ formatted_date($purchase->purchaseDate, 'Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="invoiceNumber" value="{{ $purchase->invoiceNumber }}"
                                    class="form-control" placeholder="{{ __('Invoice no') }}.">
                            </div>

                            <div class="col-12 ">
                                <div class="input-group">
                                    <select name="party_id" class="form-select" aria-label="Select Customer" required>
                                        <option value="">{{ __('Select Supplier') }}</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" @selected($purchase->party_id == $supplier->id)>
                                                {{ $supplier->name }} ({{ __('Due: ') }}
                                                {{ currency_format($supplier->due, 'icon', 2, business_currency()) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <a href="{{ route('business.parties.create', ['type' => 'Supplier']) }}"
                                        class="btn btn-danger d-flex justify-content-center align-items-center"
                                        type="button">
                                        <img src="{{ asset('assets/images/icons/plus-square.svg') }}" alt="">
                                    </a>
                                </div>
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
                                        <th class="border table-background">{{ __('Purchase Price') }}</th>
                                        <th class="border table-background">{{ __('Qty') }}</th>
                                        <th class="border table-background">{{ __('Sub Total') }}</th>
                                        <th class="border table-background">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class='text-start' id="purchase_cart_list">
                                    @include('business::purchases.cart-list')
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
                                        <h6 class="payment-title">{{ __('Paid Amount') }}</h6>
                                        <input name="receive_amount" type="number" step="any" id="receive_amount"
                                            value="{{ $purchase->paidAmount }}" min="0" class="form-control"
                                            placeholder="{{ currency_format(0, 'icon', 2, business_currency()) }}">
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Change Amount') }}</h6>
                                        <input type="number" step="any" id="change_amount" class="form-control"
                                            placeholder="{{ currency_format(0, 'icon', 2, business_currency()) }}"
                                            readonly>
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Due Amount') }}</h6>
                                        <input type="number" step="any" id="due_amount" class="form-control"
                                            placeholder="{{ currency_format(0, 'icon', 2, business_currency()) }}"
                                            readonly>
                                    </div>
                                    <div class="row amount-container  align-items-center mb-2">
                                        <h6 class="payment-title">{{ __('Payment Type') }}</h6>
                                        <select name="payment_type_id" class="form-select" id='form-ware'>
                                            @foreach($payment_types as $type)
                                                {{-- If payment_type_id does not exist compare with paymantType --}}
                                                <option value="{{ $type->id }}" @selected($purchase->payment_type_id == $type->id || ($purchase->payment_type_id === null && $purchase->paymentType == $type->name))>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <h6 class="fw-bold" id="sub_total">{{ currency_format(0) }}</h6>
                                    </div>
                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Vat') }}</h6>
                                        <div class="col-6 w-100 d-flex justify-content-between gap-2">
                                            <div class="d-flex d-flex align-items-center gap-2">
                                                <select name="vat_id" class="form-select vat_select" id='form-ware'>
                                                    <option value="">{{ __('Select') }}</option>
                                                    @foreach($vats as $vat)
                                                        <option value="{{ $vat->id }}" data-rate="{{ $vat->rate }}" @selected($purchase->vat_id == $vat->id)>{{ $vat->name }} ({{ $vat->rate }}%)</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="number" step="any" name="vat_amount" id="vat_amount"
                                                   value="{{ ($purchase->vat_amount ?? 0) != 0 ? $purchase->vat_amount : (($purchase->vat_percent ?? 0) != 0 ? $purchase->vat_percent : 0) }}"
                                                   min="0" class="form-control right-start-input" placeholder="{{ __('0') }}" readonly>
                                        </div>
                                    </div>

                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Discount') }}</h6>
                                        <div class="col-6 w-100 d-flex justify-content-between gap-2">
                                            <div class="d-flex d-flex align-items-center gap-2">
                                                <select name="discount_type" class="form-select discount_type" id='form-ware'>
                                                    <option value="flat" @selected($purchase->discount_type == 'flat')>{{ __('Flat') }} ({{ business_currency()->symbol }})</option>
                                                    <option value="percent" @selected($purchase->discount_type == 'percent')>{{ __('Percent (%)') }}</option>
                                                </select>
                                            </div>
                                            <input type="number" step="any" name="discountAmount" value="{{ $purchase->discount_type == 'percent' ? $purchase->discount_percent : $purchase->discountAmount }}" id="discount_amount" min="0" class="form-control right-start-input" placeholder="{{ __('0') }}">
                                        </div>
                                    </div>

                                    <div class="row save-amount-container  align-items-center mb-2">
                                        <h6 class="payment-title col-6">{{ __('Shipping Charge') }}</h6>
                                        <div class="col-12">
                                            <input type="number" step="any" name="shipping_charge" value="{{ $purchase->shipping_charge }}" id="shipping_charge" class="form-control right-start-input" placeholder="0">
                                        </div>
                                    </div>

                                    <div class=" d-flex align-items-center justify-content-between fw-bold">
                                        <div class="fw-bold">{{ __('Total Amount') }}</div>
                                        <h6 class='fw-bold' id="total_amount">
                                            {{ currency_format($purchase->totalAmount, 'icon', 2, business_currency()) }}
                                        </h6>
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
                                <form action="{{ route('business.purchases.product-filter') }}" method="post"
                                    class="w-100 product-filter" table="#products-list">
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
                            <!-- Category Button -->
                            <div class="d-flex align-items-center justify-content-end gap-2 ">
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
                            @include('business::purchases.product-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('business::purchases.product-modal')

    @php
        $currency = business_currency();
    @endphp
    {{-- Hidden input fields to store currency details --}}
    <input type="hidden" id="currency_symbol" value="{{ $currency->symbol }}">
    <input type="hidden" id="currency_position" value="{{ $currency->position }}">
    <input type="hidden" id="currency_code" value="{{ $currency->code }}">

    <input type="hidden" id="get_product" value="{{ route('business.products.prices') }}">
    <input type="hidden" value="{{ route('business.purchases.cart') }}" id="purchase-cart">
    <input type="hidden" value="{{ route('business.carts.remove-all') }}" id="clear-cart">
@endsection

@push('modal')
    @include('business::purchases.calculator')
    @include('business::purchases.category-search')
    @include('business::purchases.brand-search')
@endpush

@push('js')
    <script src="{{ asset('assets/js/custom/purchase.js') }}"></script>
    <script src="{{ asset('assets/js/custom/math.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/calculator.js') }}"></script>
@endpush
