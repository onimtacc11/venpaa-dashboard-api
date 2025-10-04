<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\DocNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    public function generateLocationCode(Request $request)
    {
        try {
            $doc = DocNumber::where('type', 'Location')->first();

            if (!$doc) {
                // If no Location document exists, create one
                $doc = DocNumber::create([
                    'type' => 'Location',
                    'prefix' => 'L',
                    'last_id' => 1
                ]);
            }

            $nextId = $doc->last_id + 1;
            $number = $doc->prefix . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            return response()->json([
                'success' => true,
                'message' => 'Code generated successfully',
                'code' => $number
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $locations = Location::where('is_active', 1)->get();
            return response()->json([
                'success' => true,
                'message' => 'Locations fetched successfully',
                'data' => LocationResource::collection($locations)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch locations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($loca_code)
    {
        try {
            $location = Location::where('loca_code', $loca_code)->firstOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Location fetched successfully',
                'data' => new LocationResource($location)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Location not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(LocationRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle boolean conversion from FormData
            if (isset($data['is_active'])) {
                $data['is_active'] = (int) filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
            }

            $data['created_by'] = auth()->id();
            $location = Location::create($data);

            $doc = DocNumber::where('type', 'Location')->first();
            if ($doc) {
                $doc->last_id += 1;
                $doc->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Location created successfully',
                'data' => new LocationResource($location)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create location',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(LocationRequest $request, $loca_code)
    {
        try {
            $data = $request->validated();

            if (isset($data['is_active'])) {
                $data['is_active'] = (int) filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN);
            }

            $location = Location::where('loca_code', $loca_code)->firstOrFail();
            $data['updated_by'] = auth()->id();
            $location->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully',
                'data' => new LocationResource($location)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}