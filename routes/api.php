<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionApiController;
use App\Http\Controllers\Api\DishApiController;
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
