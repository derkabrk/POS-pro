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
                                <option value="1" {{ isset($variant) && $variant->status ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="0" {{ isset($variant) && !$variant->status ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('Sub Variants (with SKU)') }}</label>
                            <div id="sub-variants-list">
                                @if(isset($variant) && $variant->subVariants && count($variant->subVariants))
                                    @foreach($variant->subVariants as $sub)
                                        <div class='row g-2 sub-variant-row mb-2'>
                                            <div class='col-md-5'>
                                                <input type='text' name='sub_variants[]' class='form-control' placeholder='{{ __('Sub Variant Name') }}' value='{{ $sub->name }}'>
                                            </div>
                                            <div class='col-md-5'>
                                                <input type='text' name='sub_variant_skus[]' class='form-control' placeholder='{{ __('SKU') }}' value='{{ $sub->sku }}'>
                                            </div>
                                            <div class='col-md-2'>
                                                <button type='button' class='btn btn-danger remove-sub-variant'>-</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class='row g-2 sub-variant-row mb-2'>
                                        <div class='col-md-5'>
                                            <input type='text' name='sub_variants[]' class='form-control' placeholder='{{ __('Sub Variant Name') }}'>
                                        </div>
                                        <div class='col-md-5'>
                                            <input type='text' name='sub_variant_skus[]' class='form-control' placeholder='{{ __('SKU') }}'>
                                        </div>
                                        <div class='col-md-2'>
                                            <button type='button' class='btn btn-danger remove-sub-variant'>-</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <button type='button' class='btn btn-success add-sub-variant'>
                                        <i class="fas fa-plus"></i> {{ __('Add Sub Variant') }}
                                    </button>
                                </div>
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
@endsection

@push('scripts')
<script>
// Wait for document ready and use vanilla JS as fallback
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    function addSubVariant() {
        console.log('Adding sub variant...');
        
        const subVariantsList = document.getElementById('sub-variants-list');
        if (!subVariantsList) {
            console.error('sub-variants-list not found');
            return;
        }
        
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 sub-variant-row mb-2';
        newRow.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="sub_variants[]" class="form-control" placeholder="{{ __('Sub Variant Name') }}">
            </div>
            <div class="col-md-5">
                <input type="text" name="sub_variant_skus[]" class="form-control" placeholder="{{ __('SKU') }}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-sub-variant">-</button>
            </div>
        `;
        
        subVariantsList.appendChild(newRow);
        console.log('Row added successfully');
        
        // Add event listener to the new remove button
        const removeBtn = newRow.querySelector('.remove-sub-variant');
        removeBtn.addEventListener('click', function() {
            newRow.remove();
            console.log('Row removed');
        });
    }
    
    // Add event listener to add button
    const addButton = document.querySelector('.add-sub-variant');
    if (addButton) {
        addButton.addEventListener('click', function(e) {
            e.preventDefault();
            addSubVariant();
        });
        console.log('Add button listener attached');
    } else {
        console.error('Add button not found');
    }
    
    // Add event listeners to existing remove buttons
    document.querySelectorAll('.remove-sub-variant').forEach(function(btn) {
        btn.addEventListener('click', function() {
            btn.closest('.sub-variant-row').remove();
            console.log('Existing row removed');
        });
    });
});

// jQuery fallback if available
if (typeof jQuery !== 'undefined') {
    $(document).ready(function() {
        console.log('jQuery ready');
        
        $(document).on('click', '.add-sub-variant', function(e) {
            e.preventDefault();
            console.log('jQuery: Add button clicked');
            
            const newRow = `
                <div class="row g-2 sub-variant-row mb-2">
                    <div class="col-md-5">
                        <input type="text" name="sub_variants[]" class="form-control" placeholder="{{ __('Sub Variant Name') }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="sub_variant_skus[]" class="form-control" placeholder="{{ __('SKU') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-sub-variant">-</button>
                    </div>
                </div>
            `;
            
            $('#sub-variants-list').append(newRow);
            console.log('jQuery: Row added');
        });
        
        $(document).on('click', '.remove-sub-variant', function() {
            $(this).closest('.sub-variant-row').remove();
            console.log('jQuery: Row removed');
        });
    });
}
</script>
@endpush