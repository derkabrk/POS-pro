@extends('business::layouts.master')

@section('title')
    {{ __('Pos Sale') }}
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="grid row  p-lr2">
            <div class="col-lg-12 return-card card">
                <!-- Quick Action Section -->
                <form action="{{ route('business.sale-returns.store') }}" method="post" enctype="multipart/form-data" class="ajaxform">
                    @csrf
                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                    <div class="mt-4 mb-3 order-form-section ">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <label>{{ __('Supplier') }}</label>
                                <input type="text" value="{{ $sale->party->name ?? '' }}" class="form-control"  placeholder="{{ __('Invoice no') }}." readonly>
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('Date') }}</label>
                                    <input type="date" class="form-control" value="{{ formatted_date($sale->saleDate, 'Y-m-d') }}" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('Invoice No') }}.</label>
                                <input type="text" value="{{ $sale->invoiceNumber }}" class="form-control"  placeholder="{{ __('Invoice no') }}." readonly>
                            </div>
                        </div>
                    </div>
                    <div class="cart-paymen mt-5">
                        <div class="table-responsive col-lg-12 mb-30">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="border table-background">{{ __('Image') }}</th>
                                    <th class="border table-background text-start">{{ __('Items') }}</th>
                                    <th class="border table-background">{{ __('Code') }}</th>
                                    <th class="border table-background">{{ __('Qty') }}</th>
                                    <th class="border table-background">{{ __('Sale Price') }}</th>
                                    <th class="border table-background">{{ __('Return Qty') }}</th>
                                    <th class="border table-background text-end">{{ __('Sub Total') }}</th>
                                </tr>
                                </thead>
                                <tbody class='text-start'>
                                @foreach($sale->details as $detail)
                                    @php
                                        // Calculate the discounted price per unit
                                        $original_price = $detail->price;
                                        $discounted_price_per_unit = $original_price - ($original_price * $discount_per_unit_factor);
                                        $sub_total = $discounted_price_per_unit * $detail->quantities;
                                    @endphp
                                    <tr data-max_qty="{{ $detail->quantities }}"
                                        data-price="{{ $detail->price }}"
                                        data-discount_per_unit_factor="{{ $discount_per_unit_factor }}"
                                        data-discounted_price_per_unit="{{ $discounted_price_per_unit }}">
                                        <td class='text-center'>
                                            <img class="table-img" src="{{ asset($detail->product->productPicture ?? 'assets/images/products/box.svg') }}">
                                        </td>
                                        <td class='text-start'>{{ $detail->product->productName ?? '' }}</td>
                                        <td class='text-center'>{{ $detail->product->productCode ?? '' }}</td>
                                        <td class='text-center'>{{ $detail->quantities ?? 0 }}</td>
                                        <td class='text-center price'>{{ currency_format($discounted_price_per_unit, 'icon', 2, business_currency()) }}</td>
                                        <td class='text-center large-td'>
                                            <div class="d-flex align-items-center gap-3">
                                                <button class="incre-decre sub-btn">
                                                    <i class="fas fa-minus icon"></i>
                                                </button>
                                                <input type="number" name="return_qty[]" value="" class="custom-number-input return-qty" placeholder="{{ __('0') }}">
                                                <button class="incre-decre add-btn">
                                                    <i class="fas fa-plus icon"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="subtotal text-end">{{ currency_format(0) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="py-3 col-lg-12">
                            <h6 class="text-end fw-bold return_amount">{{ __('Return Amount ' . currency_format($sale->totalAmount, 'icon', 2, business_currency())) }}</h6>
                        </div>
                    </div>
                    <div class="col-lg-12 delete-cancel-group">
                        <div class="button-group text-center mt-5">
                            <a href="{{ route('business.sales.index') }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                            <button class="theme-btn m-2 submit-btn">{{ __('Confirm Return') }}</button>
                        </div>
                    </div>
                </form>
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
@endsection

@push('js')
    <script src="{{ asset('assets/js/custom/sale-purchase-return.js') }}"></script>
@endpush
