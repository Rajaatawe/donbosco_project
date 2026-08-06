<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AppConfigController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ActivityCategoryController;
// Guest routes
Route::get('/banners', [AppConfigController::class, 'get_active_banners']);
Route::get('/pages', [AppConfigController::class, 'get_published_pages']);
Route::get('/settings', [AppConfigController::class, 'get_site_settings']);
Route::get('/activities', [ActivityController::class, 'get_published_activities']);
Route::get('/gallery-albums', [GalleryController::class, 'get_albums']);
Route::get('/gallery-albums/{id}/images', [GalleryController::class, 'get_images_by_album_id']);
Route::get('/activity-categories', [ActivityCategoryController::class, 'index']);

Route::get('/programs', [ProgramController::class, 'index']);

// News routes
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

// Event Controller
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{slug}', [EventController::class, 'show']);

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/sendEmail', [AuthController::class, 'send_email']);
Route::post('/verifyCode', [AuthController::class, 'verify_code']);
Route::post('/verifyForNewPassword', [AuthController::class, 'verify_for_new_password']);
Route::post('/resetPassword', [AuthController::class, 'reset_password']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/refreshToken', [AuthController::class, 'refresh']);


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:user')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/programs/{id}/apply', [ProgramController::class, 'apply']);
        Route::post('/sendMessage', [ContactMessageController::class, 'send_message']);
    });
});
