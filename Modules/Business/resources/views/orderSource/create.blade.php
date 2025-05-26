@extends('business::layouts.master')

@section('title')
    Order Sources
@endsection

@section('content')
<div class="admin-table-section">
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Add New Order Source</h5>
                    </div>
                    <div class="col-sm-auto">
                        <a href="{{ route('business.orderSource.index') }}" class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center px-3 py-2 shadow-sm">
                            <i class="ri-list-unordered me-1"></i> {{ __('View List') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('business.orderSource.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <label class="form-label">Account Name</label>
                            <input type="text" name="account_name" required class="form-control" placeholder="Enter Account Name">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">API Key</label>
                            <input type="text" name="api_key" required class="form-control" placeholder="Enter API Key">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">API Secret</label>
                            <input type="text" name="api_secret" required class="form-control" placeholder="Enter API Secret">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Platform</label>
                            <select name="name" id="platform" class="form-select" required>
                                <option value="" disabled selected>Select Platform</option>
                                <option value="Shopify">Shopify</option>
                                <option value="YouCan">YouCan</option>
                                <option value="WooCommerce">WooCommerce</option>
                            </select>
                        </div>
                        <!-- Shopify Settings -->
                        <div id="shopify-settings" class="platform-settings d-none">
                            <div class="col-lg-12 mb-2">
                                <label class="form-label">Shopify Store URL</label>
                                <input type="text" name="shopify_store_url" class="form-control" placeholder="Enter your Shopify store URL">
                            </div>
                        </div>
                        <!-- WooCommerce Settings -->
                        <div id="woocommerce-settings" class="platform-settings d-none">
                            <div class="col-lg-12 mb-2">
                                <label class="form-label">WooCommerce Store URL</label>
                                <input type="text" name="woocommerce_store_url" class="form-control" placeholder="Enter your WooCommerce store URL">
                            </div>
                        </div>
                        <!-- YouCan Settings -->
                        <div id="youcan-settings" class="platform-settings d-none">
                            <div class="col-lg-12 mb-2">
                                <label class="form-label">YouCan Store URL</label>
                                <input type="text" name="youcan_store_url" class="form-control" placeholder="Enter your YouCan store URL">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-2">{{ __('Cancel') }}</button>
                            <button class="btn btn-primary px-4">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('platform').addEventListener('change', function () {
        const platform = this.value;
       // const webhookUrl = `https://shyftcom.com/webhook/${platform}`;
       // document.getElementById('webhook_url').value = webhookUrl;

        console.log('Selected Platform:', platform);
        //console.log('Generated Webhook URL:', webhookUrl);

        // Hide all platform-specific settings
        document.querySelectorAll('.platform-settings').forEach(function (el) {
            el.classList.add('d-none');
            el.querySelectorAll('input').forEach(function (input) {
                input.disabled = true; // Disable hidden inputs
            });
        });

        // Show the relevant settings based on the selected platform
        if (platform === 'Shopify') {
            const shopifySettings = document.getElementById('shopify-settings');
            shopifySettings.classList.remove('d-none');
            shopifySettings.querySelectorAll('input').forEach(function (input) {
                input.disabled = false; // Enable visible inputs
            });
        } else if (platform === 'WooCommerce') {
            const woocommerceSettings = document.getElementById('woocommerce-settings');
            woocommerceSettings.classList.remove('d-none');
            woocommerceSettings.querySelectorAll('input').forEach(function (input) {
                input.disabled = false; // Enable visible inputs
            });
        } else if (platform === 'YouCan') {
            const youcanSettings = document.getElementById('youcan-settings');
            youcanSettings.classList.remove('d-none');
            youcanSettings.querySelectorAll('input').forEach(function (input) {
                input.disabled = false; // Enable visible inputs
            });
        }
    });
</script>
@endsection