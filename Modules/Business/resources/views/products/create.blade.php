<!-- Replace lines 64-83 in your create.blade.php with this enhanced version -->

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

<div class="col-xxl-6 col-md-6">
    <label for="sub_variant_container" class="form-label">{{ __('Sub Variants') }}</label>
    <div id="sub_variant_container" class="border rounded p-3" style="min-height: 120px; max-height: 200px; overflow-y: auto;">
        <div id="no_variants_message" class="text-muted text-center">
            {{ __('Select variants first to see available sub-variants') }}
        </div>
        <!-- Sub-variants will be loaded here dynamically -->
    </div>
    <small class="text-muted">{{ __('Sub-variants will appear grouped by selected variants') }}</small>
</div>

<!-- Enhanced JavaScript for better variant/sub-variant handling -->
<script>
$(document).ready(function() {
    // Variant data from backend
    let allVariants = @json($variants);
    let subVariantMap = {};
    
    // Build sub-variant mapping
    allVariants.forEach(function(variant) {
        subVariantMap[variant.id] = variant.sub_variants || [];
    });
    
    function updateSubVariantOptions() {
        let selectedVariants = $('#variant_id').val() || [];
        let container = $('#sub_variant_container');
        let noMessage = $('#no_variants_message');
        
        // Clear existing content
        container.empty();
        
        if (selectedVariants.length === 0) {
            // Show "no variants selected" message
            container.append('<div id="no_variants_message" class="text-muted text-center py-3">' + 
                           '{{ __("Select variants first to see available sub-variants") }}</div>');
            return;
        }
        
        let hasSubVariants = false;
        
        selectedVariants.forEach(function(variantId) {
            let variant = allVariants.find(v => v.id == variantId);
            let subs = subVariantMap[variantId] || [];
            
            if (subs.length > 0) {
                hasSubVariants = true;
                
                // Create variant group
                let variantGroup = $(`
                    <div class="variant-group mb-3">
                        <h6 class="text-primary mb-2">
                            <i class="fas fa-tags me-1"></i>${variant.variantName}
                        </h6>
                        <div class="sub-variants-list"></div>
                    </div>
                `);
                
                let subVariantsList = variantGroup.find('.sub-variants-list');
                
                // Add sub-variants for this variant
                subs.forEach(function(sub) {
                    let subVariantItem = $(`
                        <div class="form-check mb-1">
                            <input class="form-check-input sub-variant-checkbox" 
                                   type="checkbox" 
                                   name="sub_variant_ids[]" 
                                   value="${sub.id}" 
                                   id="sub_variant_${sub.id}">
                            <label class="form-check-label" for="sub_variant_${sub.id}">
                                ${sub.name} 
                                <small class="text-muted">(${sub.sku || 'No SKU'})</small>
                            </label>
                        </div>
                    `);
                    subVariantsList.append(subVariantItem);
                });
                
                container.append(variantGroup);
            }
        });
        
        if (!hasSubVariants) {
            container.append('<div class="text-muted text-center py-3">' + 
                           '{{ __("Selected variants have no sub-variants available") }}</div>');
        } else {
            // Add "Select All" and "Clear All" buttons
            let actionButtons = $(`
                <div class="mt-2 text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="select_all_subs">
                        {{ __('Select All') }}
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="clear_all_subs">
                        {{ __('Clear All') }}
                    </button>
                </div>
            `);
            container.append(actionButtons);
            
            // Handle select all button
            $('#select_all_subs').on('click', function() {
                $('.sub-variant-checkbox').prop('checked', true);
            });
            
            // Handle clear all button
            $('#clear_all_subs').on('click', function() {
                $('.sub-variant-checkbox').prop('checked', false);
            });
        }
    }
    
    // Handle variant selection change
    $('#variant_id').on('change', function() {
        updateSubVariantOptions();
        
        // Show selected variants count
        let selectedCount = $(this).val() ? $(this).val().length : 0;
        let label = $(this).prev('label');
        let countText = selectedCount > 0 ? ` (${selectedCount} selected)` : '';
        
        // Update label to show count
        let originalText = label.text().replace(/ \(\d+ selected\)$/, '');
        label.text(originalText + countText);
    });
    
    // Initialize on page load
    updateSubVariantOptions();
    
    // Handle form validation
    $('form').on('submit', function() {
        let selectedVariants = $('#variant_id').val() || [];
        let selectedSubVariants = $('input[name="sub_variant_ids[]"]:checked').length;
        
        // Optional: Add validation if needed
        if (selectedVariants.length > 0 && selectedSubVariants === 0) {
            // You can add a warning or validation here if sub-variants are required
            console.log('Variants selected but no sub-variants chosen');
        }
    });
});
</script>

<!-- Additional CSS for better styling -->
<style>
.variant-group {
    background-color: #f8f9fa;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 10px;
}

.variant-group h6 {
    margin-bottom: 8px;
    font-weight: 600;
}

.sub-variants-list {
    max-height: 100px;
    overflow-y: auto;
}

.form-check {
    margin-bottom: 4px;
}

.form-check-label {
    font-size: 0.9rem;
    cursor: pointer;
}

#variant_id {
    min-height: 120px;
}

#variant_id:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.sub-variant-checkbox:checked + .form-check-label {
    color: #0d6efd;
    font-weight: 500;
}
</style>