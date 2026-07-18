<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\ExperienceController as AdminExperienceController;
use App\Http\Controllers\Api\Admin\MessageController;
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Api\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API
|--------------------------------------------------------------------------
*/
Route::get('site', [SiteController::class, 'index']);
Route::get('profile', [ProfileController::class, 'show']);
Route::get('skills', [SkillController::class, 'index']);
Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{slug}', [ProjectController::class, 'show']);
Route::get('experiences', [ExperienceController::class, 'index']);
Route::get('testimonials', [TestimonialController::class, 'index']);

Route::post('contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1');

/*
|--------------------------------------------------------------------------
| Admin API
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::get('profile', [AdminProfileController::class, 'show']);
        Route::match(['put', 'patch'], 'profile', [AdminProfileController::class, 'update']);

        Route::apiResource('projects', AdminProjectController::class);
        Route::apiResource('skills', AdminSkillController::class)->except('show');
        Route::apiResource('experiences', AdminExperienceController::class)->except('show');
        Route::apiResource('testimonials', AdminTestimonialController::class)->except('show');

        Route::get('messages', [MessageController::class, 'index']);
        Route::get('messages/{message}', [MessageController::class, 'show']);
        Route::delete('messages/{message}', [MessageController::class, 'destroy']);
    });
});
