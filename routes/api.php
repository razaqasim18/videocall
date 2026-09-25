<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DailyRewardController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/social-login', [AuthController::class, 'socialLogin']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Sanctum Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // User & Auth
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    });

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/wallet-transaction', [ProfileController::class, 'walletTransaction']);
        Route::post('/update', [ProfileController::class, 'updateProfile']);
    });

    // Ticket
    Route::prefix('ticket')->group(function () {
        Route::get('/list', [TicketController::class, 'list']);
        Route::post('/detail', [TicketController::class, 'detail']);
        Route::post('/reply', [TicketController::class, 'reply']);
        Route::post('/create', [TicketController::class, 'create']);
    });

    // Daily Rewards
    Route::prefix('daily-rewards')->group(function () {
        Route::get('/list', [DailyRewardController::class, 'list']);
        Route::post('/claim', [DailyRewardController::class, 'claim']);
    });

    // subscription
    Route::prefix('subscription')->group(function () {
        Route::get('/list', [SubscriptionController::class, 'list']);
    });

    // setting
    Route::prefix('setting')->group(function () {
        Route::get('/privacy-policy', [SettingController::class, 'privacyPolicy']); // Changed from /get/daily/reward/list
        Route::get('/term-condition', [SettingController::class, 'termCondition']); // Changed from /get/daily/reward/list
    });
});
