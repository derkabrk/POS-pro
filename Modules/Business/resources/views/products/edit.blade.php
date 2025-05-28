@extends('business::layouts.master')

@section('title')
    {{ __('Edit Product') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Edit Product')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('business.products.index') }}" class="btn btn-primary {{ Route::is('business.products.edit') ? 'active' : '' }}">
                            <i class="far fa-list" aria-hidden="true"></i> {{ __('Product List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('business.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            @method('PUT')
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productName" class="form-label">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="productName" name="productName" value="{{ $product->productName }}" required class="form-control" placeholder="{{ __('Enter Product Name') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="category-select" class="form-label">{{ __('Product Category') }} <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category-select" required class="form-select">
                                        <option value="">{{ __('Select One') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" data-capacity="{{ $category->variationCapacity }}" data-color="{{ $category->variationColor }}" data-size="{{ $category->variationSize }}" data-type="{{ $category->variationType }}" data-weight="{{ $category->variationWeight }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ ucfirst($category->categoryName) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="dynamic-fields" class="row">
                                    {{-- load dynamically --}}
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="supplier_id" class="form-label">{{ __('Supplier') }} <span class="text-danger">*</span></label>
                                    <select name="supplier_id" id="supplier_id" class="form-select" required>
                                        <option value="">{{ __('Select Supplier') }}</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="brand_id" class="form-label">{{ __('Product Brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-select">
                                        <option value="">{{ __('Select one') }}</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ ucfirst($brand->brandName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="unit_id" class="form-label">{{ __('Product Unit') }}</label>
                                    <select name="unit_id" id="unit_id" class="form-select">
                                        <option value="">{{ __('Select one') }}</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ $product->unit_id == $unit->id ? 'selected' : '' }}>{{ ucfirst($unit->unitName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productCode" class="form-label">{{ __('Product Code') }}</label>
                                    <input type="text" id="productCode" value="{{ $product->productCode }}" name="productCode" class="form-control" placeholder="{{ __('Enter Product Code') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productStock" class="form-label">{{ __('Stock') }}</label>
                                    <input type="number" id="productStock" name="productStock" value="{{ $product->productStock }}" class="form-control" placeholder="{{ __('Enter stock qty') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="alert_qty" class="form-label">{{ __('Low Stock Qty') }}</label>
                                    <input type="number" id="alert_qty" step="any" name="alert_qty" value="{{ $product->alert_qty }}" class="form-control" placeholder="{{ __('Enter alert qty') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="expire_date" class="form-label">{{ __('Expire Date') }}</label>
                                    <input type="date" id="expire_date" name="expire_date" value="{{ $product->expire_date }}" class="form-control">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="vat_id" class="form-label">{{ __('Select Vat') }}</label>
                                    <select id="vat_id" name="vat_id" class="form-select">
                                        <option value="">{{ __('Select vat') }}</option>
                                        @foreach ($vats as $vat)
                                            <option value="{{ $vat->id }}" data-vat_rate="{{ $vat->rate }}" {{ $product->vat_id == $vat->id ? 'selected' : '' }}>
                                                {{ $vat->name }} ({{ $vat->rate }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="vat_type" class="form-label">{{ __('Vat Type') }}</label>
                                    <select id="vat_type" name="vat_type" class="form-select">
                                        <option value="exclusive" {{ $product->vat_type == 'exclusive' ? 'selected' : '' }}>{{ __('Exclusive') }}</option>
                                        <option value="inclusive" {{ $product->vat_type == 'inclusive' ? 'selected' : '' }}>{{ __('Inclusive') }}</option>
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="exclusive_price" class="form-label">{{ __('Purchase Price Exclusive') }}</label>
                                    <input type="number" id="exclusive_price" name="exclusive_price" value="{{ $product->exclusive_price }}" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="inclusive_price" class="form-label">{{ __('Purchase Price Inclusive') }}</label>
                                    <input type="number" id="inclusive_price" name="inclusive_price" value="{{ $product->inclusive_price }}" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="profit_margin" class="form-label">{{ __('Profit Margin (%)') }}</label>
                                    <input type="number" id="profit_margin" name="profit_percent" value="{{ $product->profit_percent }}" required class="form-control" placeholder="{{ __('Enter profit margin') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="mrp_price" class="form-label">{{ __('MRP') }}</label>
                                    <input type="number" id="mrp_price" name="productSalePrice" value="{{ $product->productSalePrice }}" required class="form-control" placeholder="{{ __('Enter sale price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productWholeSalePrice" class="form-label">{{ __('Wholesale Price') }}</label>
                                    <input type="number" id="productWholeSalePrice" name="productWholeSalePrice" value="{{ $product->productWholeSalePrice }}" class="form-control" placeholder="{{ __('Enter wholesale price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productDealerPrice" class="form-label">{{ __('Dealer Price') }}</label>
                                    <input type="number" id="productDealerPrice" name="productDealerPrice" value="{{ $product->productDealerPrice }}" class="form-control" placeholder="{{ __('Enter dealer price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productManufacturer" class="form-label">{{ __('Manufacturer') }}</label>
                                    <input type="text" id="productManufacturer" name="productManufacturer" value="{{ $product->productManufacturer }}" class="form-control" placeholder="{{ __('Enter manufacturer name') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productPicture" class="form-label">{{ __('Image') }}</label>
                                    <input type="file" id="productPicture" accept="image/*" name="productPicture" class="form-control">
                                    @if($product->productPicture)
                                        <img src="{{ asset('uploads/products/'.$product->productPicture) }}" id="image" class="img-thumbnail mt-2">
                                    @else
                                        <img src="{{ asset('assets/images/icons/upload.png') }}" id="image" class="img-thumbnail mt-2">
                                    @endif
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
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

