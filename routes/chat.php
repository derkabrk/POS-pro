<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

// Centralized Chat Routes
Route::middleware(['auth', 'plan_permission:chat_access'])->group(function () {
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/messages/{userId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');
    Route::post('chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('chat/users/status', function() {
        $users = \App\Models\User::select('id', 'is_online')->get();
        return response()->json($users);
    })->name('chat.users.status');
    Route::get('chat/search-users', [ChatController::class, 'searchUsers'])->name('chat.search-users');
});
