<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\UserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // POST /api/v1/dish/{slug}/like
    // Toggle like/unlike dish
    public function toggleDishLike($slug)
    {
        $dish = Dish::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        $existingLike = UserLike::where('user_id', $user->id)
            ->where('likeable_type', Dish::class)
            ->where('likeable_id', $dish->id)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $dish->decrement('likes_count');

            return response()->json([
                'message' => 'Dish unliked',
                'liked' => false,
                'likes_count' => $dish->likes_count
            ]);
        } else {
            // Like
            UserLike::create([
                'user_id' => $user->id,
                'likeable_type' => Dish::class,
                'likeable_id' => $dish->id,
            ]);

            $dish->increment('likes_count');

            return response()->json([
                'message' => 'Dish liked',
                'liked' => true,
                'likes_count' => $dish->likes_count
            ]);
        }
    }

    // GET /api/v1/user/liked-dishes
    // Get user's liked dishes
    public function userLikedDishes()
    {
        $user = Auth::user();

        $dishes = $user->likedDishes()
            ->select(
                'dishes.id',
                'dishes.name',
                'dishes.slug',
                'dishes.short_description',
                'dishes.main_image_url',
                'dishes.likes_count'
            )
            ->with('region:id,name,slug')
            ->orderBy('user_likes.created_at', 'desc')
            ->paginate(12);

        return response()->json($dishes);
    }
}
