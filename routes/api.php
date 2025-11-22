<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionApiController;
use App\Http\Controllers\Api\DishApiController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\PartnerApiController;

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
  // Regions
  Route::get('/regions', [RegionApiController::class, 'index']);
  Route::get('/regions/{slug}/children', [RegionApiController::class, 'children']);
  Route::get('/provinsi/{slug}', [RegionApiController::class, 'showProvince']);

  // Dishes
  Route::get('/provinsi/{slug}/dishes', [DishApiController::class, 'listByProvince']);
  Route::get('/dish/{slug}', [DishApiController::class, 'detail']);
  Route::get('/dish/{slug}/partners', [DishApiController::class, 'partners']);

  // Partners (public read)
  Route::get('/provinsi/{slug}/partners', [PartnerApiController::class, 'listByProvince']);
  Route::get('/partner/{id}', [PartnerApiController::class, 'detail']);

  // Protected endpoints (example) - require Sanctum auth
  Route::middleware('auth:sanctum')->group(function () {
    Route::post('/partner', [PartnerApiController::class, 'store']);       // daftar mitra
    Route::post('/dish/{slug}/review', [DishApiController::class, 'review']); // tambah review dll
  });
});

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {
  // ... routes yang sudah ada ...

  // ========== EVENTS (Public) ==========
  Route::get('/events', [EventApiController::class, 'index']);
  Route::get('/events/featured', [EventApiController::class, 'featured']);
  Route::get('/events/calendar', [EventApiController::class, 'calendar']);
  Route::get('/events/{slug}', [EventApiController::class, 'detail']);
  Route::get('/region/{slug}/events', [EventApiController::class, 'byRegion']);

  // ========== EVENTS (Auth Required) ==========
  Route::middleware('auth:sanctum')->group(function () {
    // User events
    Route::post('/events/{slug}/save', [EventApiController::class, 'toggleSave']);
    Route::get('/user/saved-events', [EventApiController::class, 'userSavedEvents']);
    Route::get('/user/events', [EventApiController::class, 'userEvents']);
    
    // Create & manage events
    Route::post('/events', [EventApiController::class, 'store']);
    Route::put('/events/{slug}', [EventApiController::class, 'update']);
    Route::post('/events/{slug}/submit', [EventApiController::class, 'submit']);
    Route::delete('/events/{slug}', [EventApiController::class, 'destroy']);
    Route::get('/events/{slug}/analytics', [EventApiController::class, 'analytics']);
    
    // Admin only (tambah middleware admin nanti)
    Route::get('/admin/events', [EventApiController::class, 'adminIndex']);
    Route::put('/admin/events/{slug}/approve', [EventApiController::class, 'approve']);
    Route::put('/admin/events/{slug}/reject', [EventApiController::class, 'reject']);
    Route::put('/admin/events/{slug}/feature', [EventApiController::class, 'toggleFeature']);
  });
});
