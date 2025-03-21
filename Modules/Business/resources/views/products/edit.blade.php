@extends('business::layouts.master')

@section('title')
    {{ __('Edit Product') }}
@endsection

@section('main_content')
    <div class="erp-table-section">
        <div class="container-fluid">
            <div class="card border-0">
                <div class="card-bodys ">
                    <div class="table-header p-16">
                        <h4>{{ __('Edit Product') }}</h4>
                            <a href="{{ route('business.products.index') }}"
                                class="add-order-btn rounded-2 {{ Route::is('business.products.create') ? 'active' : '' }}"><i
                                    class="far fa-list" aria-hidden="true"></i> {{ __('Product List') }}</a>
                    </div>
                    <div class="order-form-section p-16">
                        <form action="{{ route('business.products.update', $product->id) }}" method="POST"
                            class="ajaxform_instant_reload">
                            @csrf
                            @method('put')
                            <div class="add-suplier-modal-wrapper d-block">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Product Name') }}</label>
                                        <input type="text" value="{{ $product->productName }}" name="productName"
                                            required class="form-control" placeholder="{{ __('Enter Product Name') }}">
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Product Category') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="category_id" id="category-select-edit" required
                                                class="form-control table-select w-100 role">
                                                <option value=""> {{ __('Select One') }}</option>
                                                @foreach ($categories as $category)
                                                    <option @selected($category->id == $product->category_id) value="{{ $category->id }}"
                                                        data-capacity=" {{ $category->variationCapacity }}"
                                                        data-color="{{ $category->variationColor }}"
                                                        data-size="{{ $category->variationSize }}"
                                                        data-type="{{ $category->variationType }}"
                                                        data-weight="{{ $category->variationWeight }}">
                                                        {{ ucfirst($category->categoryName) }} </option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div>
                                        <div id="dynamic-fields-edit" class="row">
                                            {{-- loaded dynamically --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Product Brand') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="brand_id" class="form-control table-select w-100 role">
                                                <option value=""> {{ __('Select one') }}</option>
                                                @foreach ($brands as $brand)
                                                    <option @selected($brand->id == $product->brand_id) value="{{ $brand->id }}">
                                                        {{ ucfirst($brand->brandName) }} </option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Product Unit') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select name="unit_id" class="form-control table-select w-100 role">
                                                <option value=""> {{ __('Select one') }}</option>
                                                @foreach ($units as $unit)
                                                    <option @selected($unit->id == $product->unit_id) value="{{ $unit->id }}">
                                                        {{ ucfirst($unit->unitName) }} </option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Product Code') }}</label>
                                        <input type="text" value="{{ $product->productCode }}" name="productCode" class="form-control" placeholder="{{ __('Enter Product Code') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Stock') }}</label>
                                        <input type="number" name="productStock" value="{{ $product->productStock }}"  class="form-control" placeholder="{{ __('Enter stock qty') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Low Stock Qty') }}</label>
                                        <input type="number" step="any" name="alert_qty" value="{{ $product->alert_qty }}" class="form-control" placeholder="{{ __('Enter alert qty') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Expire Date') }}</label>
                                        <input type="date" name="expire_date" value="{{ $product->expire_date }}" class="form-control">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Select Vat') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select id="vat_id" name="vat_id" class="form-control table-select w-100">
                                                <option value="">{{ __('Select vat') }}</option>
                                                @foreach ($vats as $vat)
                                                    <option value="{{ $vat->id }}" data-vat_rate="{{ $vat->rate }}" @selected($product->vat_id ==  $vat->id)>
                                                        {{ $vat->name }} ({{ $vat->rate }}%)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Vat Type') }}</label>
                                        <div class="gpt-up-down-arrow position-relative">
                                            <select id="vat_type" name="vat_type" class="form-control table-select w-100">
                                                <option value="exclusive" @selected($product->vat_type == 'exclusive')>{{ __('Exclusive') }}</option>
                                                <option value="inclusive" @selected($product->vat_type == 'inclusive')>{{ __('Inclusive') }}</option>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Purchase Price Exclusive') }}</label>
                                        <input type="number" name="exclusive_price" value="{{ $product->vat_type == 'exclusive' ? $product->productPurchasePrice : $product->productPurchasePrice -  $product->vat_amount}}" id="exclusive_price" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Purchase Price Inclusive') }}</label>
                                        <input type="number" name="inclusive_price"  id="inclusive_price" value="{{ $product->vat_type == 'inclusive' ? $product->productPurchasePrice : $product->productPurchasePrice +  $product->vat_amount}}" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Profit Margin (%)') }}</label>
                                        <input type="number" id="profit_margin" name="profit_percent" value="{{ $product->profit_percent }}" required class="form-control" placeholder="{{ __('Enter profit margin') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('MRP') }}</label>
                                        <input type="number" name="productSalePrice" value="{{ $product->productSalePrice }}" id="mrp_price" required class="form-control" placeholder="{{ __('Enter sale price') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Wholesale Price') }}</label>
                                        <input type="number" value="{{ $product->productWholeSalePrice }}" name="productWholeSalePrice" class="form-control" placeholder="{{ __('Enter wholesale price') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Dealer Price') }}</label>
                                        <input type="number" value="{{ $product->productDealerPrice }}" name="productDealerPrice" class="form-control" placeholder="{{ __('Enter dealer price') }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label>{{ __('Manufacturer') }}</label>
                                        <input type="text" value="{{ $product->productManufacturer }}" name="productManufacturer" class="form-control" placeholder="{{ __('Enter manufacturer name') }}">
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-11">
                                                <label class="img-label">{{ __('Image') }}</label>
                                                <input type="file" accept="image/*" name="productPicture" class="form-control file-input-change" data-id="image">
                                            </div>
                                            <div class="col-1 align-self-center  m-0 p-0 mt-4">
                                                <img src="{{ asset($product->productPicture ?? 'assets/images/icons/upload.png') }}" id="image" class="table-img ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="button-group text-center mt-5">
                                            <a href="{{ route('business.products.index') }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                            <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                                        </div>
                                    </div>
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

