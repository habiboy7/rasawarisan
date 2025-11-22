<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Region;
use Illuminate\Http\Request;

class DishApiController extends Controller
{
    // GET /api/province/{slug}/dishes?limit=20&page=1
    public function listByProvince(Request $request, $slug)
    {
        $prov = Region::where('slug', $slug)->where('type', 'provinsi')->firstOrFail();

        $perPage = (int) $request->query('limit', 12);
        $dishes = Dish::where('region_id', $prov->id)
            ->select('id', 'name', 'slug', 'short_description', 'main_image_url', 'likes_count')
            ->orderByDesc('likes_count')
            ->paginate($perPage);

        return response()->json($dishes);
    }

    // GET /api/dish/{slug}
    public function detail($slug)
    {
        $dish = Dish::where('slug', $slug)
            ->with(['region:id,name,slug', 'partners' => function ($q) {
                $q->select('partners.id', 'partners.name', 'partners.address', 'partners.lat', 'partners.lng', 'partners.logo_url');
            }])
            ->firstOrFail();

        return response()->json([
            'id' => $dish->id,
            'name' => $dish->name,
            'slug' => $dish->slug,
            'short_description' => $dish->short_description,
            'history' => $dish->history,
            'recipe' => $dish->recipe,
            'main_image_url' => $dish->main_image_url,
            'likes_count' => $dish->likes_count,
            'region' => $dish->region,
            'partners' => $dish->partners,
        ]);
    }

    // GET /api/dish/{slug}/partners
    public function partners($slug)
    {
        $dish = Dish::where('slug', $slug)->firstOrFail();

        $partners = $dish->partners()
            ->select('partners.id', 'partners.name', 'partners.address', 'partners.lat', 'partners.lng', 'partners.logo_url')
            ->get();

        return response()->json(['partners' => $partners]);
    }
}
