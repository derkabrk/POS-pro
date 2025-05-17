<div class="modal fade" id="product-view">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('View') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body order-form-section">
                <div class="costing-list">
                    <ul>
                        <li><span>{{ __('Product Image') }}</span> <span>:</span> <span> <img class="table-img" src="" alt="" id="product_image"></span></li>
                        <li><span>{{ __('Product Name') }}</span> <span>:</span> <span id="product_name"></span></li>
                        <li><span>{{ __('Code') }}</span> <span>:</span> <span id="product_code"></span></li>
                        <li><span>{{ __('Brand') }}</span> <span>:</span> <span id="product_brand"></span></li>
                        <li><span>{{ __('Category') }}</span> <span>:</span> <span id="product_category"></span></li>
                        <li><span>{{ __('Unit') }}</span> <span>:</span> <span id="product_unit"></span></li>
                        <li><span>{{ __('Purchase price') }}</span> <span>:</span> <span id="product_purchase_price"></span></li>
                        <li><span>{{ __('Sale price') }}</span> <span>:</span> <span id="product_sale_price"></span></li>
                        <li><span>{{ __('Wholesale Price') }}</span> <span>:</span> <span id="product_wholesale_price"></span></li>
                        <li><span>{{ __('Dealer Price') }}</span> <span>:</span> <span id="product_dealer_price"></span></li>
                        <li><span>{{ __('Stock') }}</span> <span>:</span> <span id="product_stock"></span></li>
                        <li><span>{{ __('Low Stock') }}</span> <span>:</span> <span id="product_low_stock"></span></li>
                        <li><span>{{ __('Expire Date') }}</span> <span>:</span> <span id="expire_date"></span></li>
                        <li><span>{{ __('Manufacturer') }}</span> <span>:</span> <span id="product_manufacturer"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
