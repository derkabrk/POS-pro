@extends('admin::layouts.master')

@section('title')
    {{ __('Pos Sale') }}
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/calculator.css') }}">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('Quick Action') }}</h4>
                        <div class="btn-group">
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
                        <form action="{{ route('business.sales.update', $sale->id) }}" method="post" enctype="multipart/form-data" class="ajaxform">
                            @csrf
                            @method('put')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="saleDate">{{ __('Sale Date') }}</label>
                                        <input type="date" name="saleDate" class="form-control" value="{{ formatted_date($sale->saleDate, 'Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="invoiceNumber">{{ __('Invoice Number') }}</label>
                                        <input type="text" name="invoiceNumber" value="{{ $sale->invoiceNumber }}" class="form-control" placeholder="{{ __('Invoice no') }}.">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="party_id">{{ __('Customer') }}</label>
                                        <div class="input-group">
                                            <select name="party_id" class="form-select customer-select">
                                                <option value="">{{ __('Select Customer') }}</option>
                                                <option class="guest-option" value="guest" @selected($sale->party_id === null || $sale->party_id === 'guest')>
                                                    {{ __('Guest') }}
                                                </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" data-type="{{ $customer->type }}" @selected($sale->party_id == $customer->id)>
                                                        {{ $customer->name }} ({{ $customer->type }}{{ $customer->due ? ' ' . currency_format($customer->due, currency:business_currency()) : '' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <a href="{{ route('business.parties.create', ['type' => 'Customer']) }}" class="btn btn-danger">
                                                <i class="fas fa-plus-square"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3 {{ $sale->party_id === null || $sale->party_id === 'guest' ? '' : 'd-none' }} guest_phone">
                                    <div class="form-group">
                                        <label for="customer_phone">{{ __('Customer Phone') }}</label>
                                        <input type="text" name="customer_phone" class="form-control" id="customer_phone" placeholder="{{ __('Enter Customer Phone Number') }}" value="{{ $sale->meta['customer_phone'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered">
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
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="receive_amount">{{ __('Receive Amount') }}</label>
                                                <input name="receive_amount" type="number" step="any" id="receive_amount" value="{{ $sale->paidAmount }}" min="0" class="form-control" placeholder="0">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="change_amount">{{ __('Change Amount') }}</label>
                                                <input type="number" step="any" id="change_amount" class="form-control" placeholder="0" readonly>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="due_amount">{{ __('Due Amount') }}</label>
                                                <input type="number" step="any" id="due_amount" class="form-control" placeholder="0" readonly>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="payment_type_id">{{ __('Payment Type') }}</label>
                                                <select name="payment_type_id" class="form-select">
                                                    @foreach($payment_types as $type)
                                                        <option value="{{ $type->id }}" @selected($sale->payment_type_id == $type->id || ($sale->payment_type_id === null && $sale->paymentType == $type->name))>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="note">{{ __('Note') }}</label>
                                                <input type="text" name="note" value="{{ $sale->meta['note'] ?? '' }}" class="form-control" placeholder="{{ __('Type note...') }}">
                                            </div>
                                            <button class="btn btn-danger w-100" data-route="{{ route('business.carts.remove-all') }}">{{ __('Cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <span>{{ __('Sub Total') }}</span>
                                                <span id="sub_total">{{ currency_format(0, 'icon', 2, business_currency()) }}</span>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="vat_id">{{ __('Vat') }}</label>
                                                <div class="input-group">
                                                    <select name="vat_id" class="form-select vat_select">
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($vats as $vat)
                                                            <option value="{{ $vat->id }}" data-rate="{{ $vat->rate }}" @selected($sale->vat_id == $vat->id)>{{ $vat->name }} ({{ $vat->rate }}%)</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="number" step="any" name="vat_amount" id="vat_amount" value="{{ ($sale->vat_amount ?? 0) != 0 ? $sale->vat_amount : (($sale->vat_percent ?? 0) != 0 ? $sale->vat_percent : 0) }}" min="0" class="form-control" placeholder="{{ __('0') }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="discount_type">{{ __('Discount') }}</label>
                                                <div class="input-group">
                                                    <select name="discount_type" class="form-select discount_type">
                                                        <option value="flat" @selected($sale->discount_type == 'flat')>{{ __('Flat') }} ({{ business_currency()->symbol }})</option>
                                                        <option value="percent" @selected($sale->discount_type == 'percent')>{{ __('Percent (%)') }}</option>
                                                    </select>
                                                    <input type="number" step="any" name="discountAmount" value="{{ $sale->discount_type == 'percent' ? $sale->discount_percent : $sale->discountAmount }}" id="discount_amount" min="0" class="form-control" placeholder="{{ __('0') }}">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="shipping_charge">{{ __('Shipping Charge') }}</label>
                                                <input type="number" step="any" name="shipping_charge" value="{{ $sale->shipping_charge }}" id="shipping_charge" class="form-control" placeholder="0">
                                            </div>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>{{ __('Total Amount') }}</span>
                                                <span id="total_amount">{{ currency_format(0, 'icon', 2, business_currency()) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-100 mt-3">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Products') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('business.sales.product-filter') }}" method="post" class="product-filter mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('Search product...') }}">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between mb-3">
                            <button class="btn btn-secondary" data-bs-toggle="offcanvas" data-bs-target="#category-search-modal">{{ __('Category') }}</button>
                            <button class="btn btn-secondary" data-bs-toggle="offcanvas" data-bs-target="#brand-search-modal">{{ __('Brand') }}</button>
                        </div>
                        <div class="product-list-container">
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
