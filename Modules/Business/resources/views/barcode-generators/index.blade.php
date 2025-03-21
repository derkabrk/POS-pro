@extends('business::layouts.master')

@section('main_content')
    <div class="min-vh-100">
        <div class="erp-table-section order-form-section">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-bodys">
                        <div class="table-header barcode-header p-16">
                            <h4>{{ __('Barcode Generate') }}</h4>
                        </div>
                        <form action="{{ route('business.barcodes.store') }}" class="barcodeForm p-3">
                            @csrf
                            <label>{{ __('Select Product') }}</label>
                            <div class="search-container">
                                <input type="text" id="product-search" placeholder="Search..." class="form-control" />
                                <ul id="search-results" class="barcode-dropdown search-hidden"></ul>
                            </div>
                            <div class="table-responsive mt-3 barcode-table">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th class="border barcode-table-th">{{ __('Items') }}</th>
                                            <th class="border barcode-table-th">{{ __('Code') }}</th>
                                            <th class="border barcode-table-th">{{ __('Available Stock') }}</th>
                                            <th class="border barcode-table-th">{{ __('Qty / No of label') }}</th>
                                            <th class="border barcode-table-th">{{ __('Packing Date') }}</th>
                                            <th class="border barcode-table-th">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-list">
                                        {{-- Dynamicaly load --}}
                                    </tbody>
                                </table>
                            </div>
                            {{-- --------------- table end --------------- --}}
                            <div class="table-header  p-16 mt-4 mb-3">
                                <h4>{{ __('Information to show in labels') }}</h4>
                            </div>
                            <div class="row g-3 barcode-info-row">
                                <div class="col-lg-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <input type="checkbox" name="product_name" class="select-all-delete multi-delete"
                                            checked>
                                        <p>{{ __('Product Name') }}</p>
                                    </div>

                                    <div class="d-flex align-items-center barcode-info">
                                        <h5>{{ __('Size') }}</h5>
                                        <input type="number" name="product_name_size" class="form-control"
                                            placeholder="15">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <input type="checkbox" name="product_price" class="select-all-delete multi-delete"
                                            checked>
                                        <p>{{ __('Product Price') }}</p>
                                    </div>
                                    <div class="d-flex align-items-center barcode-info">
                                        <h5>{{ __('Size') }}</h5>
                                        <input type="number" name="product_price_size" class="form-control"
                                            placeholder="14">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <input type="checkbox" name="product_code" class="select-all-delete multi-delete"
                                            checked>
                                        <p>{{ __('Product Code') }}</p>
                                    </div>
                                    <div class="d-flex align-items-center barcode-info">
                                        <h5>{{ __('Size') }}</h5>
                                        <input type="number" name="product_code_size" class="form-control"
                                            placeholder="14">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <input type="checkbox" name="pack_date" class="select-all-delete multi-delete"
                                            checked>
                                        <p>{{ __('Print packing date') }}</p>
                                    </div>

                                    <div class="d-flex align-items-center barcode-info">
                                        <h5>{{ __('Size') }}</h5>
                                        <input type="number" name="pack_date_size" class="form-control" placeholder="12">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <p>{{ __('Barcode Type *') }}</p>
                                    </div>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="barcode_type" class="form-control">
                                            @foreach ($barcode_types as $type)
                                                <option value="{{ $type['value'] }}" @selected($type['value'] == 'C128')>
                                                    {{ __($type['value']) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <p>{{ __('Barcode Print Paper Setting') }}</p>
                                    </div>
                                    <div class="gpt-up-down-arrow position-relative">
                                        <select name="barcode_setting" class="form-control">
                                            <option value="">28 Labels Per Sheet, Sheet Size: 8.27" X 11.69", Label size:
                                                2" X 1.25" </option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 d-flex justify-content-center mt-4">
                                    <button class="theme-btn m-2 submit-btn barcode-preview-btn"
                                        id="barcode-preview-btn">{{ __('Preview') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="fetch-products-route" value="{{ route('business.barcodes.products') }}">
@endsection
