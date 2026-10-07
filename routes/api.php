<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallingController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\DailyRewardController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UserController;
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
Route::get('/countries', [CommonController::class, 'getCountries']);
/*
|--------------------------------------------------------------------------
| Protected Routes (Require Sanctum Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // User & Auth
    Route::prefix('/people')->group(function () {
        Route::post('/list', [UserController::class, 'list']);
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    });

    // Match
    Route::prefix('call')->group(function () {
        Route::get('/match', [CallingController::class, 'match']);
        Route::post('/start', [CallingController::class, 'start']);
        Route::post('/connected', [CallingController::class, 'connected']);
        Route::post('/end', [CallingController::class, 'end']);
        Route::post('/rejected', [CallingController::class, 'rejected']);
    });

    // follower
    Route::prefix('follower')->group(function () {
        Route::post('/add', [FollowController::class, 'add']);
        Route::post('/remove', [FollowController::class, 'remove']);
    });

    // post
    Route::prefix('post')->group(function () {
        Route::post('/list', [PostController::class, 'followingPosts']);
        Route::post('/upload', [PostController::class, 'upload']);
        Route::post('/like', [PostController::class, 'like']);
        Route::post('/comment', [PostController::class, 'comment']);
        Route::post('/comment-like', [PostController::class, 'commentLike']);
        Route::post('/comment-reply', [PostController::class, 'commentReply']);
    });

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/wallet-transaction', [ProfileController::class, 'walletTransaction']);
        Route::post('/picture-update', [ProfileController::class, 'updateProfilepicture']);
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
        Route::get('/list', [SettingController::class, 'list']); // Changed from /get/daily/reward/list
        Route::get('/privacy-policy', [SettingController::class, 'privacyPolicy']); // Changed from /get/daily/reward/list
        Route::get('/term-condition', [SettingController::class, 'termCondition']); // Changed from /get/daily/reward/list
    });
});
