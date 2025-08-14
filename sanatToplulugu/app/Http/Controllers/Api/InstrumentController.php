<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Instrument::where('is_active', true);

        // Category filter
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Search filter
        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $instruments = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $instruments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:instruments',
            'category' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $instrument = Instrument::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Instrument created successfully',
            'data' => $instrument
        ], 201);
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

        $instrument = Instrument::with('users')->find($request->id);

        if (!$instrument) {
            return response()->json([
                'success' => false,
                'message' => 'Instrument not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $instrument
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Log gelen isteği kontrol etmek için (debug amaçlı)
        Log::info('Update request data: ', $request->all());
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:instruments,id',
            'name' => 'required|string|max:255|unique:instruments,name,' . $request->id,
            'category' => 'required|string|max:255', 
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $instrument = Instrument::find($request->id);

        if (!$instrument) {
            return response()->json([
                'success' => false,
                'message' => 'Instrument not found'
            ], 404);
        }

        $instrument->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Instrument updated successfully',
            'data' => $instrument
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Log gelen isteği kontrol etmek için (debug amaçlı)
        Log::info('Delete request data: ', $request->all());
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:instruments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $instrument = Instrument::find($request->id);

        if (!$instrument) {
            return response()->json([
                'success' => false,
                'message' => 'Instrument not found'
            ], 404);
        }

        $instrument->delete();

        return response()->json([
            'success' => true,
            'message' => 'Instrument deleted successfully'
        ]);
    }

    /**
     * Get instruments by category
     */
    public function getByCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $instruments = Instrument::where('category', $request->category)
                                ->where('is_active', true)
                                ->orderBy('name')
                                ->get();

        return response()->json([
            'success' => true,
            'data' => $instruments
        ]);
    }

    /**
     * Get all categories
     */
    public function categories()
    {
        $categories = Instrument::where('is_active', true)
                               ->select('category')
                               ->distinct()
                               ->orderBy('category')
                               ->pluck('category');

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
