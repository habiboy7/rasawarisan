<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionApiController extends Controller
{
    // GET /api/regions?type=pulau|provinsi&type=...
    public function index(Request $request)
    {
        $type = $request->query('type', 'pulau');
        $regions = Region::where('type', $type)
            ->select('id', 'name', 'slug', 'type', 'parent_id', 'center_lat', 'center_lng')
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $regions]);
    }

    // GET /api/regions/{slug}/children
    public function children($slug)
    {
        $region = Region::where('slug', $slug)->firstOrFail();
        $children = Region::where('parent_id', $region->id)
            ->select('id', 'name', 'slug', 'type', 'center_lat', 'center_lng')
            ->orderBy('name')
            ->get();

        return response()->json([
            'pulau' => $region->only(['id', 'name', 'slug', 'type']),
            'children' => $children
        ]);
    }

    // GET /api/province/{slug}
    // detail provinsi: region info + map + top dishes + top partners
    public function showProvince($slug)
    {
        $prov = Region::where('slug', $slug)->where('type', 'provinsi')->firstOrFail();

        // eager load counts and limited items
        $dishes = $prov->dishes()
            ->select('id', 'name', 'slug', 'short_description', 'main_image_url', 'likes_count')
            ->orderByDesc('likes_count')
            ->take(12)
            ->get();

        $partners = $prov->partners()
            ->select('id', 'name', 'slug', 'address', 'lat', 'lng', 'logo_url', 'is_verified')
            ->take(12)
            ->get();

        return response()->json([
            'region' => $prov->only(['id', 'name', 'slug', 'center_lat', 'center_lng', 'geojson']),
            'map' => [
                'center_lat' => $prov->center_lat,
                'center_lng' => $prov->center_lng,
                'geojson' => $prov->geojson,
            ],
            'dishes' => $dishes,
            'partners' => $partners,
        ]);
    }
}
