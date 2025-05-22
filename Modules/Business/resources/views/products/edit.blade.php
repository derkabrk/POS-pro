@extends('business::layouts.master')

@section('title')
    {{ __('Edit Product') }}
@endsection

@section('content')
    <div class="admin-panel-section">
        <div class="container-fluid">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Edit Product') }}</h4>
                    <a href="{{ route('business.products.index') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> {{ __('Product List') }}
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('business.products.update', $product->id) }}" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="productName" class="form-label">{{ __('Product Name') }}</label>
                                <input type="text" id="productName" name="productName" value="{{ $product->productName }}" required class="form-control" placeholder="{{ __('Enter Product Name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">{{ __('Product Category') }}</label>
                                <select name="category_id" id="category-select-edit" required class="form-select">
                                    <option value="">{{ __('Select One') }}</option>
                                    @foreach ($categories as $category)
                                        <option @selected($category->id == $product->category_id) value="{{ $category->id }}"
                                            data-capacity="{{ $category->variationCapacity }}"
                                            data-color="{{ $category->variationColor }}"
                                            data-size="{{ $category->variationSize }}"
                                            data-type="{{ $category->variationType }}"
                                            data-weight="{{ $category->variationWeight }}">
                                            {{ ucfirst($category->categoryName) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="dynamic-fields-edit" class="row">
                                {{-- loaded dynamically --}}
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="supplier_id" class="form-label">{{ __('Supplier') }}</label>
                                <select name="supplier_id" id="supplier_id" class="form-select" required>
                                    <option value="">{{ __('Select Supplier') }}</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="brand_id" class="form-label">{{ __('Product Brand') }}</label>
                                <select name="brand_id" id="brand_id" class="form-select">
                                    <option value="">{{ __('Select one') }}</option>
                                    @foreach ($brands as $brand)
                                        <option @selected($brand->id == $product->brand_id) value="{{ $brand->id }}">
                                            {{ ucfirst($brand->brandName) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="unit_id" class="form-label">{{ __('Product Unit') }}</label>
                                <select name="unit_id" id="unit_id" class="form-select">
                                    <option value="">{{ __('Select one') }}</option>
                                    @foreach ($units as $unit)
                                        <option @selected($unit->id == $product->unit_id) value="{{ $unit->id }}">
                                            {{ ucfirst($unit->unitName) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="productCode" class="form-label">{{ __('Product Code') }}</label>
                                <input type="text" id="productCode" name="productCode" value="{{ $product->productCode }}" class="form-control" placeholder="{{ __('Enter Product Code') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="productStock" class="form-label">{{ __('Stock') }}</label>
                                <input type="number" id="productStock" name="productStock" value="{{ $product->productStock }}" class="form-control" placeholder="{{ __('Enter stock qty') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="alert_qty" class="form-label">{{ __('Low Stock Qty') }}</label>
                                <input type="number" id="alert_qty" name="alert_qty" value="{{ $product->alert_qty }}" class="form-control" placeholder="{{ __('Enter alert qty') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expire_date" class="form-label">{{ __('Expire Date') }}</label>
                                <input type="date" id="expire_date" name="expire_date" value="{{ $product->expire_date }}" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="vat_id" class="form-label">{{ __('Select Vat') }}</label>
                                <select id="vat_id" name="vat_id" class="form-select">
                                    <option value="">{{ __('Select vat') }}</option>
                                    @foreach ($vats as $vat)
                                        <option value="{{ $vat->id }}" data-vat_rate="{{ $vat->rate }}" @selected($product->vat_id == $vat->id)>
                                            {{ $vat->name }} ({{ $vat->rate }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="vat_type" class="form-label">{{ __('Vat Type') }}</label>
                                <select id="vat_type" name="vat_type" class="form-select">
                                    <option value="exclusive" @selected($product->vat_type == 'exclusive')>{{ __('Exclusive') }}</option>
                                    <option value="inclusive" @selected($product->vat_type == 'inclusive')>{{ __('Inclusive') }}</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="exclusive_price" class="form-label">{{ __('Purchase Price Exclusive') }}</label>
                                <input type="number" id="exclusive_price" name="exclusive_price" value="{{ $product->vat_type == 'exclusive' ? $product->productPurchasePrice : $product->productPurchasePrice - $product->vat_amount }}" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="inclusive_price" class="form-label">{{ __('Purchase Price Inclusive') }}</label>
                                <input type="number" id="inclusive_price" name="inclusive_price" value="{{ $product->vat_type == 'inclusive' ? $product->productPurchasePrice : $product->productPurchasePrice + $product->vat_amount }}" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="profit_margin" class="form-label">{{ __('Profit Margin (%)') }}</label>
                                <input type="number" id="profit_margin" name="profit_percent" value="{{ $product->profit_percent }}" required class="form-control" placeholder="{{ __('Enter profit margin') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mrp_price" class="form-label">{{ __('MRP') }}</label>
                                <input type="number" id="mrp_price" name="productSalePrice" value="{{ $product->productSalePrice }}" required class="form-control" placeholder="{{ __('Enter sale price') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="productWholeSalePrice" class="form-label">{{ __('Wholesale Price') }}</label>
                                <input type="number" id="productWholeSalePrice" name="productWholeSalePrice" value="{{ $product->productWholeSalePrice }}" class="form-control" placeholder="{{ __('Enter wholesale price') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="productDealerPrice" class="form-label">{{ __('Dealer Price') }}</label>
                                <input type="number" id="productDealerPrice" name="productDealerPrice" value="{{ $product->productDealerPrice }}" class="form-control" placeholder="{{ __('Enter dealer price') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="productManufacturer" class="form-label">{{ __('Manufacturer') }}</label>
                                <input type="text" id="productManufacturer" name="productManufacturer" value="{{ $product->productManufacturer }}" class="form-control" placeholder="{{ __('Enter manufacturer name') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="productPicture" class="form-label">{{ __('Image') }}</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" id="productPicture" accept="image/*" name="productPicture" class="form-control me-3" data-id="image">
                                    <img src="{{ asset($product->productPicture ?? 'assets/images/icons/upload.png') }}" id="image" class="img-thumbnail" style="width: 50px; height: 50px;">
                                </div>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <a href="{{ route('business.products.index') }}" class="btn btn-secondary me-2">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden inputs to store existing product values -->
    <input type="hidden" id="capacity-value" value="{{ $product->capacity }}">
    <input type="hidden" id="color-value" value="{{ $product->color }}">
    <input type="hidden" id="size-value" value="{{ $product->size }}">
    <input type="hidden" id="type-value" value="{{ $product->type }}">
    <input type="hidden" id="weight-value" value="{{ $product->weight }}">
@endsection

