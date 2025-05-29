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
                                
                                <!-- Enhanced Variant and Sub-Variant Management -->
                                <div class="col-12">
                                    <div class="card border-primary">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-tags me-2"></i>{{ __('Product Variants & Sub-Variants') }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Variant Selection -->
                                                <div class="col-lg-6">
                                                    <label for="variant_select" class="form-label">{{ __('Available Variants') }}</label>
                                                    <select id="variant_select" class="form-select mb-3">
                                                        <option value="">{{ __('Choose a variant to add') }}</option>
                                                        @foreach ($variants as $variant)
                                                            <option value="{{ $variant->id }}" 
                                                                    data-variant='@json($variant)'>
                                                                {{ $variant->variantName }} ({{ $variant->variantCode }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                    <!-- Sub-variant Selection (appears when variant is selected) -->
                                                    <div id="sub_variant_section" style="display: none;">
                                                        <label class="form-label">{{ __('Sub-Variants for Selected Variant') }}</label>
                                                        <div id="sub_variant_list" class="border rounded p-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                                                            <!-- Sub-variants will be loaded here -->
                                                        </div>
                                                        <button type="button" id="add_variant_btn" class="btn btn-primary btn-sm" disabled>
                                                            <i class="fas fa-plus me-1"></i>{{ __('Add Variant') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <!-- Selected Variants Display -->
                                                <div class="col-lg-6">
                                                    <label class="form-label">{{ __('Selected Variants') }} <span id="variant_count" class="badge bg-primary">0</span></label>
                                                    <div id="selected_variants_container" class="border rounded p-3" style="min-height: 300px; max-height: 400px; overflow-y: auto;">
                                                        <div class="text-muted text-center py-4" id="no_variants_selected">
                                                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                                                            <p class="mb-0">{{ __('No variants selected yet') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button type="button" id="clear_all_variants" class="btn btn-outline-danger btn-sm" disabled>
                                                            <i class="fas fa-trash me-1"></i>{{ __('Clear All') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
/* Variant Management Styles */
.variant-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
    background: #fff;
}

.variant-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-color: #0d6efd;
}

.variant-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 15px;
    border-radius: 7px 7px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.variant-body {
    padding: 12px 15px;
}

.sub-variant-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 6px;
    display: flex;
    justify-content: between;
    align-items: center;
    transition: all 0.2s ease;
}

.sub-variant-item:hover {
    background: #e3f2fd;
    border-color: #0d6efd;
}

.sub-variant-checkbox {
    border: 1px solid #e9ecef;
    padding: 6px 10px;
    margin-bottom: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.sub-variant-checkbox:hover {
    background: #f8f9fa;
}

.sub-variant-checkbox input[type="checkbox"] {
    margin-right: 8px;
}

.sub-variant-checkbox.selected {
    background: #e3f2fd;
    border-color: #0d6efd;
}

.variant-remove-btn {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    transition: all 0.2s ease;
}

.variant-remove-btn:hover {
    background: rgba(255,255,255,0.3);
    border-color: rgba(255,255,255,0.5);
}

.variant-count-badge {
    background: rgba(255,255,255,0.2);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    margin-left: 8px;
}

#sub_variant_list {
    background: #fdfdfd;
    border: 2px dashed #dee2e6;
}

.no-sub-variants {
    text-align: center;
    color: #6c757d;
    padding: 20px;
    font-style: italic;
}

.add-variant-section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

/* Animation for adding variants */
.variant-card.just-added {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.selected-variants-empty {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 40px 20px;
    text-align: center;
    color: #6c757d;
}
</style>

<script>
$(document).ready(function() {
    // Store all variants data
    let allVariants = @json($variants);
    let selectedVariants = new Map(); // Use Map to store selected variants with their sub-variants
    
    // Helper function to get sub-variants for a variant
function getSubVariants(variantId) {
    let variant = allVariants.find(v => v.id == variantId);
    if (!variant) return [];
    // Always use sub_variants property as provided by Laravel
    return variant.sub_variants || [];
}
    
    // Handle variant selection
    $('#variant_select').on('change', function() {
        let variantId = $(this).val();
        let variantOption = $(this).find('option:selected');
        
        if (!variantId) {
            $('#sub_variant_section').hide();
            return;
        }
        
        // Get variant data
        let variantData = JSON.parse(variantOption.attr('data-variant') || '{}');
        let subVariants = getSubVariants(variantId);
        
        // Show sub-variant section
        $('#sub_variant_section').show();
        
        // Load sub-variants
        loadSubVariants(variantId, variantData, subVariants);
    });
    
    function loadSubVariants(variantId, variantData, subVariants) {
        let container = $('#sub_variant_list');
        container.empty();
        
        if (subVariants.length === 0) {
            container.html(`
                <div class="no-sub-variants">
                    <i class="fas fa-info-circle mb-2"></i>
                    <p class="mb-0">${'{{ __("This variant has no sub-variants") }}'}</p>
                </div>
            `);
            $('#add_variant_btn').prop('disabled', false).text('{{ __("Add Variant (No Sub-variants)") }}');
            return;
        }
        
        // Create checkboxes for sub-variants
        subVariants.forEach(function(subVariant) {
            let subName = subVariant.name || subVariant.subVariantName || `Sub-variant ${subVariant.id}`;
            let subSku = subVariant.sku || subVariant.code || '';
            
            let subVariantHtml = `
                <div class="sub-variant-checkbox" data-sub-variant-id="${subVariant.id}">
                    <input type="checkbox" id="sub_${subVariant.id}" value="${subVariant.id}">
                    <label for="sub_${subVariant.id}">
                        <strong>${subName}</strong>
                        ${subSku ? `<small class="text-muted d-block">SKU: ${subSku}</small>` : ''}
                    </label>
                </div>
            `;
            container.append(subVariantHtml);
        });
        
        // Add select all/none buttons
        container.append(`
            <div class="mt-3 text-center">
                <button type="button" class="btn btn-sm btn-outline-primary me-2" id="select_all_subs">
                    {{ __('Select All') }}
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="select_none_subs">
                    {{ __('Select None') }}
                </button>
            </div>
        `);
        
        // Handle select all/none
        $('#select_all_subs').on('click', function() {
            $('.sub-variant-checkbox input[type="checkbox"]').prop('checked', true).trigger('change');
        });
        
        $('#select_none_subs').on('click', function() {
            $('.sub-variant-checkbox input[type="checkbox"]').prop('checked', false).trigger('change');
        });
        
        // Handle individual checkbox changes
        $('.sub-variant-checkbox input[type="checkbox"]').on('change', function() {
            $(this).closest('.sub-variant-checkbox').toggleClass('selected', this.checked);
            updateAddButton();
        });
        
        // Update add button initially
        updateAddButton();
    }
    
    function updateAddButton() {
        let selectedCount = $('.sub-variant-checkbox input[type="checkbox"]:checked').length;
        let totalCount = $('.sub-variant-checkbox input[type="checkbox"]').length;
        
        if (totalCount === 0) {
            $('#add_variant_btn').prop('disabled', false).text('{{ __("Add Variant (No Sub-variants)") }}');
        } else {
            $('#add_variant_btn').prop('disabled', selectedCount === 0);
            $('#add_variant_btn').text(`{{ __('Add Variant') }} (${selectedCount} {{ __('sub-variants selected') }})`);
        }
    }
    
    // Handle add variant button
    $('#add_variant_btn').on('click', function() {
        let variantId = $('#variant_select').val();
        let variantOption = $('#variant_select option:selected');
        let variantData = JSON.parse(variantOption.attr('data-variant') || '{}');
        
        // Get selected sub-variants
        let selectedSubVariants = [];
        $('.sub-variant-checkbox input[type="checkbox"]:checked').each(function() {
            let subVariantId = $(this).val();
            let subVariantData = getSubVariants(variantId).find(sv => sv.id == subVariantId);
            if (subVariantData) {
                selectedSubVariants.push(subVariantData);
            }
        });
        
        // Check if variant is already selected
        if (selectedVariants.has(variantId)) {
            alert('{{ __("This variant is already selected") }}');
            return;
        }
        
        // Add to selected variants
        selectedVariants.set(variantId, {
            variant: variantData,
            subVariants: selectedSubVariants
        });
        
        // Update display
        updateSelectedVariantsDisplay();
        
        // Reset form
        $('#variant_select').val('');
        $('#sub_variant_section').hide();
    });
    
    function updateSelectedVariantsDisplay() {
        let container = $('#selected_variants_container');
        let noVariantsMsg = $('#no_variants_selected');
        
        if (selectedVariants.size === 0) {
            noVariantsMsg.show();
            $('#clear_all_variants').prop('disabled', true);
        } else {
            noVariantsMsg.hide();
            $('#clear_all_variants').prop('disabled', false);
        }
        
        // Clear existing variant cards (but keep the no variants message)
        container.find('.variant-card').remove();
        
        // Add variant cards
        selectedVariants.forEach((data, variantId) => {
            let variant = data.variant;
            let subVariants = data.subVariants;
            
            let variantCard = $(`
                <div class="variant-card just-added" data-variant-id="${variantId}">
                    <div class="variant-header">
                        <div>
                            <strong>${variant.variantName}</strong>
                            <span class="variant-count-badge">${subVariants.length} {{ __('sub-variants') }}</span>
                        </div>
                        <button type="button" class="variant-remove-btn" onclick="removeVariant('${variantId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="variant-body">
                        ${subVariants.length > 0 ? `
                            <div class="sub-variants-list">
                                ${subVariants.map(sv => `
                                    <div class="sub-variant-item">
                                        <span>
                                            <strong>${sv.name || sv.subVariantName || 'Unnamed'}</strong>
                                            ${sv.sku ? `<small class="text-muted d-block">SKU: ${sv.sku}</small>` : ''}
                                        </span>
                                        <input type="hidden" name="selected_variants[${variantId}][]" value="${sv.id}">
                                    </div>
                                `).join('')}
                            </div>
                        ` : `
                            <p class="text-muted mb-0">{{ __('No sub-variants') }}</p>
                            <input type="hidden" name="selected_variants[${variantId}][]" value="">
                        `}
                    </div>
                </div>
            `);
            
            container.append(variantCard);
        });
        
        // Update count badge
        $('#variant_count').text(selectedVariants.size);
        
        // Remove animation class after animation completes
        setTimeout(() => {
            $('.variant-card.just-added').removeClass('just-added');
        }, 500);
    }
    
    // Remove variant function (global scope)
    window.removeVariant = function(variantId) {
        selectedVariants.delete(variantId);
        updateSelectedVariantsDisplay();
    };
    
    // Clear all variants
    $('#clear_all_variants').on('click', function() {
        if (confirm('{{ __("Are you sure you want to remove all selected variants?") }}')) {
            selectedVariants.clear();
            updateSelectedVariantsDisplay();
        }
    });
    
    // Form submission validation
    $('form').on('submit', function(e) {
        if (selectedVariants.size === 0) {
            // Uncomment if you want to make variants required
            // e.preventDefault();
            // alert('{{ __("Please select at least one variant") }}');
            // return false;
        }
        
        // Show loading state
        $(this).find('button[type="submit"]').prop('disabled', true)
               .html('<i class="fas fa-spinner fa-spin me-1"></i>{{ __("Saving...") }}');
    });
    
    // Reset form
    $('button[type="reset"]').on('click', function() {
        selectedVariants.clear();
        updateSelectedVariantsDisplay();
        $('#variant_select').val('');
        $('#sub_variant_section').hide();
    });
    
    // Initialize display
    updateSelectedVariantsDisplay();
});
</script>
@endpush