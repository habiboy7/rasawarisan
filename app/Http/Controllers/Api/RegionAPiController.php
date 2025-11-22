<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionApiController extends Controller
{
    // GET /api/v1/regions?type=pulau|provinsi|kabupaten
    public function index(Request $request)
    {
        $type = $request->query('type', 'pulau');
        $regions = Region::where('type', $type)
            ->select('id', 'name', 'slug', 'type', 'parent_id', 'center_lat', 'center_lng')
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $regions]);
    }

    // GET /api/v1/regions/{slug}/children
    public function children($slug)
    {
        $region = Region::where('slug', $slug)->firstOrFail();
        $children = Region::where('parent_id', $region->id)
            ->select('id', 'name', 'slug', 'type', 'center_lat', 'center_lng')
            ->orderBy('name')
            ->get();

        return response()->json([
            'region' => $region->only(['id', 'name', 'slug', 'type']),
            'children' => $children
        ]);
    }

    // GET /api/v1/provinsi/{slug}
    // Detail provinsi: region info + map + top dishes + top partners
    public function showProvince($slug)
    {
        $prov = Region::where('slug', $slug)->where('type', 'provinsi')->firstOrFail();

        // Eager load counts and limited items
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

    // ========================================
    // MAP INTERAKTIF ENDPOINTS
    // ========================================

    // GET /api/v1/provinsi/{slug}/map-data
    // Data lengkap untuk map interaktif: kabupaten + dishes per kabupaten
    public function mapData($slug)
    {
        $provinsi = Region::where('slug', $slug)
            ->where('type', 'provinsi')
            ->firstOrFail();

        // Ambil semua kabupaten di provinsi ini dengan dishes-nya
        $kabupaten = Region::where('parent_id', $provinsi->id)
            ->where('type', 'kabupaten')
            ->with(['dishes' => function ($q) {
                $q->select(
                    'dishes.id',
                    'dishes.name',
                    'dishes.slug',
                    'dishes.kabupaten_id',
                    'dishes.short_description',
                    'dishes.main_image_url',
                    'dishes.likes_count'
                )
                    ->orderByDesc('likes_count')
                    ->take(10); // Max 10 dishes per kabupaten
            }])
            ->get(['id', 'name', 'slug', 'type', 'center_lat', 'center_lng']);

        return response()->json([
            'provinsi' => $provinsi->only(['id', 'name', 'slug', 'center_lat', 'center_lng', 'geojson']),
            'kabupaten' => $kabupaten,
        ]);
    }

    // GET /api/v1/kabupaten/{slug}
    // Detail kabupaten untuk sidebar map
    public function showKabupaten($slug)
    {
        $kabupaten = Region::where('slug', $slug)
            ->where('type', 'kabupaten')
            ->with('parent:id,name,slug')
            ->firstOrFail();

        // Ambil dishes di kabupaten ini
        $dishes = $kabupaten->dishes()
            ->select('id', 'name', 'slug', 'short_description', 'main_image_url', 'likes_count')
            ->orderByDesc('likes_count')
            ->take(20)
            ->get();

        // Ambil partners di kabupaten ini
        $partners = $kabupaten->partners()
            ->select('id', 'name', 'address', 'lat', 'lng', 'logo_url', 'is_verified')
            ->where('is_verified', true)
            ->take(10)
            ->get();

        return response()->json([
            'kabupaten' => $kabupaten->only(['id', 'name', 'slug', 'center_lat', 'center_lng']),
            'provinsi' => $kabupaten->parent,
            'dishes' => $dishes,
            'partners' => $partners,
        ]);
    }

    // GET /api/v1/kabupaten/{slug}/dishes
    // List dishes per kabupaten (with pagination)
    public function kabupatenDishes(Request $request, $slug)
    {
        $kabupaten = Region::where('slug', $slug)
            ->where('type', 'kabupaten')
            ->firstOrFail();

        $perPage = (int) $request->query('limit', 12);

        $dishes = $kabupaten->dishes()
            ->select('id', 'name', 'slug', 'short_description', 'main_image_url', 'likes_count')
            ->orderByDesc('likes_count')
            ->paginate($perPage);

        return response()->json([
            'kabupaten' => $kabupaten->only(['id', 'name', 'slug']),
            'dishes' => $dishes,
        ]);
    }

    // GET /api/v1/kabupaten/{slug}/partners
    // List partners per kabupaten (with pagination)
    public function kabupatenPartners(Request $request, $slug)
    {
        $kabupaten = Region::where('slug', $slug)
            ->where('type', 'kabupaten')
            ->firstOrFail();

        $perPage = (int) $request->query('limit', 12);

        $partners = $kabupaten->partners()
            ->select('id', 'name', 'address', 'lat', 'lng', 'logo_url', 'is_verified', 'phone')
            ->orderByDesc('is_verified')
            ->paginate($perPage);

        return response()->json([
            'kabupaten' => $kabupaten->only(['id', 'name', 'slug']),
            'partners' => $partners,
        ]);
    }
}
