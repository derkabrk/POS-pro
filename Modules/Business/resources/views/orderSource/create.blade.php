@extends('business::layouts.master')

@section('title')
    Order Sources
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card border-0">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Add New Order Source</h4>
                 
                    <a href="{{ route('business.orderSource.index') }}" class="add-order-btn rounded-2 {{ Route::is('business.orderSource.create') ? 'active' : '' }}">
                        <i class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}
                    </a>
                </div>
                <div class="order-form-section p-16">
                    <form method="POST" action="{{ route('business.orderSource.store') }}">

                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                  <div class="col-lg-6 mb-2">
                                    <label>Account Name</label>
                                    <input type="text" name="account_name" required class="form-control" placeholder="Enter Account Name">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>API Key</label>
                                    <input type="text" name="api_key" required class="form-control" placeholder="Enter API Key">
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <label>API Secret</label>
                                    <input type="text" name="api_secret" required class="form-control" placeholder="Enter API Secret">
                                </div>
                              
                                <div class="col-lg-6 mb-2">
                                    <label>Platform</label>
                                    <select name="name" id="platform" class="form-control" required>
                                        <option value="" disabled selected>Select Platform</option>
                                        <option value="Shopify">Shopify</option>
                                        <option value="YouCan">YouCan</option>
                                        <option value="WooCommerce">WooCommerce</option>
                                        <option value="CSV">CSV</option> <!-- Added CSV option -->
                                    </select>
                                </div>
                               
                                <!-- Shopify Settings -->
                                <div id="shopify-settings" class="platform-settings d-none">
                                    <div class="col-lg-12 mb-2">
                                        <label>Shopify Store URL</label>
                                        <input type="text" name="shopify_store_url" class="form-control" placeholder="Enter your Shopify store URL">
                                    </div>
                                </div>

                                <!-- WooCommerce Settings -->
                                <div id="woocommerce-settings" class="platform-settings d-none">
                                    <div class="col-lg-12 mb-2">
                                        <label>WooCommerce Store URL</label>
                                        <input type="text" name="woocommerce_store_url" class="form-control" placeholder="Enter your WooCommerce store URL">
                                    </div>
                                </div>

                                <!-- YouCan Settings -->
                                <div id="youcan-settings" class="platform-settings d-none">
                                    <div class="col-lg-12 mb-2">
                                        <label>YouCan Store URL</label>
                                        <input type="text" name="youcan_store_url" class="form-control" placeholder="Enter your YouCan store URL">
                                    </div>
                                </div>

                                <!-- CSV Upload Section -->
                                <div class="col-lg-6 mb-2" id="csv-upload-section" style="display:none;">
                                    <label>CSV File</label>
                                    <input type="file" name="csv_file" class="form-control" accept=".csv">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                             

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
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

<script>
    document.getElementById('platform').addEventListener('change', function () {
        const platform = this.value;

        // Hide all platform-specific settings
        document.querySelectorAll('.platform-settings').forEach(function (el) {
            el.classList.add('d-none');
            el.querySelectorAll('input').forEach(function (input) {
                input.disabled = true;
            });
        });

        // Hide CSV upload by default
        document.getElementById('csv-upload-section').style.display = 'none';

        // Show the relevant settings based on the selected platform
        if (platform === 'Shopify') {
            const shopifySettings = document.getElementById('shopify-settings');
            shopifySettings.classList.remove('d-none');
            shopifySettings.querySelectorAll('input').forEach(function (input) {
                input.disabled = false;
            });
        } else if (platform === 'WooCommerce') {
            const woocommerceSettings = document.getElementById('woocommerce-settings');
            woocommerceSettings.classList.remove('d-none');
            woocommerceSettings.querySelectorAll('input').forEach(function (input) {
                input.disabled = false;
            });
        } else if (platform === 'YouCan') {
            const youcanSettings = document.getElementById('youcan-settings');
            youcanSettings.classList.remove('d-none');
            youcanSettings.querySelectorAll('input').forEach(function (input) {
                input.disabled = false;
            });
        } else if (platform === 'CSV') {
            document.getElementById('csv-upload-section').style.display = 'block';
        }
    });
</script>
@endsection