<?php

use Illuminate\Support\Facades\Route;
use Modules\Business\App\Http\Controllers as Business;

// Centralized Chat Routes
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
