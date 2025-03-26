<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as ADMIN;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [ADMIN\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/get-dashboard', [ADMIN\DashboardController::class, 'getDashboardData'])->name('dashboard.data');
    Route::get('/yearly-subscriptions', [ADMIN\DashboardController::class, 'yearlySubscriptions'])->name('dashboard.subscriptions');
    Route::get('/plans-overview', [ADMIN\DashboardController::class, 'plansOverview'])->name('dashboard.plans-overview');

    // Website settings
    Route::resource('website-settings',Admin\AcnooWebSettingController::class);

    // Features
    Route::resource('features',Admin\AcnooFeatureController::class);
    Route::post('features/filter', [ADMIN\AcnooFeatureController::class, 'acnooFilter'])->name('features.filter');
    Route::post('features/status/{id}', [ADMIN\AcnooFeatureController::class,'status'])->name('features.status');
    Route::post('features/delete-all', [ADMIN\AcnooFeatureController::class, 'deleteAll'])->name('features.delete-all');

    // Interface
    Route::resource('interfaces',Admin\AcnooInterfaceController::class);
    Route::post('interfaces/filter', [ADMIN\AcnooInterfaceController::class, 'acnooFilter'])->name('interfaces.filter');
    Route::put('admin/interfaces/{interface}', [ADMIN\AcnooInterfaceController::class, 'update'])->name('interfaces.update');
    Route::post('interfaces/status/{id}', [ADMIN\AcnooInterfaceController::class,'status'])->name('interfaces.status');
    Route::post('interfaces/delete-all', [ADMIN\AcnooInterfaceController::class, 'deleteAll'])->name('interfaces.delete-all');

    // Testimonial
    Route::resource('testimonials',Admin\AcnooTestimonialController::class);
    Route::post('testimonials/filter', [ADMIN\AcnooTestimonialController::class, 'acnooFilter'])->name('testimonials.filter');
    Route::post('testimonials/delete-all', [ADMIN\AcnooTestimonialController::class, 'deleteAll'])->name('testimonials.delete-all');

    // Term And Condition Controller
    Route::resource('term-conditions', ADMIN\AcnooTermConditionController::class)->only('index', 'store');

    // Message
    Route::resource('messages', Admin\AcnooMessageController::class)->only('index', 'destroy');
    Route::post('messages/filter', [ADMIN\AcnooMessageController::class, 'acnooFilter'])->name('messages.filter');
    Route::post('messages/delete-all', [ADMIN\AcnooMessageController::class, 'deleteAll'])->name('messages.delete-all');
    Route::post('messages/filter', [Admin\AcnooMessageController::class, 'acnooFilter'])->name('messages.filter');

    // Privacy And Policy Controller
    Route::resource('privacy-policy', ADMIN\AcnooPrivacyPloicyController::class)->only('index', 'store');

    // Blog Controller
    Route::resource('blogs', Admin\AcnooBlogController::class);
    Route::post('blogs/filter', [ADMIN\AcnooBlogController::class, 'acnooFilter'])->name('blogs.filter');
    Route::post('blogs/status/{id}', [ADMIN\AcnooBlogController::class,'status'])->name('blogs.status');
    Route::post('blogs/delete-all', [ADMIN\AcnooBlogController::class, 'deleteAll'])->name('blogs.delete-all');
    Route::get('blogs/comments/{id}', [ADMIN\AcnooBlogController::class, 'filterComment'])->name('blogs.filter.comment');

    //Comment Controller
    Route::resource('comments', Admin\AcnooCommentController::class);
    Route::post('comments/delete-all', [ADMIN\AcnooCommentController::class, 'deleteAll'])->name('comments.delete-all');

    Route::resource('users', ADMIN\UserController::class);
    Route::post('users/filter', [ADMIN\UserController::class, 'acnooFilter'])->name('users.filter');
    Route::post('users/status/{id}', [ADMIN\UserController::class,'status'])->name('users.status');
    Route::post('users/delete-all', [ADMIN\UserController::class,'deleteAll'])->name('users.delete-all');

    Route::resource('banners', ADMIN\AcnooBannerController::class)->except('show', 'edit', 'create');
    Route::post('banners/filter', [ADMIN\AcnooBannerController::class, 'acnooFilter'])->name('banners.filter');
    Route::post('banners/status/{id}', [ADMIN\AcnooBannerController::class,'status'])->name('banners.status');
    Route::post('banners/delete-all', [ADMIN\AcnooBannerController::class,'deleteAll'])->name('banners.delete-all');

    //Subscription Plans
    Route::resource('plans', ADMIN\AcnooPlanController::class)->except('show');
    Route::post('plans/filter', [ADMIN\AcnooPlanController::class, 'acnooFilter'])->name('plans.filter');
    Route::post('plans/status/{id}', [ADMIN\AcnooPlanController::class,'status'])->name('plans.status');
    Route::post('plans/delete-all', [ADMIN\AcnooPlanController::class, 'deleteAll'])->name('plans.delete-all');

    // Business
    Route::resource('business',ADMIN\AcnooBusinessController::class);
    Route::put('business/upgrade-plan/{id}', [ADMIN\AcnooBusinessController::class, 'upgradePlan'])->name('business.upgrade.plan');
    Route::post('business/filter', [ADMIN\AcnooBusinessController::class, 'acnooFilter'])->name('business.filter');
    Route::post('business/filter_business', [ADMIN\AcnooBusinessController::class, 'filter'])->name('business.filter_business');

    Route::post('business/status/{id}',[ADMIN\AcnooBusinessController::class,'status'])->name('business.status');
    Route::post('business/delete-all', [ADMIN\AcnooBusinessController::class,'deleteAll'])->name('business.delete-all');

    // Business Categories
    Route::resource('business-categories',ADMIN\AcnooBusinessCategoryController::class)->except('show');
    Route::post('business-category/filter', [ADMIN\AcnooBusinessCategoryController::class, 'acnooFilter'])->name('business-categories.filter');
    Route::post('business-categories/status/{id}',[ADMIN\AcnooBusinessCategoryController::class,'status'])->name('business-categories.status');
    Route::post('business-categories/delete-all', [ADMIN\AcnooBusinessCategoryController::class,'deleteAll'])->name('business-categories.delete-all');

   // Shipping Companies

    Route::resource('shipping-companies',ADMIN\AcnooShippingCompaniesController::class)->except('show');
    Route::post('shipping-companies/filter', [ADMIN\AcnooShippingCompaniesController::class, 'acnooFilter'])->name('shipping-companies.filter');
    Route::post('shipping-companies/status/{id}',[ADMIN\AcnooShippingCompaniesController::class,'status'])->name('shipping-companies.status');
    Route::post('shipping-companies/delete-all', [ADMIN\AcnooShippingCompaniesController::class,'deleteAll'])->name('shipping-companies.delete-all');


    

    Route::resource('profiles', ADMIN\ProfileController::class)->only('index', 'update');

    Route::resource('subscription-reports', ADMIN\SubscriptionReport::class)->only('index');
    Route::post('subscription-reports/filter', [ADMIN\SubscriptionReport::class, 'acnooFilter'])->name('subscription-reports.filter');
    Route::post('subscription-reports/reject/{id}',[ADMIN\SubscriptionReport::class,'reject'])->name('subscription-reports.reject');
    Route::post('subscription-reports/paid/{id}',[ADMIN\SubscriptionReport::class,'paid'])->name('subscription-reports.paid');
    Route::get('subscription-report/get-invoice/{id}', [ADMIN\SubscriptionReport::class, 'getInvoice'])->name('subscription-reports.invoice');

    // Roles & Permissions
    Route::resource('roles', ADMIN\RoleController::class)->except('show');
    Route::resource('permissions', ADMIN\PermissionController::class)->only('index', 'store');

    // Settings
    Route::resource('addons', ADMIN\AddonController::class)->only('index', 'store', 'show');
    Route::resource('settings', ADMIN\SettingController::class)->only('index', 'update');
    Route::resource('system-settings', ADMIN\SystemSettingController::class)->only('index', 'store');

    // Gateway
    Route::resource('gateways', ADMIN\GatewayController::class)->only('index', 'update');

    Route::resource('currencies', ADMIN\AcnooCurrencyController::class)->except('show');
    Route::post('currencies/filter', [ADMIN\AcnooCurrencyController::class, 'acnooFilter'])->name('currencies.filter');
    Route::match(['get', 'post'], 'currencies/default/{id}', [ADMIN\AcnooCurrencyController::class, 'default'])->name('currencies.default');
    Route::post('currencies/delete-all', [ADMIN\AcnooCurrencyController::class,'deleteAll'])->name('currencies.delete-all');

    // Notifications manager
    Route::prefix('notifications')->controller(ADMIN\NotificationController::class)->name('notifications.')->group(function () {
        Route::get('/', 'mtIndex')->name('index');
        Route::get('/{id}', 'mtView')->name('mtView');
        Route::get('view/all/', 'mtReadAll')->name('mtReadAll');
    });
});
