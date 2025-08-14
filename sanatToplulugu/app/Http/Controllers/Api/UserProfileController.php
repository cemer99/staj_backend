<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = UserProfile::with('user', 'user.instruments');

        // Filter by city
        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        // Filter by district
        if ($request->has('district')) {
            $query->where('district', $request->district);
        }

        // Filter by skill level
        if ($request->has('skill_level')) {
            $query->where('skill_level', $request->skill_level);
        }

        // Search by name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        $profiles = $query->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $profiles
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $profile = UserProfile::with('user', 'user.instruments')->find($request->id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'skill_level' => 'in:beginner,intermediate,advanced,professional'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $profile->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $profile->load('user', 'user.instruments')
        ]);
    }

    /**
     * Get cities with user counts
     */
    public function cities()
    {
        $cities = UserProfile::select('city')
                           ->selectRaw('COUNT(*) as user_count')
                           ->whereNotNull('city')
                           ->groupBy('city')
                           ->orderBy('user_count', 'desc')
                           ->get();

        return response()->json([
            'success' => true,
            'data' => $cities
        ]);
    }

    /**
     * Get districts by city
     */
    public function getDistricts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $districts = UserProfile::select('district')
                              ->selectRaw('COUNT(*) as user_count')
                              ->where('city', $request->city)
                              ->whereNotNull('district')
                              ->groupBy('district')
                              ->orderBy('user_count', 'desc')
                              ->get();

        return response()->json([
            'success' => true,
            'data' => $districts
        ]);
    }
}
