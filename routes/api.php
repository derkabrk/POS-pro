<?php

use App\Http\Controllers\Api as Api;
use Modules\Business\App\Http\Controllers as Business;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/webhook/{platform}', [Business\OrderSourceController::class, 'handleWebhook'])->name('webhook.handle');
    Route::post('/sign-in', [Api\Auth\AuthController::class, 'login']);
    Route::post('/submit-otp', [Api\Auth\AuthController::class, 'submitOtp']);
    Route::post('/sign-up', [Api\Auth\AuthController::class, 'signUp']);
    Route::post('/resend-otp', [Api\Auth\AuthController::class, 'resendOtp']);

    Route::post('/send-reset-code',[Api\Auth\AcnooForgotPasswordController::class, 'sendResetCode']);
    Route::post('/verify-reset-code',[Api\Auth\AcnooForgotPasswordController::class, 'verifyResetCode']);
    Route::post('/password-reset',[Api\Auth\AcnooForgotPasswordController::class, 'resetPassword']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('summary', [Api\StatisticsController::class, 'summary']);
        Route::get('dashboard', [Api\StatisticsController::class, 'dashboard']);

        Route::apiResource('parties', Api\PartyController::class);
        Route::apiResource('users', Api\AcnooUserController::class)->except('show');
        Route::apiResource('units', Api\UnitController::class)->except('show');
        Route::apiResource('brands', Api\AcnooBrandController::class)->except('show');
        Route::apiResource('categories', Api\AcnooCategoryController::class)->except('show');
        Route::apiResource('products', Api\AcnooProductController::class)->except('show');
        Route::apiResource('business', Api\BusinessController::class)->only('index', 'store', 'update');
        Route::apiResource('business-categories', Api\BusinessCategoryController::class)->only('index');
        Route::apiResource('shipping-companies', Api\BusinessCategoryController::class)->only('index');
        
        Route::apiResource('purchase', Api\PurchaseController::class)->except('show');
        Route::apiResource('sales', Api\AcnooSaleController::class)->except('show');
        Route::apiResource('sales-return', Api\SaleReturnController::class)->only('index', 'store', 'show');
        Route::apiResource('purchases-return', Api\PurchaseReturnController::class)->only('index', 'store', 'show');
        Route::apiResource('invoices', Api\AcnooInvoiceController::class)->only('index');
        Route::apiResource('dues', Api\AcnooDueController::class)->only('index', 'store');
        Route::apiResource('expense-categories', Api\ExpenseCategoryController::class)->except('show');
        Route::apiResource('expenses', Api\AcnooExpenseController::class)->only('index', 'store');
        Route::apiResource('income-categories', Api\AcnooIncomeCategoryController::class)->except('show');
        Route::apiResource('incomes', Api\AcnooIncomeController::class)->only('index', 'store');

        Route::apiResource('banners', Api\AcnooBannerController::class)->only('index');
        Route::apiResource('lang', Api\AcnooLanguageController::class)->only('index', 'store');
        Route::apiResource('profile', Api\AcnooProfileController::class)->only('index', 'store');
        Route::apiResource('plans', Api\AcnooSubscriptionsController::class)->only('index');
        Route::apiResource('subscribes', Api\AcnooSubscribesController::class)->only('index');
        Route::apiResource('currencies', Api\AcnooCurrencyController::class)->only('index', 'show');
        Route::apiResource('vats', Api\AcnooVatController::class)->except('show');
        Route::apiResource('payment-types', Api\PaymentTypeController::class)->except('show');

        Route::get('business-settings', [Api\BusinessSettingController::class, 'index']);

        Route::post('change-password', [Api\AcnooProfileController::class, 'changePassword']);

        Route::get('new-invoice', [Api\AcnooInvoiceController::class, 'newInvoice']);

        Route::get('/sign-out', [Api\Auth\AuthController::class, 'signOut']);
        Route::get('/refresh-token', [Api\Auth\AuthController::class, 'refreshToken']);

        // Plan permissions API
        Route::get('/plan/{plan}/permissions', function($planId) {
            $plan = \App\Models\Plan::findOrFail($planId);
            // Assume permissions are stored as a JSON/text column 'permissions' on the plan
            $permissions = $plan->permissions ? json_decode($plan->permissions, true) : [];
            return response()->json(['permissions' => $permissions]);
        });

        // Promo code validation endpoint for AJAX
        Route::post('/promo/validate', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'code' => 'required|string',
                'plan_id' => 'required|integer|exists:plans,id',
            ]);
            $promo = \App\Models\PromoCode::where('code', $request->code)
                ->where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->first();
            if (!$promo) {
                return response()->json(['valid' => false, 'message' => 'Invalid or expired promo code.']);
            }
            $plan = \App\Models\Plan::find($request->plan_id);
            $amount = $plan->offerPrice ?? $plan->subscriptionPrice;
            $discount = $promo->discount_type === 'percent'
                ? ($amount * $promo->discount / 100)
                : $promo->discount;
            $newAmount = max(0, $amount - $discount);
            return response()->json([
                'valid' => true,
                'discount' => $discount,
                'discount_display' => ($promo->discount_type === 'percent' ? $promo->discount.'%' : currency_format($discount)),
                'new_amount' => $newAmount,
                'new_amount_display' => currency_format($newAmount),
            ]);
        });
    });
});
