@extends('business::layouts.master')

@section('title')
    {{ __('Create Product') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('Add new Product')}}</h4>
                    <div class="flex-shrink-0">
                        <a href="{{ route('business.products.index') }}" class="btn btn-primary {{ Route::is('business.products.create') ? 'active' : '' }}">
                            <i class="far fa-list" aria-hidden="true"></i> {{ __('Product List') }}
                        </a>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('business.products.store') }}" method="POST" enctype="multipart/form-data" class="ajaxform_instant_reload">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productName" class="form-label">{{ __('Product Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" id="productName" name="productName" required class="form-control" placeholder="{{ __('Enter Product Name') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="category-select" class="form-label">{{ __('Product Category') }} <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category-select" required class="form-select">
                                        <option value="">{{ __('Select One') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" data-capacity="{{ $category->variationCapacity }}" data-color="{{ $category->variationColor }}" data-size="{{ $category->variationSize }}" data-type="{{ $category->variationType }}" data-weight="{{ $category->variationWeight }}">
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
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="brand_id" class="form-label">{{ __('Product Brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-select">
                                        <option value="">{{ __('Select one') }}</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ ucfirst($brand->brandName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="unit_id" class="form-label">{{ __('Product Unit') }}</label>
                                    <select name="unit_id" id="unit_id" class="form-select">
                                        <option value="">{{ __('Select one') }}</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ ucfirst($unit->unitName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Enhanced Variant Selection -->
                                <div class="col-xxl-6 col-md-6">
                                    <label for="variant_id" class="form-label">{{ __('Product Variant') }}</label>
                                    <select name="variant_ids[]" id="variant_id" class="form-select" multiple size="5">
                                        @foreach ($variants as $variant)
                                            <option value="{{ $variant->id }}"
                                                @if(old('variant_ids') && in_array($variant->id, old('variant_ids', []))) selected @endif>
                                                {{ $variant->variantName }} ({{ $variant->variantCode }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">{{ __('Hold Ctrl (Windows) or Command (Mac) to select multiple variants') }}</small>
                                </div>
                                
                                <!-- Enhanced Sub-Variant Selection -->
                                <div class="col-xxl-6 col-md-6">
                                    <label for="sub_variant_container" class="form-label">{{ __('Sub Variants') }}</label>
                                    <div id="sub_variant_container" class="border rounded p-3" style="min-height: 120px; max-height: 200px; overflow-y: auto;">
                                        <div id="no_variants_message" class="text-muted text-center">
                                            {{ __('Select variants first to see available sub-variants') }}
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ __('Sub-variants will appear grouped by selected variants') }}</small>
                                </div>
                                
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productCode" class="form-label">{{ __('Product Code') }}</label>
                                    <input type="text" id="productCode" value="{{ $code }}" name="productCode" class="form-control" placeholder="{{ __('Enter Product Code') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productStock" class="form-label">{{ __('Stock') }}</label>
                                    <input type="number" id="productStock" name="productStock" class="form-control" placeholder="{{ __('Enter stock qty') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="alert_qty" class="form-label">{{ __('Low Stock Qty') }}</label>
                                    <input type="number" id="alert_qty" step="any" name="alert_qty" class="form-control" placeholder="{{ __('Enter alert qty') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="expire_date" class="form-label">{{ __('Expire Date') }}</label>
                                    <input type="date" id="expire_date" name="expire_date" class="form-control">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="vat_id" class="form-label">{{ __('Select Vat') }}</label>
                                    <select id="vat_id" name="vat_id" class="form-select">
                                        <option value="">{{ __('Select vat') }}</option>
                                        @foreach ($vats as $vat)
                                            <option value="{{ $vat->id }}" data-vat_rate="{{ $vat->rate }}">
                                                {{ $vat->name }} ({{ $vat->rate }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="vat_type" class="form-label">{{ __('Vat Type') }}</label>
                                    <select id="vat_type" name="vat_type" class="form-select">
                                        <option value="exclusive">{{ __('Exclusive') }}</option>
                                        <option value="inclusive">{{ __('Inclusive') }}</option>
                                    </select>
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="exclusive_price" class="form-label">{{ __('Purchase Price Exclusive') }}</label>
                                    <input type="number" id="exclusive_price" name="exclusive_price" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="inclusive_price" class="form-label">{{ __('Purchase Price Inclusive') }}</label>
                                    <input type="number" id="inclusive_price" name="inclusive_price" required class="form-control" placeholder="{{ __('Enter purchase price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="profit_margin" class="form-label">{{ __('Profit Margin (%)') }}</label>
                                    <input type="number" id="profit_margin" name="profit_percent" required class="form-control" placeholder="{{ __('Enter profit margin') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="mrp_price" class="form-label">{{ __('MRP') }}</label>
                                    <input type="number" id="mrp_price" name="productSalePrice" required class="form-control" placeholder="{{ __('Enter sale price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productWholeSalePrice" class="form-label">{{ __('Wholesale Price') }}</label>
                                    <input type="number" id="productWholeSalePrice" name="productWholeSalePrice" class="form-control" placeholder="{{ __('Enter wholesale price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productDealerPrice" class="form-label">{{ __('Dealer Price') }}</label>
                                    <input type="number" id="productDealerPrice" name="productDealerPrice" class="form-control" placeholder="{{ __('Enter dealer price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="dropshipperPrice" class="form-label">{{ __('Dropshipper Price') }}</label>
                                    <input type="number" id="dropshipperPrice" name="dropshipperPrice" class="form-control" placeholder="{{ __('Enter dropshipper price') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productManufacturer" class="form-label">{{ __('Manufacturer') }}</label>
                                    <input type="text" id="productManufacturer" name="productManufacturer" class="form-control" placeholder="{{ __('Enter manufacturer name') }}">
                                </div>
                                <div class="col-xxl-6 col-md-6">
                                    <label for="productPicture" class="form-label">{{ __('Image') }}</label>
                                    <input type="file" id="productPicture" accept="image/*" name="productPicture" class="form-control">
                                    <img src="{{ asset('assets/images/icons/upload.png') }}" id="image" class="img-thumbnail mt-2">
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
@endsection

@push('scripts')
<style>
/* Enhanced Variant/Sub-variant Styling */
.variant-group {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 10px;
    border-left: 3px solid #0d6efd;
}

.variant-group h6 {
    margin-bottom: 8px;
    font-weight: 600;
    color: #0d6efd;
}

.sub-variants-list {
    max-height: 100px;
    overflow-y: auto;
    padding: 4px;
}

.form-check {
    margin-bottom: 4px;
}

.form-check-label {
    font-size: 0.9rem;
    cursor: pointer;
    padding-left: 4px;
}

#variant_id {
    min-height: 120px;
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

#variant_id:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

#variant_id option:checked {
    background-color: #0d6efd;
    color: white;
}

.sub-variant-checkbox:checked + .form-check-label {
    color: #0d6efd;
    font-weight: 500;
}

#sub_variant_container {
    background-color: #fdfdfd;
    border: 2px solid #dee2e6 !important;
    transition: border-color 0.3s ease;
}

#sub_variant_container:hover {
    border-color: #86b7fe !important;
}

.action-buttons {
    border-top: 1px solid #dee2e6;
    padding-top: 8px;
    margin-top: 8px;
}

.btn-sm {
    font-size: 0.8rem;
    padding: 4px 8px;
}

.variant-count-badge {
    background-color: #0d6efd;
    color: white;
    font-size: 0.75rem;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: 5px;
}

.no-sub-variants-message {
    background-color: #f8f9fa;
    border: 1px dashed #dee2e6;
    border-radius: 4px;
    padding: 20px;
    text-align: center;
    color: #6c757d;
}

.debug-info {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 4px;
    padding: 10px;
    margin: 10px 0;
    font-size: 0.8rem;
}
</style>

<script>
$(document).ready(function() {
    // Debug: Log the variants data
    console.log('All Variants Data:', @json($variants));
    
    // Variant data from backend
    let allVariants = @json($variants);
    let subVariantMap = {};
    
    // Debug: Build sub-variant mapping with logging
    allVariants.forEach(function(variant) {
        console.log(`Processing variant ${variant.id}:`, variant);
        
        // Try different possible property names for sub-variants
        let subVariants = variant.sub_variants || 
                         variant.subVariants || 
                         variant.SubVariants || 
                         variant.subvariants || 
                         variant.children || 
                         [];
        
        subVariantMap[variant.id] = subVariants;
        console.log(`Sub-variants for variant ${variant.id}:`, subVariants);
    });
    
    console.log('Sub-variant mapping:', subVariantMap);
    
    function updateSubVariantOptions() {
        let selectedVariants = $('#variant_id').val() || [];
        let container = $('#sub_variant_container');
        
        console.log('Selected variants:', selectedVariants);
        
        // Clear existing content
        container.empty();
        
        // Add debug info
        container.append(`
            <div class="debug-info">
                <strong>Debug Info:</strong><br>
                Selected Variants: ${selectedVariants.join(', ')}<br>
                Total Variants Available: ${allVariants.length}
            </div>
        `);
        
        if (selectedVariants.length === 0) {
            // Show "no variants selected" message
            container.append(`
                <div class="no-sub-variants-message">
                    <i class="fas fa-info-circle mb-2" style="font-size: 2rem; color: #6c757d;"></i>
                    <p class="mb-0">${'{{ __("Select variants first to see available sub-variants") }}'}</p>
                </div>
            `);
            return;
        }
        
        let hasSubVariants = false;
        let totalSubVariants = 0;
        
        selectedVariants.forEach(function(variantId) {
            console.log(`Processing selected variant ID: ${variantId}`);
            
            let variant = allVariants.find(v => v.id == variantId);
            console.log('Found variant:', variant);
            
            if (!variant) {
                console.error(`Variant with ID ${variantId} not found!`);
                return;
            }
            
            let subs = subVariantMap[variantId] || [];
            console.log(`Sub-variants for variant ${variantId}:`, subs);
            
            // Add debug info for this variant
            container.append(`
                <div class="debug-info">
                    <strong>Variant ${variant.variantName} (ID: ${variantId}):</strong><br>
                    Sub-variants found: ${subs.length}<br>
                    Sub-variants: ${JSON.stringify(subs, null, 2)}
                </div>
            `);
            
            if (subs.length > 0) {
                hasSubVariants = true;
                totalSubVariants += subs.length;
                
                // Create variant group
                let variantGroup = $(`
                    <div class="variant-group">
                        <h6>
                            <i class="fas fa-tags me-1"></i>
                            ${variant.variantName}
                            <span class="variant-count-badge">${subs.length}</span>
                        </h6>
                        <div class="sub-variants-list"></div>
                    </div>
                `);
                
                let subVariantsList = variantGroup.find('.sub-variants-list');
                
                // Add sub-variants for this variant
                subs.forEach(function(sub) {
                    console.log('Creating checkbox for sub-variant:', sub);
                    
                    // Handle different possible property names
                    let subName = sub.name || sub.subVariantName || sub.title || `Sub-variant ${sub.id}`;
                    let subSku = sub.sku || sub.code || sub.subVariantCode || '';
                    
                    let subVariantItem = $(`
                        <div class="form-check">
                            <input class="form-check-input sub-variant-checkbox" 
                                   type="checkbox" 
                                   name="sub_variant_ids[]" 
                                   value="${sub.id}" 
                                   id="sub_variant_${sub.id}">
                            <label class="form-check-label" for="sub_variant_${sub.id}">
                                <strong>${subName}</strong>
                                <small class="text-muted d-block">${subSku ? 'SKU: ' + subSku : 'No SKU'}</small>
                            </label>
                        </div>
                    `);
                    subVariantsList.append(subVariantItem);
                });
                
                container.append(variantGroup);
            } else {
                // Show message for this specific variant with no sub-variants
                container.append(`
                    <div class="alert alert-info">
                        <strong>${variant.variantName}</strong> has no sub-variants available.
                    </div>
                `);
            }
        });
        
        if (!hasSubVariants && selectedVariants.length > 0) {
            container.append(`
                <div class="no-sub-variants-message">
                    <i class="fas fa-exclamation-triangle mb-2" style="font-size: 2rem; color: #ffc107;"></i>
                    <p class="mb-0">${'{{ __("Selected variants have no sub-variants available") }}'}</p>
                </div>
            `);
        } else if (hasSubVariants) {
            // Add action buttons
            let actionButtons = $(`
                <div class="action-buttons text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="select_all_subs">
                        <i class="fas fa-check-double me-1"></i>${'{{ __("Select All") }}'}
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="clear_all_subs">
                        <i class="fas fa-times me-1"></i>${'{{ __("Clear All") }}'}
                    </button>
                    <small class="text-muted d-block mt-2">
                        <span id="selected_count">0</span> of ${totalSubVariants} sub-variants selected
                    </small>
                </div>
            `);
            container.append(actionButtons);
            
            // Update selected count
            updateSelectedCount();
            
            // Handle select all button
            $('#select_all_subs').on('click', function() {
                $('.sub-variant-checkbox').prop('checked', true);
                updateSelectedCount();
            });
            
            // Handle clear all button
            $('#clear_all_subs').on('click', function() {
                $('.sub-variant-checkbox').prop('checked', false);
                updateSelectedCount();
            });
            
            // Handle individual checkbox changes
            $(document).on('change', '.sub-variant-checkbox', function() {
                updateSelectedCount();
            });
        }
    }
    
    function updateSelectedCount() {
        let selectedCount = $('.sub-variant-checkbox:checked').length;
        $('#selected_count').text(selectedCount);
        
        // Update action buttons state
        let totalCheckboxes = $('.sub-variant-checkbox').length;
        $('#select_all_subs').prop('disabled', selectedCount === totalCheckboxes);
        $('#clear_all_subs').prop('disabled', selectedCount === 0);
    }
    
    // Handle variant selection change
    $('#variant_id').on('change', function() {
        console.log('Variant selection changed:', $(this).val());
        updateSubVariantOptions();
        
        // Show selected variants count in label
        let selectedCount = $(this).val() ? $(this).val().length : 0;
        let label = $(this).prev('label');
        let originalText = '{{ __("Product Variant") }}';
        let countText = selectedCount > 0 ? ` (${selectedCount} selected)` : '';
        
        label.html(originalText + countText);
        
        // Add visual feedback
        if (selectedCount > 0) {
            $(this).addClass('border-primary');
        } else {
            $(this).removeClass('border-primary');
        }
    });
    
    // Initialize on page load
    updateSubVariantOptions();
    
    // Handle form validation
    $('form').on('submit', function(e) {
        let selectedVariants = $('#variant_id').val() || [];
        let selectedSubVariants = $('input[name="sub_variant_ids[]"]:checked').length;
        
        console.log('Form submission - Variants:', selectedVariants, 'Sub-variants:', selectedSubVariants);
        
        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>{{ __("Saving...") }}');
    });
    
    // Reset form handler
    $('button[type="reset"]').on('click', function() {
        setTimeout(function() {
            $('#variant_id').trigger('change');
        }, 100);
    });
});
</script>
@endpush