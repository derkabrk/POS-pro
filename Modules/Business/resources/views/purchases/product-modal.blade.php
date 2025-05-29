<div class="modal fade" id="product-modal">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-between">
                <h1 class="modal-title fs-5">{{ __('Add Items') }}</h1>
                <div class="custom-modal-header">
                    <button type="button" class="btn-close custom-close-btn" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
            </div>

            <div class="modal-body">
                <div class="personal-info">
                        <form id="purchase_modal" data-route="{{ route('business.carts.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-2 mt-2">
                                <ul>
                                    <li><span class="fw-bold">{{ __('Product Name') }}</span> <span>:</span> <span id="product_name"></span></li>
                                    <li><span class="fw-bold">{{ __('Brand') }}</span> <span>:</span> <span id="brand"></span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 mb-2 mt-2 text-end">
                                <ul>
                                    <li><span class="fw-bold">{{ __('Stock') }}</span> <span>:</span> <span id="stock"></span></li>
                                </ul>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Quantity') }}</label>
                                <input type="number" name="amount" id="product_qty" value="" required class="form-control" placeholder="{{ __('Enter Quantity') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Purchase Price') }}</label>
                                <input type="number" step="any" name="amount" id="purchase_price" required class="form-control" placeholder="{{ __('Enter Purchase Price') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Sales Price') }}</label>
                                <input type="number" step="any" name="amount" id="sales_price" required class="form-control" placeholder="{{ __('Enter Sales Price') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('WholeSale Price') }}</label>
                                <input type="number" step="any" name="amount" id="whole_sale_price" required class="form-control" placeholder="{{ __('Enter WholeSale Price') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Dealer Price') }}</label>
                                <input type="number" step="any" name="amount" id="dealer_price" required class="form-control" placeholder="{{ __('Enter Dealer Price') }}">
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Variant') }}</label>
                                <select id="variant_select" class="form-select">
                                    <option value="">{{ __('Select Variant') }}</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Sub Variant') }}</label>
                                <select id="sub_variant_select" class="form-select">
                                    <option value="">{{ __('Select Sub Variant') }}</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Sub Variants (with SKU)') }}</label>
                                <div id="sub-variants-list">
                                    <div class="row g-2 sub-variant-row mb-2">
                                        <div class="col-md-5">
                                            <input type="text" name="sub_variants[]" class="form-control" placeholder="{{ __('Sub Variant Name') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="sub_variant_skus[]" class="form-control" placeholder="{{ __('SKU') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success add-sub-variant">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <button type="reset" class="theme-btn border-btn m-2">{{ __('Reset') }}</button>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $(document).on('click', '.add-sub-variant', function(e) {
        e.preventDefault();
        let newRow = `<div class='row g-2 sub-variant-row mb-2'>
            <div class='col-md-5'>
                <input type='text' name='sub_variants[]' class='form-control' placeholder='{{ __('Sub Variant Name') }}'>
            </div>
            <div class='col-md-5'>
                <input type='text' name='sub_variant_skus[]' class='form-control' placeholder='{{ __('SKU') }}'>
            </div>
            <div class='col-md-2'>
                <button type='button' class='btn btn-danger remove-sub-variant'>-</button>
            </div>
        </div>`;
        $('#sub-variants-list').append(newRow);
    });
    $(document).on('click', '.remove-sub-variant', function() {
        $(this).closest('.sub-variant-row').remove();
    });

    function loadVariants(productId) {
        $('#variant_select').html('<option value="">{{ __('Loading...') }}</option>');
        $('#sub_variant_select').html('<option value="">{{ __('Select Sub Variant') }}</option>');
        $.get('/api/product/' + productId + '/variants', function(data) {
            let options = '<option value="">{{ __('Select Variant') }}</option>';
            data.forEach(function(variant) {
                options += `<option value="${variant.id}">${variant.variantName}</option>`;
            });
            $('#variant_select').html(options);
        });
    }
    function loadSubVariants(variantId, variants) {
        let subOptions = '<option value="">{{ __('Select Sub Variant') }}</option>';
        let variant = variants.find(v => v.id == variantId);
        if (variant && variant.sub_variants) {
            variant.sub_variants.forEach(function(sub) {
                subOptions += `<option value="${sub.id}">${sub.name} (${sub.sku})</option>`;
            });
        }
        $('#sub_variant_select').html(subOptions);
    }
    let loadedVariants = [];
    $(document).on('click', '#single-product', function () {
        let productId = $(this).data('product_id');
        loadVariants(productId);
        $.get('/api/product/' + productId + '/variants', function(data) {
            loadedVariants = data;
        });
    });
    $(document).on('change', '#variant_select', function() {
        let variantId = $(this).val();
        loadSubVariants(variantId, loadedVariants);
    });
});
</script>
@endpush
