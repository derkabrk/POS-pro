@extends('business::layouts.master')

@section('title')
    {{ isset($variant) ? __('Edit Product Variant') : __('Add Product Variant') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ isset($variant) ? __('Edit Product Variant') : __('Add Product Variant') }}</h4>
                <div class="flex-shrink-0">
                    <a href="{{ route('business.product-variants.index') }}" class="btn btn-primary">
                        <i class="far fa-list" aria-hidden="true"></i> {{ __('Product Variants') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ isset($variant) ? route('business.product-variants.update', $variant->id) : route('business.product-variants.store') }}" method="POST">
                    @csrf
                    @if(isset($variant))
                        @method('PUT')
                    @endif
                    <div class="row gy-4">
                        <div class="col-xxl-6 col-md-6">
                            <label for="variantName" class="form-label">{{ __('Variant Name') }} <span class="text-danger">*</span></label>
                            <input type="text" id="variantName" name="variantName" required class="form-control" placeholder="{{ __('Enter Variant Name') }}" value="{{ isset($variant) ? $variant->variantName : '' }}">
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <label for="variantCode" class="form-label">{{ __('Variant Code') }}</label>
                            <input type="text" id="variantCode" name="variantCode" class="form-control" placeholder="{{ __('Enter Variant Code') }}" value="{{ isset($variant) ? $variant->variantCode : '' }}">
                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ isset($variant) && $variant->status == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="0" {{ isset($variant) && $variant->status == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">{{ __('Sub Variants (with SKU)') }}</label>
                                <button type="button" id="addSubVariantBtn" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> {{ __('Add Sub Variant') }}
                                </button>
                            </div>
                            <div id="subVariantsList">
                                @if(isset($variant) && $variant->subVariants && count($variant->subVariants) > 0)
                                    @foreach($variant->subVariants as $index => $sub)
                                        <div class="row g-2 sub-variant-item mb-2" data-index="{{ $index }}">
                                            <div class="col-md-5">
                                                <input type="text" name="sub_variants[]" class="form-control" placeholder="{{ __('Sub Variant Name') }}" value="{{ $sub->name }}" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="sub_variant_skus[]" class="form-control" placeholder="{{ __('SKU') }}" value="{{ $sub->sku }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-sub-variant" onclick="removeSubVariant(this)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row g-2 sub-variant-item mb-2" data-index="0">
                                        <div class="col-md-5">
                                            <input type="text" name="sub_variants[]" class="form-control" placeholder="{{ __('Sub Variant Name') }}" required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="sub_variant_skus[]" class="form-control" placeholder="{{ __('SKU') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-sm remove-sub-variant" onclick="removeSubVariant(this)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div id="noSubVariants" class="text-muted text-center py-3" style="display: none;">
                                <em>{{ __('No sub variants added yet. Click "Add Sub Variant" to add one.') }}</em>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="reset" class="btn btn-light me-3">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-primary">{{ isset($variant) ? __('Update') : __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables for sub variants management
let subVariantCounter = {{ isset($variant) && $variant->subVariants ? count($variant->subVariants) : 1 }};

// Add sub variant function
function addSubVariant() {
    const container = document.getElementById('subVariantsList');
    const noVariantsMsg = document.getElementById('noSubVariants');
    
    // Hide "no variants" message if visible
    if (noVariantsMsg) {
        noVariantsMsg.style.display = 'none';
    }
    
    // Create new sub variant row
    const newRow = document.createElement('div');
    newRow.className = 'row g-2 sub-variant-item mb-2';
    newRow.setAttribute('data-index', subVariantCounter);
    
    newRow.innerHTML = `
        <div class="col-md-5">
            <input type="text" name="sub_variants[]" class="form-control" placeholder="{{ __('Sub Variant Name') }}" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="sub_variant_skus[]" class="form-control" placeholder="{{ __('SKU') }}">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-sub-variant" onclick="removeSubVariant(this)">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    `;
    
    container.appendChild(newRow);
    subVariantCounter++;
    
    // Focus on the new name input
    const nameInput = newRow.querySelector('input[name="sub_variants[]"]');
    if (nameInput) {
        nameInput.focus();
    }
}

// Remove sub variant function
function removeSubVariant(button) {
    const row = button.closest('.sub-variant-item');
    const container = document.getElementById('subVariantsList');
    const noVariantsMsg = document.getElementById('noSubVariants');
    
    if (row) {
        row.remove();
        
        // Check if no sub variants remain
        const remainingRows = container.querySelectorAll('.sub-variant-item');
        if (remainingRows.length === 0 && noVariantsMsg) {
            noVariantsMsg.style.display = 'block';
        }
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to the add button
    const addButton = document.getElementById('addSubVariantBtn');
    if (addButton) {
        addButton.addEventListener('click', function(e) {
            e.preventDefault();
            addSubVariant();
        });
    }
    
    // Check if we should show the "no variants" message
    const container = document.getElementById('subVariantsList');
    const noVariantsMsg = document.getElementById('noSubVariants');
    const existingRows = container.querySelectorAll('.sub-variant-item');
    
    if (existingRows.length === 0 && noVariantsMsg) {
        noVariantsMsg.style.display = 'block';
    }
    
    // Add validation to form
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const subVariantInputs = document.querySelectorAll('input[name="sub_variants[]"]');
            let hasValidSubVariant = false;
            
            subVariantInputs.forEach(function(input) {
                if (input.value.trim() !== '') {
                    hasValidSubVariant = true;
                }
            });
            
            if (!hasValidSubVariant) {
                e.preventDefault();
                alert('{{ __("Please add at least one sub variant.") }}');
                return false;
            }
        });
    }
});

// Reset form function
function resetForm() {
    const container = document.getElementById('subVariantsList');
    const noVariantsMsg = document.getElementById('noSubVariants');
    
    // Clear all sub variants
    container.innerHTML = '';
    
    // Add one empty row
    addSubVariant();
    
    // Hide no variants message
    if (noVariantsMsg) {
        noVariantsMsg.style.display = 'none';
    }
    
    // Reset counter
    subVariantCounter = 1;
}

// Handle reset button
document.addEventListener('DOMContentLoaded', function() {
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('{{ __("Are you sure you want to reset the form?") }}')) {
                document.querySelector('form').reset();
                resetForm();
            }
        });
    }
});
</script>
@endsection