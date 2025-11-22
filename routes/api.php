<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegionApiController;
use App\Http\Controllers\Api\DishApiController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\PartnerApiController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\FavoriteController;

Route::prefix('v1')->middleware('throttle:60,1')->group(function () {

  // ========== REGIONS ==========
  Route::get('/regions', [RegionApiController::class, 'index']);
  Route::get('/regions/{slug}/children', [RegionApiController::class, 'children']);
  Route::get('/provinsi/{slug}', [RegionApiController::class, 'showProvince']);

  // ========== MAP INTERAKTIF ==========
  Route::get('/provinsi/{slug}/map-data', [RegionApiController::class, 'mapData']);
  Route::get('/kabupaten/{slug}', [RegionApiController::class, 'showKabupaten']);
  Route::get('/kabupaten/{slug}/dishes', [RegionApiController::class, 'kabupatenDishes']);
  Route::get('/kabupaten/{slug}/partners', [RegionApiController::class, 'kabupatenPartners']);

  // ========== DISHES ==========
  Route::get('/provinsi/{slug}/dishes', [DishApiController::class, 'listByProvince']);
  Route::get('/dish/{slug}', [DishApiController::class, 'detail']);
  Route::get('/dish/{slug}/partners', [DishApiController::class, 'partners']);

  // ========== PARTNERS ==========
  Route::get('/provinsi/{slug}/partners', [PartnerApiController::class, 'listByProvince']);
  Route::get('/partner/{id}', [PartnerApiController::class, 'detail']);

  // ========== EVENTS (Public) ==========
  Route::get('/events', [EventApiController::class, 'index']);
  Route::get('/events/featured', [EventApiController::class, 'featured']);
  Route::get('/events/calendar', [EventApiController::class, 'calendar']);
  Route::get('/events/{slug}', [EventApiController::class, 'detail']);
  Route::get('/region/{slug}/events', [EventApiController::class, 'byRegion']);

  //! ========== PROTECTED ROUTES (Auth Required) ==========
  Route::middleware('auth:sanctum')->group(function () {
    // LIKE/UNLIKE
    Route::post('/dish/{slug}/like', [LikeController::class, 'toggleDishLike']);
    Route::get('/user/liked-dishes', [LikeController::class, 'userLikedDishes']);

    // FAVORITES
    Route::post('/dish/{slug}/favorite', [FavoriteController::class, 'toggleDishFavorite']);
    Route::post('/partner/{id}/favorite', [FavoriteController::class, 'togglePartnerFavorite']);
    Route::get('/user/favorite-dishes', [FavoriteController::class, 'userFavoriteDishes']);
    Route::get('/user/favorite-partners', [FavoriteController::class, 'userFavoritePartners']);

    // PARTNER REGISTRATION
    Route::post('/partner/register', [PartnerApiController::class, 'register']);
    Route::get('/partner/my-partner', [PartnerApiController::class, 'myPartner']);
    Route::put('/partner/my-partner', [PartnerApiController::class, 'updateMyPartner']);

    // Partners
    Route::post('/partner', [PartnerApiController::class, 'store']);

    // Dishes
    Route::post('/dish/{slug}/review', [DishApiController::class, 'review']);

    // Events - User
    Route::post('/events/{slug}/save', [EventApiController::class, 'toggleSave']);
    Route::get('/user/saved-events', [EventApiController::class, 'userSavedEvents']);
    Route::get('/user/events', [EventApiController::class, 'userEvents']);

    // Events - Create & Manage
    Route::post('/events', [EventApiController::class, 'store']);
    Route::put('/events/{slug}', [EventApiController::class, 'update']);
    Route::post('/events/{slug}/submit', [EventApiController::class, 'submit']);
    Route::delete('/events/{slug}', [EventApiController::class, 'destroy']);
    Route::get('/events/{slug}/analytics', [EventApiController::class, 'analytics']);

    // Events - Admin (TODO: tambah middleware 'admin' nanti)
    Route::get('/admin/events', [EventApiController::class, 'adminIndex']);
    Route::put('/admin/events/{slug}/approve', [EventApiController::class, 'approve']);
    Route::put('/admin/events/{slug}/reject', [EventApiController::class, 'reject']);
    Route::put('/admin/events/{slug}/feature', [EventApiController::class, 'toggleFeature']);

    // ADMIN - Partners
    Route::get('/admin/partners/pending', [PartnerApiController::class, 'pendingPartners']);
    Route::put('/admin/partners/{id}/verify', [PartnerApiController::class, 'verifyPartner']);
    Route::put('/admin/partners/{id}/reject', [PartnerApiController::class, 'rejectPartner']);
  });
});
