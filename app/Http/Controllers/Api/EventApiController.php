<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventApiController extends Controller
{
    // GET /api/v1/events
    // List events (public)
    public function index(Request $request)
    {
        $query = Event::approved()
            ->with(['region:id,name,slug', 'dish:id,name,slug']);

        // Filter by status (upcoming/past/ongoing)
        $filter = $request->query('filter', 'upcoming');
        if ($filter === 'upcoming') {
            $query->upcoming();
        } elseif ($filter === 'past') {
            $query->past();
        } elseif ($filter === 'ongoing') {
            $query->ongoing();
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->query('category'));
        }

        // Filter by region
        if ($request->has('region_id')) {
            $query->where('region_id', $request->query('region_id'));
        }

        // Search
        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->query('limit', 12);
        $events = $query->paginate($perPage);

        return response()->json($events);
    }

    // GET /api/v1/events/featured
    public function featured()
    {
        $events = Event::approved()
            ->featured()
            ->upcoming()
            ->with(['region:id,name,slug', 'dish:id,name,slug'])
            ->take(6)
            ->get();

        return response()->json(['data' => $events]);
    }

    // GET /api/v1/events/{slug}
    public function detail($slug)
    {
        $event = Event::where('slug', $slug)
            ->with([
                'region:id,name,slug',
                'dish:id,name,slug',
                'partner:id,name,logo_url'
            ])
            ->firstOrFail();

        // Increment view count (only for approved events)
        if ($event->status === 'approved') {
            $event->incrementViewCount();
        }

        return response()->json($event);
    }

    // GET /api/v1/events/calendar
    // Events grouped by date
    public function calendar(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $events = Event::approved()
            ->whereYear('start_date', $year)
            ->whereMonth('start_date', $month)
            ->orderBy('start_date')
            ->get(['id', 'title', 'slug', 'start_date', 'end_date', 'category', 'location_name']);

        // Group by date
        $grouped = $events->groupBy(function ($event) {
            return $event->start_date->format('Y-m-d');
        });

        return response()->json(['calendar' => $grouped]);
    }

    // GET /api/v1/region/{slug}/events
    public function byRegion($slug)
    {
        $region = Region::where('slug', $slug)->firstOrFail();

        $events = Event::approved()
            ->where('region_id', $region->id)
            ->upcoming()
            ->orderBy('start_date')
            ->paginate(12);

        return response()->json([
            'region' => $region->only(['id', 'name', 'slug']),
            'events' => $events
        ]);
    }

    // POST /api/v1/events/{slug}/save (Auth required)
    public function toggleSave($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Toggle save
        if ($user->savedEvents()->where('event_id', $event->id)->exists()) {
            $user->savedEvents()->detach($event->id);
            return response()->json(['message' => 'Event dihapus', 'saved' => false]);
        } else {
            $user->savedEvents()->attach($event->id);
            return response()->json(['message' => 'Event tersimpan', 'saved' => true]);
        }
    }

    // GET /api/v1/user/saved-events (Auth required)
    public function userSavedEvents()
    {
        $user = Auth::user();

        $events = $user->savedEvents()
            ->approved()
            ->with(['region:id,name,slug', 'dish:id,name,slug'])
            ->orderBy('user_saved_events.created_at', 'desc')
            ->paginate(12);

        return response()->json($events);
    }

    // GET /api/v1/user/events (Auth required)
    // Events created by current user
    public function userEvents()
    {
        $user = Auth::user();

        $events = Event::where('user_id', $user->id)
            ->with(['region:id,name,slug'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return response()->json($events);
    }

    // POST /api/v1/events (Auth required)
    // Create new event
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|in:lomba,festival,workshop,bazaar,pameran,lainnya',
            'description' => 'required|string',
            'poster_url' => 'nullable|url',
            'location_name' => 'required|string|max:255',
            'location_address' => 'required|string',
            'location_lat' => 'nullable|numeric',
            'location_lng' => 'nullable|numeric',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'ticket_price' => 'nullable|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'registration_url' => 'nullable|url',
            'organizer_name' => 'required|string|max:255',
            'organizer_email' => 'required|email',
            'organizer_phone' => 'required|string|max:20',
            'region_id' => 'nullable|exists:regions,id',
            'dish_id' => 'nullable|exists:dishes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        $event = Event::create([
            'user_id' => $user->id,
            'partner_id' => $user->partner ? $user->partner->id : null,
            'status' => 'draft',
            ...$request->all()
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event
        ], 201);
    }

    // PUT /api/v1/events/{slug} (Auth required)
    // Update event (only owner)
    public function update(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Check ownership
        if ($event->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Cannot edit approved/rejected events
        if (in_array($event->status, ['approved', 'rejected'])) {
            return response()->json(['message' => 'Cannot edit event with status: ' . $event->status], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'category' => 'sometimes|in:lomba,festival,workshop,bazaar,pameran,lainnya',
            'description' => 'sometimes|string',
            'start_date' => 'sometimes|date|after:now',
            'end_date' => 'sometimes|date|after:start_date',
            // ... validation lainnya
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event->update($request->all());

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    }

    // POST /api/v1/events/{slug}/submit (Auth required)
    // Submit event for review
    public function submit($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        if ($event->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($event->status !== 'draft' && $event->status !== 'rejected') {
            return response()->json(['message' => 'Event cannot be submitted'], 403);
        }

        $event->update(['status' => 'pending']);

        return response()->json(['message' => 'Event submitted for review']);
    }

    // DELETE /api/v1/events/{slug} (Auth required)
    public function destroy($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        if ($event->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    // GET /api/v1/events/{slug}/analytics (Auth required)
    public function analytics($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        if ($event->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'view_count' => $event->view_count,
            'saved_count' => $event->savedByUsers()->count(),
            'status' => $event->status,
        ]);
    }

    // ====== ADMIN ENDPOINTS ======

    // GET /api/v1/admin/events (Admin only)
    public function adminIndex(Request $request)
    {
        $status = $request->query('status', 'pending');

        $events = Event::where('status', $status)
            ->with(['user:id,name', 'region:id,name'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($events);
    }

    // PUT /api/v1/admin/events/{slug}/approve (Admin only)
    public function approve($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $event->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return response()->json(['message' => 'Event approved successfully']);
    }

    // PUT /api/v1/admin/events/{slug}/reject (Admin only)
    public function reject(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event = Event::where('slug', $slug)->firstOrFail();

        $event->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return response()->json(['message' => 'Event rejected']);
    }

    // PUT /api/v1/admin/events/{slug}/feature (Admin only)
    public function toggleFeature($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $event->update([
            'is_featured' => !$event->is_featured
        ]);

        return response()->json([
            'message' => 'Feature status updated',
            'is_featured' => $event->is_featured
        ]);
    }
}
