<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\User;
use App\Models\Partner;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // POST /api/v1/dish/{slug}/favorite
    public function toggleDishFavorite($slug)
    {
        $dish = Dish::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        $existing = UserFavorite::where('user_id', $user->id)
            ->where('favoritable_type', Dish::class)
            ->where('favoritable_id', $dish->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['message' => 'Removed from favorites', 'favorited' => false]);
        } else {
            UserFavorite::create([
                'user_id' => $user->id,
                'favoritable_type' => Dish::class,
                'favoritable_id' => $dish->id,
            ]);
            return response()->json(['message' => 'Added to favorites', 'favorited' => true]);
        }
    }

    // POST /api/v1/partner/{id}/favorite
    public function togglePartnerFavorite($id)
    {
        $partner = Partner::findOrFail($id);
        $user = Auth::user();

        $existing = UserFavorite::where('user_id', $user->id)
            ->where('favoritable_type', Partner::class)
            ->where('favoritable_id', $partner->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['message' => 'Removed from favorites', 'favorited' => false]);
        } else {
            UserFavorite::create([
                'user_id' => $user->id,
                'favoritable_type' => Partner::class,
                'favoritable_id' => $partner->id,
            ]);
            return response()->json(['message' => 'Added to favorites', 'favorited' => true]);
        }
    }

    // GET /api/v1/user/favorite-dishes
    public function userFavoriteDishes()
    {
        $user = Auth::user();

        $dishes = $user->favoriteDishes()
            ->select(
                'dishes.id',
                'dishes.name',
                'dishes.slug',
                'dishes.short_description',
                'dishes.main_image_url',
                'dishes.likes_count'
            )
            ->with('region:id,name,slug')
            ->orderBy('user_favorites.created_at', 'desc')
            ->paginate(12);

        return response()->json($dishes);
    }

    // GET /api/v1/user/favorite-partners
    public function userFavoritePartners()
    {
        $user = Auth::user();

        $partners = $user->favoritePartners()
            ->select(
                'partners.id',
                'partners.name',
                'partners.address',
                'partners.lat',
                'partners.lng',
                'partners.logo_url',
                'partners.is_verified'
            )
            ->with('region:id,name,slug')
            ->orderBy('user_favorites.created_at', 'desc')
            ->paginate(12);

        return response()->json($partners);
    }
}
