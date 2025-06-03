<?php
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('business', ADMIN\AcnooBusinessController::class);
});