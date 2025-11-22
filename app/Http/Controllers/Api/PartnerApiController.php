<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    // POST /api/v1/partner/register
    // User register as partner (status: pending verification)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'region_id' => 'required|exists:regions,id',
            'kabupaten_id' => 'nullable|exists:regions,id',
            'logo_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        // Check if user already has partner
        if ($user->partner) {
            return response()->json(['message' => 'You already registered as partner'], 403);
        }

        $partner = Partner::create([
            'user_id' => $user->id,
            'is_verified' => false, // Pending verification
            ...$request->all()
        ]);

        return response()->json([
            'message' => 'Partner registration submitted. Waiting for admin approval.',
            'partner' => $partner
        ], 201);
    }

    // GET /api/v1/partner/my-partner
    // Get current user's partner info
    public function myPartner()
    {
        $user = Auth::user();

        if (!$user->partner) {
            return response()->json(['message' => 'No partner found'], 404);
        }

        $partner = $user->partner->load(['region:id,name,slug', 'kabupaten:id,name,slug', 'products']);

        return response()->json($partner);
    }

    // PUT /api/v1/partner/my-partner
    // Update own partner info (owner only)
    public function updateMyPartner(Request $request)
    {
        $user = Auth::user();

        if (!$user->partner) {
            return response()->json(['message' => 'No partner found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'address' => 'sometimes|string',
            'phone' => 'sometimes|string|max:20',
            'email' => 'sometimes|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->partner->update($request->all());

        return response()->json([
            'message' => 'Partner updated successfully',
            'partner' => $user->partner
        ]);
    }

    // GET /api/v1/admin/partners/pending
    // Admin: List pending partners
    public function pendingPartners()
    {
        $partners = Partner::where('is_verified', false)
            ->with(['user:id,name,email', 'region:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($partners);
    }

    // PUT /api/v1/admin/partners/{id}/verify
    // Admin: Verify partner
    public function verifyPartner($id)
    {
        $partner = Partner::findOrFail($id);

        $partner->update(['is_verified' => true]);

        return response()->json(['message' => 'Partner verified successfully']);
    }

    // PUT /api/v1/admin/partners/{id}/reject
    // Admin: Reject partner
    public function rejectPartner($id)
    {
        $partner = Partner::findOrFail($id);

        $partner->delete(); // Or set status rejected

        return response()->json(['message' => 'Partner rejected']);
    }
}
