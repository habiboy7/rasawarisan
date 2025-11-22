<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Region;
use Illuminate\Http\Request;

class PartnerApiController extends Controller
{
    // GET /api/province/{slug}/partners?limit=20
    public function listByProvince(Request $request, $slug)
    {
        $prov = Region::where('slug', $slug)->where('type', 'provinsi')->firstOrFail();

        $perPage = (int) $request->query('limit', 12);

        $partners = Partner::where('region_id', $prov->id)
            ->select('id', 'name', 'slug', 'address', 'lat', 'lng', 'logo_url', 'is_verified')
            ->orderByDesc('is_verified')
            ->paginate($perPage);

        return response()->json($partners);
    }

    // GET /api/partner/{id}  
    public function detail($id)
    {
        $partner = Partner::with(['products.dish'])
            ->select('id', 'user_id', 'region_id', 'name', 'address', 'lat', 'lng', 'phone', 'email', 'logo_url', 'description', 'is_verified')
            ->findOrFail($id);

        return response()->json($partner);
    }
}
