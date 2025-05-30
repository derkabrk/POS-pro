<?php

use App\Http\Controllers as Web;
use App\Models\PaymentType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Modules\Business\App\Http\Controllers as Business;
use App\Http\Controllers\ChatController;

Route::post('/webhook/{platform}', [Business\OrderSourceController::class, 'handleWebhook'])->name('webhook.handle');

Route::get('/shopify/callback', [Business\OrderSourceController::class, 'shopifyCallback'])->name('shopify.callback');

Route::get('/youcan/callback', [Business\OrderSourceController::class, 'youcanCallback'])->name('youcan.callback');

Route::post('/youcan/webhook/orders', [Business\OrderSourceController::class, 'storeYouCanOrder'])->name('youcan.webhook.orders');

Route::domain('{business}.shyftcom.com')->group(function () {
    Route::get('/', [\Modules\Business\App\Http\Controllers\MarketplaceController::class, 'showSubdomain'])
        ->name('marketplace.subdomain');
    Route::get('marketplace/{business_id}', [\Modules\Business\App\Http\Controllers\MarketplaceController::class, 'show'])->name('marketplace.show');
    Route::get('marketplace/{business_id}/category/{category_id}', [\Modules\Business\App\Http\Controllers\MarketplaceController::class, 'viewAllCategory'])->name('marketplace.category.viewall');
    Route::post('marketplace/order/{product_id}', [\Modules\Business\App\Http\Controllers\MarketplaceController::class, 'submitOrder'])->name('marketplace.order.submit');
    // Store new order from checkout (AJAX)
    Route::post('marketplace/{business_id}/checkout-order', [\Modules\Business\App\Http\Controllers\MarketplaceController::class, 'storeCheckoutOrder'])->name('marketplace.checkout.order');
});

// Marketplace routes for main domain (no subdomain)

Route::get('/', [Web\WebController::class, 'index'])->name('home');
Route::resource('blogs', Web\BlogController::class)->only('index', 'show', 'store');
Route::get('/about-us', [Web\AboutController::class, 'index'])->name('about.index');
Route::get('/plans', [Web\PlanController::class, 'index'])->name('plan.index');

// Business Signup
Route::get('/get-business-categories', [Web\AcnooBusinessController::class, 'getBusinessCategories'])->name('get-business-categories');
Route::post('/businesses', [Web\AcnooBusinessController::class, 'store'])->name('business.store');
Route::post('/verify-code', [Web\AcnooBusinessController::class, 'verifyCode'])->name('business.verify-code');

Route::get('/terms-conditions', [Web\TermServiceController::class, 'index'])->name('term.index');
Route::get('/privacy-policy', [Web\PolicyController::class, 'index'])->name('policy.index');

Route::get('/contact-us', [Web\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/store', [Web\ContactController::class, 'store'])->name('contact.store');

// Payment Routes Start
Route::get('/payments-gateways/{plan_id}/{business_id}', [Web\PaymentController::class, 'index'])->name('payments-gateways.index');
Route::post('/payments/{plan_id}/{gateway_id}', [Web\PaymentController::class, 'payment'])->name('payments-gateways.payment');
Route::get('/payment/success', [Web\PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [Web\PaymentController::class, 'failed'])->name('payment.failed');
Route::post('ssl-commerz/payment/success', [Web\PaymentController::class, 'sslCommerzSuccess']);
Route::post('ssl-commerz/payment/failed', [Web\PaymentController::class, 'sslCommerzFailed']);
Route::get('/order-status', [Web\PaymentController::class, 'orderStatus'])->name('order.status');

Route::group([
    'namespace' => 'App\Library',
], function () {
    Route::get('/payment/paypal', 'Paypal@status');
    Route::get('/payment/mollie', 'Mollie@status');
    Route::post('/payment/paystack', 'Paystack@status')->name('paystack.status');
    Route::get('/paystack', 'Paystack@view')->name('paystack.view');
    Route::get('/razorpay/payment', 'Razorpay@view')->name('razorpay.view');
    Route::post('/razorpay/status', 'Razorpay@status');
    Route::get('/mercadopago/pay', 'Mercado@status')->name('mercadopago.status');
    Route::get('/payment/flutterwave', 'Flutterwave@status');
    Route::get('/payment/thawani', 'Thawani@status');
    Route::get('/payment/instamojo', 'Instamojo@status');
    Route::get('/payment/toyyibpay', 'Toyyibpay@status');
    Route::get('/manual/payment', 'CustomGateway@status')->name('manual.payment');
    Route::get('payu/payment', 'Payu@view')->name('payu.view');
    Route::post('/payu/status', 'Payu@status')->name('payu.status');
    Route::post('/phonepe/status', 'PhonePe@status')->name('phonepe.status');
    Route::post('/paytm/status', 'Paytm@status')->name('paytm.status');
    Route::get('/tap-payment/status', 'TapPayment@status')->name('tap-payment.status');
});
// Payment Routes End

Route::get('/subscriptions-statistics', [\Modules\Business\App\Http\Controllers\DashboardController::class, 'subscriptionsStatistics'])->name('admin.dashboard.subscriptions');

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
});

// Global chat user search route
Route::get('/chat/search-users', [App\Http\Controllers\ChatController::class, 'searchUsers'])->name('chat.search-users');

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return back()->with('success', __('Cache has been cleared.'));
});

Route::get('/update', function () {
    Artisan::call('migrate');
    if (!PaymentType::exists()) {
        Artisan::call('db:seed', ['--class' => 'PaymentTypeSeeder']);
    }
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return redirect('/')->with('message', __('System updated successfully.'));
});

// Fallback route for undefined URLs
Route::fallback(function () {
    return redirect('/')->with('error', __('Page not found.'));
});

require __DIR__.'/auth.php';
