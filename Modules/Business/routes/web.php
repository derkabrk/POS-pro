<?php

use Illuminate\Support\Facades\Route;
use Modules\Business\App\Http\Controllers as Business;
use Modules\Business\App\Http\Controllers\OrderSourceController;

Route::group(['as' => 'business.', 'prefix' => 'business', 'middleware' => ['users', 'expired']], function () {

    Route::middleware(['auth', 'plan_permission:business_access'])->group(function () {
        Route::resource('business', Business\BusinessController::class);
        // Add other business-related routes here if needed
    });

    Route::get('dashboard', [Business\DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/get-dashboard', [Business\DashboardController::class, 'getDashboardData'])->name('dashboard.data');
    Route::get('/overall-report', [Business\DashboardController::class, 'overall_report'])->name('dashboard.overall-report');
    Route::get('/revenue-statistic', [Business\DashboardController::class, 'revenue'])->name('dashboard.revenue');

    Route::resource('profiles', Business\ProfileController::class)->only('index', 'update');

    // Pos Sale
    Route::middleware(['auth', 'plan_permission:sales_access'])->group(function () {
        Route::resource('sales', Business\AcnooSaleController::class);
    });
    
    Route::resource('sale-confirme', Business\SaleConfirmeController::class)->only('index', 'create', 'store');

    Route::resource('sale-returns', Business\SaleReturnController::class)->only('index', 'create', 'store');

    
    
    Route::post('sales/filter', [Business\AcnooSaleController::class, 'acnooFilter'])->name('sales.filter');
    Route::post('sales/updatestatus', [Business\AcnooSaleController::class, 'updatestatus'])->name('sales.updatestatus');
    Route::get('/sales/next-statuses/{status}', [Business\AcnooSaleController::class, 'getNextStatuses']);

    Route::get('sales/{id}', [AcnooSaleController::class, 'show'])->name('sales.show');

    Route::post('sales/delete-all', [Business\AcnooSaleController::class,'deleteAll'])->name('sales.delete-all');
    Route::get('/get-product-prices', [Business\AcnooSaleController::class, 'getProductPrices'])->name('products.prices');
    Route::get('/sale-cart-data', [Business\AcnooSaleController::class, 'getCartData'])->name('sales.cart-data');
    Route::get('/get-invoice/{id}', [Business\AcnooSaleController::class, 'getInvoice'])->name('sales.invoice');
    Route::post('sale/product-filter', [Business\AcnooSaleController::class, 'productFilter'])->name('sales.product-filter');
    Route::post('sale/category-filter', [Business\AcnooSaleController::class, 'categoryFilter'])->name('sales.category-filter');
    Route::post('sale/brand-filter', [Business\AcnooSaleController::class, 'brandFilter'])->name('sales.brand-filter');
    Route::get('sales/{id}/show-order', [Business\AcnooSaleController::class, 'showOrder'])->name('sales.showOrder');
    Route::get('sale/{sale_id}/pdf', [Business\AcnooSaleController::class, 'generatePDF'])->name('sales.pdf');
    Route::post('sale/mail/{sale_id}', [Business\AcnooSaleController::class, 'sendMail'])->name('sales.mail');
    Route::post('create-customer', [Business\AcnooSaleController::class, 'createCustomer'])->name('sales.store.customer');

    // Excel Import
    Route::post('sales/import-excel', [Business\AcnooSaleController::class, 'importExcel'])->name('sales.import.excel');
    // Google Sheet Import
    Route::post('sales/import-googlesheet', [Business\AcnooSaleController::class, 'importGoogleSheet'])->name('sales.import.googlesheet');
    // CSV Import
    Route::post('sales/import-csv', [Business\AcnooSaleController::class, 'importCsv'])->name('sales.import.csv');

    Route::post('sale-return/filter', [Business\SaleReturnController::class, 'acnooFilter'])->name('sale-returns.filter');


    // Purchase
    Route::middleware(['auth', 'plan_permission:purchase_access'])->group(function () {
        Route::resource('purchases', Business\AcnooPurchaseController::class)->except('show');
    });
    Route::post('purchases/filter', [Business\AcnooPurchaseController::class, 'acnooFilter'])->name('purchases.filter');
    Route::post('purchases/delete-all', [Business\AcnooPurchaseController::class,'deleteAll'])->name('purchases.delete-all');
    Route::get('/purchase-cart', [Business\AcnooPurchaseController::class, 'showPurchaseCart'])->name('purchases.cart');
    Route::get('/purchase-cart-data', [Business\AcnooPurchaseController::class, 'getCartData'])->name('purchases.cart-data');
    Route::get('/purchase/get-invoice/{id}', [Business\AcnooPurchaseController::class, 'getInvoice'])->name('purchases.invoice');
    Route::post('purchase/product-filter', [Business\AcnooPurchaseController::class, 'productFilter'])->name('purchases.product-filter');
    Route::post('purchase/category-filter', [Business\AcnooPurchaseController::class, 'categoryFilter'])->name('purchases.category-filter');
    Route::post('purchase/brand-filter', [Business\AcnooPurchaseController::class, 'brandFilter'])->name('purchases.brand-filter');
    Route::get('purchase/pdf/{purchase_id}', [Business\AcnooPurchaseController::class, 'generatePDF'])->name('purchases.pdf');
    Route::post('purchase/mail/{purchase_id}', [Business\AcnooPurchaseController::class, 'sendMail'])->name('purchases.mail');
    Route::post('create-supplier', [Business\AcnooPurchaseController::class, 'createSupplier'])->name('purchases.store.supplier');


    Route::resource('purchase-returns', Business\PurchaseReturnController::class)->only('index', 'create', 'store');
    Route::post('purchase-return/filter', [Business\PurchaseReturnController::class, 'acnooFilter'])->name('purchase-returns.filter');

    Route::resource('carts', Business\CartController::class);
    Route::post('cart/remove-all', [Business\CartController::class, 'removeAllCart'])->name('carts.remove-all');

    Route::resource('stocks', Business\AcnooStockController::class)->only('index');
    Route::post('stocks/filter', [Business\AcnooStockController::class, 'acnooFilter'])->name('stocks.filter');
    Route::get('stocks/pdf', [Business\AcnooStockController::class, 'generatePDF'])->name('stocks.pdf');
    Route::get('stocks/excel', [Business\AcnooStockController::class, 'exportExcel'])->name('stocks.excel');
    Route::get('stocks/csv', [Business\AcnooStockController::class, 'exportCsv'])->name('stocks.csv');

    Route::resource('expired-products', Business\AcnooExpireProductController::class)->only('index');
    Route::post('expired-products/filter', [Business\AcnooExpireProductController::class, 'acnooFilter'])->name('expired.products.filter');
    Route::get('expired-products/excel', [Business\AcnooExpireProductController::class, 'exportExcel'])->name('expired.products.excel');
    Route::get('expired-products/csv', [Business\AcnooExpireProductController::class, 'exportCsv'])->name('expired.products.csv');

    Route::resource('loss-profits', Business\AcnooLossProfitController::class)->only('index');
    Route::post('loss-profits/filter', [Business\AcnooLossProfitController::class, 'acnooFilter'])->name('loss-profits.filter');
    Route::get('loss-profits/pdf', [Business\AcnooLossProfitController::class, 'generatePDF'])->name('loss-profits.pdf');
    Route::get('loss-profits/excel', [Business\AcnooLossProfitController::class, 'exportExcel'])->name('loss-profits.excel');
    Route::get('loss-profits/csv', [Business\AcnooLossProfitController::class, 'exportCsv'])->name('loss-profits.csv');

    Route::middleware(['auth', 'plan_permission:reports_access'])->group(function () {
        Route::resource('sale-reports', Business\AcnooSaleReportController::class)->only('index');
        Route::resource('purchase-reports', Business\AcnooPurchaseReportController::class)->only('index');
        Route::resource('income-reports', Business\AcnooIncomeReportController::class)->only('index');
        Route::resource('expense-reports', Business\AcnooExpenseReportController::class)->only('index');
    });

    Route::resource('sale-return-reports', Business\AcnooSaleReturnReportController::class)->only('index');
    Route::post('sale-return-reports/filter', [Business\AcnooSaleReturnReportController::class, 'acnooFilter'])->name('sale-return-reports.filter');
    Route::get('/sales-return-report/pdf', [Business\AcnooSaleReturnReportController::class, 'generatePDF'])->name('sales.return.pdf');
    Route::get('sales-return-report/excel', [Business\AcnooSaleReturnReportController::class, 'exportExcel'])->name('sales-return-report.excel');
    Route::get('sales-return-report/csv', [Business\AcnooSaleReturnReportController::class, 'exportCsv'])->name('sales-return-report.csv');

    Route::resource('purchase-return-reports', Business\AcnooPurchaseReturnReportController::class)->only('index');
    Route::post('purchase-return-reports/filter', [Business\AcnooPurchaseReturnReportController::class, 'acnooFilter'])->name('purchase-return-reports.filter');
    Route::get('purchase-return-reports/pdf', [Business\AcnooPurchaseReturnReportController::class, 'generatePDF'])->name('purchase-return-reports.pdf');
    Route::get('purchase-return-reports/excel', [Business\AcnooPurchaseReturnReportController::class, 'exportExcel'])->name('purchase-return-reports.excel');
    Route::get('purchase-return-reports/csv', [Business\AcnooPurchaseReturnReportController::class, 'exportCsv'])->name('purchase-return-reports.csv');

    Route::middleware(['auth', 'plan_permission:products_access'])->group(function () {
        Route::resource('products', Business\AcnooProductController::class)->except('show');
    });
    Route::post('products/filter', [Business\AcnooProductController::class, 'acnooFilter'])->name('products.filter');
    Route::post('products/status/{id}',[Business\AcnooProductController::class,'status'])->name('products.status');
    Route::post('products/delete-all', [Business\AcnooProductController::class,'deleteAll'])->name('products.delete-all');
    Route::get('products/pdf', [Business\AcnooProductController::class, 'generatePDF'])->name('products.pdf');
    Route::get('products/excel', [Business\AcnooProductController::class, 'exportExcel'])->name('products.excel');
    Route::get('products/csv', [Business\AcnooProductController::class, 'exportCsv'])->name('products.csv');

    Route::resource('expired-product-reports', Business\AcnooExpireProductReportController::class)->only('index');
    Route::post('expired-product-reports/filter', [Business\AcnooExpireProductReportController::class, 'acnooFilter'])->name('expired.product.reports.filter');
    Route::get('expired-product-reports/excel', [Business\AcnooExpireProductReportController::class, 'exportExcel'])->name('expired.product.reports.excel');
    Route::get('expired-product-reports/csv', [Business\AcnooExpireProductReportController::class, 'exportCsv'])->name('expired.product.reports.csv');

    Route::resource('barcodes', Business\BarcodeGeneratorController::class)->only('index','store');
    Route::get('barcodes-products', [Business\BarcodeGeneratorController::class, 'fetchProducts'])->name('barcodes.products');
    Route::get('/barcodes-preview', [Business\BarcodeGeneratorController::class, 'preview'])->name('barcodes.preview');

    Route::middleware(['auth', 'plan_permission:products_access'])->group(function () {
        Route::resource('brands', Business\AcnooBrandController::class);
        Route::post('brands/filter', [Business\AcnooBrandController::class, 'acnooFilter'])->name('brands.filter');
        Route::post('brands/status/{id}',[Business\AcnooBrandController::class,'status'])->name('brands.status');
        Route::post('brands/delete-all', [Business\AcnooBrandController::class,'deleteAll'])->name('brands.delete-all');
    });

    // Payment Types
    Route::middleware(['auth', 'plan_permission:products_access'])->group(function () {
        Route::resource('payment-types', Business\AcnooPaymentTypeController::class)->except('show');
        Route::post('payment-types/filter', [Business\AcnooPaymentTypeController::class, 'acnooFilter'])->name('payment-types.filter');
        Route::post('payment-types/status/{id}',[Business\AcnooPaymentTypeController::class,'status'])->name('payment-types.status');
        Route::post('payment-types/delete-all', [Business\AcnooPaymentTypeController::class,'deleteAll'])->name('payment-types.delete-all');
    });

    // units
    Route::middleware(['auth', 'plan_permission:products_access'])->group(function () {
        Route::resource('units',Business\AcnooUnitController::class)->except('show');
        Route::post('units/filter', [Business\AcnooUnitController::class, 'acnooFilter'])->name('units.filter');
        Route::post('units/status/{id}',[Business\AcnooUnitController::class,'status'])->name('units.status');
        Route::post('units/delete-all', [Business\AcnooUnitController::class,'deleteAll'])->name('units.delete-all');
    });

    Route::middleware(['auth', 'plan_permission:products_access'])->group(function () {
        Route::resource('categories', Business\AcnooCategoryController::class);
        Route::post('categories/status/{id}', [Business\AcnooCategoryController::class, 'status'])->name('categories.status');
        Route::post('categories/delete-all', [Business\AcnooCategoryController::class, 'deleteAll'])->name('categories.deleteAll');
        Route::post('categories/delete-all', [Business\AcnooCategoryController::class,'deleteAll'])->name('categories.delete-all');
        Route::post('categories/filter', [Business\AcnooCategoryController::class, 'acnooFilter'])->name('categories.filter');
    });

    Route::middleware(['auth', 'plan_permission:shipping_access'])->group(function () {
        Route::resource('shipping', Business\AcnooShippingController::class);
    });

    //Parties
    Route::middleware(['auth', 'plan_permission:parties_access'])->group(function () {
        Route::resource('parties', Business\AcnooPartyController::class)->except('show');
        Route::post('parties/filter', [Business\AcnooPartyController::class, 'acnooFilter'])->name('parties.filter');
        Route::post('parties/status/{id}',[Business\AcnooPartyController::class,'status'])->name('parties.status');
        Route::post('parties/delete-all', [Business\AcnooPartyController::class,'deleteAll'])->name('parties.delete-all');
    });

    //Income Category
    Route::middleware(['auth', 'plan_permission:incomes_access'])->group(function () {
        Route::resource('income-categories', Business\AcnooIncomeCategoryController::class)->except('show');
        Route::post('income-categories/filter', [Business\AcnooIncomeCategoryController::class, 'acnooFilter'])->name('income-categories.filter');
        Route::post('income-categories/status/{id}',[Business\AcnooIncomeCategoryController::class,'status'])->name('income-categories.status');
        Route::post('income-categories/delete-all', [Business\AcnooIncomeCategoryController::class,'deleteAll'])->name('income-categories.delete-all');
    });

    //Income
    Route::middleware(['auth', 'plan_permission:incomes_access'])->group(function () {
        Route::resource('incomes', Business\AcnooIncomeController::class)->except('show');
        Route::post('incomes/filter', [Business\AcnooIncomeController::class, 'acnooFilter'])->name('incomes.filter');
        Route::post('incomes/status/{id}',[Business\AcnooIncomeController::class,'status'])->name('incomes.status');
        Route::post('incomes/delete-all', [Business\AcnooIncomeController::class,'deleteAll'])->name('incomes.delete-all');
    });

    //Expense Category
    Route::middleware(['auth', 'plan_permission:expenses_access'])->group(function () {
        Route::resource('expense-categories', Business\AcnooExpenseCategoryController::class)->except('show');
        Route::post('expense-categories/filter', [Business\AcnooExpenseCategoryController::class, 'acnooFilter'])->name('expense-categories.filter');
        Route::post('expense-categories/status/{id}',[Business\AcnooExpenseCategoryController::class,'status'])->name('expense-categories.status');
        Route::post('expense-categories/delete-all', [Business\AcnooExpenseCategoryController::class,'deleteAll'])->name('expense-categories.delete-all');
    });

    //Expense
    Route::middleware(['auth', 'plan_permission:expenses_access'])->group(function () {
        Route::resource('expenses', Business\AcnooExpenseController::class)->except('show');
        Route::post('expenses/filter', [Business\AcnooExpenseController::class, 'acnooFilter'])->name('expenses.filter');
        Route::post('expenses/status/{id}',[Business\AcnooExpenseController::class,'status'])->name('expenses.status');
        Route::post('expenses/delete-all', [Business\AcnooExpenseController::class,'deleteAll'])->name('expenses.delete-all');
    });

    //Reports
    Route::middleware(['auth', 'plan_permission:reports_access'])->group(function () {
        Route::resource('income-reports', Business\AcnooIncomeReportController::class)->only('index');
        Route::post('income-reports/filter', [Business\AcnooIncomeReportController::class, 'acnooFilter'])->name('income-reports.filter');
        Route::get('income-reports/pdf', [Business\AcnooIncomeReportController::class, 'generatePDF'])->name('income-reports.pdf');
        Route::get('income-reports/excel', [Business\AcnooIncomeReportController::class, 'exportExcel'])->name('income-reports.excel');
        Route::get('income-reports/csv', [Business\AcnooIncomeReportController::class, 'exportCsv'])->name('income-reports.csv');

        Route::resource('expense-reports', Business\AcnooExpenseReportController::class)->only('index');
        Route::post('expense-reports/filter', [Business\AcnooExpenseReportController::class, 'acnooFilter'])->name('expense-reports.filter');
        Route::get('expense-reports/pdf', [Business\AcnooExpenseReportController::class, 'generatePDF'])->name('expense-reports.pdf');
        Route::get('expense-reports/excel', [Business\AcnooExpenseReportController::class, 'exportExcel'])->name('expense-reports.excel');
        Route::get('expense-reports/csv', [Business\AcnooExpenseReportController::class, 'exportCsv'])->name('expense-reports.csv');

        Route::resource('transaction-history-reports', Business\AcnooTransactionHistoryReportController::class)->only('index');
        Route::post('transaction-history-reports/filter', [Business\AcnooTransactionHistoryReportController::class, 'acnooFilter'])->name('transaction-history-reports.filter');
        Route::get('transaction-history-reports/pdf', [Business\AcnooTransactionHistoryReportController::class, 'generatePDF'])->name('transaction-history-reports.pdf');
        Route::get('transaction-history-reports/excel', [Business\AcnooTransactionHistoryReportController::class, 'exportExcel'])->name('transaction-history-reports.excel');
        Route::get('transaction-history-reports/csv', [Business\AcnooTransactionHistoryReportController::class, 'exportCsv'])->name('transaction-history-reports.csv');

        Route::resource('subscription-reports', Business\AcnooSubscriptionReportController::class)->only('index');
        Route::post('subscription-reports/filter', [Business\AcnooSubscriptionReportController::class, 'acnooFilter'])->name('subscription-reports.filter');
        Route::get('subscription-reports/pdf', [Business\AcnooSubscriptionReportController::class, 'generatePDF'])->name('subscription-reports.pdf');
        Route::get('subscription-reports/excel', [Business\AcnooSubscriptionReportController::class, 'exportExcel'])->name('subscription-reports.excel');
        Route::get('subscription-reports/csv', [Business\AcnooSubscriptionReportController::class, 'exportCsv'])->name('subscription-reports.csv');
        Route::get('subscription-reports/get-invoice/{id}', [Business\AcnooSubscriptionReportController::class, 'getInvoice'])->name('subscription-reports.invoice');
    });

    Route::resource('dues', Business\AcnooDueController::class)->only('index');
    Route::post('dues/filter', [Business\AcnooDueController::class, 'acnooFilter'])->name('dues.filter');
    Route::get('collect-dues/{id}', [Business\AcnooDueController::class, 'collectDue'])->name('collect.dues');
    Route::post('collect-dues/store', [Business\AcnooDueController::class, 'collectDueStore'])->name('collect.dues.store');
    Route::get('/collect-dues-invoice/{id}', [Business\AcnooDueController::class, 'getInvoice'])->name('collect.dues.invoice');
    Route::get('collect-dues/pdf/{due_id}', [Business\AcnooDueController::class, 'generatePDF'])->name('collect.dues.pdf');
    Route::post('collect-dues/mail/{id}', [Business\AcnooDueController::class, 'sendMail'])->name('collect.dues.mail');

    Route::middleware(['auth', 'plan_permission:roles_access'])->group(function () {
        Route::resource('roles', Business\UserRoleController::class)->except('show');
    });

    Route::middleware(['auth', 'plan_permission:settings_access'])->group(function () {
        Route::resource('settings', Business\SettingController::class)->only('index', 'update');
    });

    Route::middleware(['auth', 'plan_permission:subscriptions_access'])->group(function () {
        Route::resource('subscriptions',Business\AcnooSubscriptionController::class)->withoutMiddleware('expired')->only('index');
    });

    Route::middleware(['auth', 'plan_permission:currencies_access'])->group(function () {
        Route::resource('currencies', Business\AcnooCurrencyController::class)->only('index');
        Route::post('currencies/filter', [Business\AcnooCurrencyController::class, 'acnooFilter'])->name('currencies.filter');
        Route::match(['get', 'post'], 'currencies/default/{id}', [Business\AcnooCurrencyController::class, 'default'])->name('currencies.default');
    });

    Route::middleware(['auth', 'plan_permission:vat_access'])->group(function () {
        Route::resource('vats', Business\AcnooVatController::class);
        Route::post('vats/status/{id}', [Business\AcnooVatController::class, 'status'])->name('vats.status');
        Route::post('vats/delete-all', [Business\AcnooVatController::class, 'deleteAll'])->name('vats.deleteAll');
        Route::post('vat/filter', [Business\AcnooVatController::class, 'acnooFilter'])->name('vats.filter');
        Route::post('vat-group/filter', [Business\AcnooVatController::class, 'VatGroupFilter'])->name('vat-groups.filter');
    });

    Route::middleware(['auth', 'plan_permission:notifications_access'])->group(function () {
        Route::prefix('notifications')->controller(Business\AcnooNotificationController::class)->name('notifications.')->group(function () {
            Route::get('/', 'mtIndex')->name('index');
            Route::post('/filter', 'maanFilter')->name('filter');
            Route::get('/{id}', 'mtView')->name('mtView');
            Route::get('view/all/', 'mtReadAll')->name('mtReadAll');
        });
    });

    Route::middleware(['auth', 'plan_permission:order_source_access'])->group(function () {
        Route::resource('orderSource', Business\OrderSourceController::class);
        Route::get('/suppliers', [Business\SupplierController::class, 'index'])->name('suppliers.index');
        Route::post('/suppliers', [Business\SupplierController::class, 'store'])->name('suppliers.store');
        Route::post('/shopify/webhook/orders', [Business\OrderSourceController::class, 'storeShopifyOrder'])->name('shopify.webhook.orders');
        Route::get('/shopify/connect', [Business\OrderSourceController::class, 'connectShopify'])->name('shopify.connect');
    });

    Route::middleware(['auth', 'plan_permission:ticket_system_access'])->group(function () {
        Route::resource('ticketSystem', Business\TicketSystemController::class);
        Route::post('ticketSystem/reply', [Business\TicketSystemController::class, 'reply'])->name('ticketSystem.reply');
    });

    Route::middleware(['auth', 'plan_permission:chat_access'])->group(function () {
        Route::get('chat', [Business\ChatController::class, 'index'])->name('chat.index');
        Route::get('chat/messages/{userId}', [Business\ChatController::class, 'fetchMessages'])->name('chat.messages');
        Route::post('chat/send', [Business\ChatController::class, 'sendMessage'])->name('chat.send');
        Route::get('chat/users/status', function() {
            $users = \App\Models\User::select('id', 'is_online')->get();
            return response()->json($users);
        })->name('chat.users.status');
        Route::get('chat/search-users', [Business\ChatController::class, 'searchUsers'])->name('chat.search-users');
    });

    Route::middleware(['auth', 'plan_permission:bulk_message'])->group(function () {
        Route::get('bulk-message/create', [\Modules\Business\App\Http\Controllers\BulkMessageController::class, 'create'])->name('bulk-message.create');
        Route::post('bulk-message/send', [\Modules\Business\App\Http\Controllers\BulkMessageController::class, 'send'])->name('bulk-message.send');
        Route::get('bulk-message/index', [\Modules\Business\App\Http\Controllers\BulkMessageController::class, 'index'])->name('bulk-message.index');
    });

    // Invite Codes
    Route::get('invite-codes', [\Modules\Business\App\Http\Controllers\InviteCodeController::class, 'index'])->name('invite-codes.index');
    Route::get('invite-codes/create', [\Modules\Business\App\Http\Controllers\InviteCodeController::class, 'create'])->name('invite-codes.create');
    Route::post('invite-codes', [\Modules\Business\App\Http\Controllers\InviteCodeController::class, 'store'])->name('invite-codes.store');
    Route::post('invite-codes/redeem', [\Modules\Business\App\Http\Controllers\InviteCodeController::class, 'redeem'])->name('invite-codes.redeem');

    Route::resource('product-variants', Business\AcnooProductVariantController::class);
    Route::post('product-variants/filter', [Business\AcnooProductVariantController::class, 'acnooFilter'])->name('product-variants.filter');

    // Dropshipper dashboard route
    Route::middleware(['auth'])->group(function () {
        Route::get('dropshipper/dashboard', [Business\DropshipperDashboardController::class, 'index'])
            ->name('dropshipper.dashboard');
    });

});

// Marketplace routes (public, no auth middleware)

