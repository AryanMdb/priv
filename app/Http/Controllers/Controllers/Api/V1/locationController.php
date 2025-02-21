<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Location;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StoreLocation;

class locationController extends Controller
{
    public function createLocation(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'location' => [
                    'required',
                    Rule::unique('locations')->where(function ($query) {
                        return $query->where('user_id', auth()->id());
                    }),
                ],
                'area' => 'nullable|string|max:255',
                'name' => 'required',
                'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
                'landmark' => 'nullable|string|max:255',
                'pincode' => 'required|string|max:10',
                'city' => 'required|string|max:255',
                'default_address' => 'nullable|boolean',
                'type' => 'required|in:home,office',
            ]);

            // Check if the new location is being set as the default
            if ($validated['default_address'] ?? false) {
                // Update all other locations for the user to set default_address as false
                Location::where('user_id', auth()->id())
                    ->update(['default_address' => false]);
            }

            // Create the new location
            $newLocation = Location::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'location' => $validated['location'],
                'area' => $validated['area'] ?? null,
                'landmark' => $validated['landmark'] ?? null,
                'pincode' => $validated['pincode'],
                'city' => $validated['city'],
                'default_address' => $validated['default_address'] ?? false,
                'type' => $validated['type'],
                'latitude' => $request->latitude ?? 0.00,
                'longitude' => $request->longitude ?? 0.00,
            ]);

            // Return a success response
            return response()->json([
                'data' => $newLocation,
                'success' => true,
                'message' => 'Location created successfully.',
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(), // Return validation errors
            ], 422);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the location.',
            ], 500);
        }
    }
    public function getLocations()
    {
        try {
            $locations = Location::where('user_id', auth()->user()->id)->get();

            $locations = $locations->map(function ($location) {
              
                return [
                    'id' => $location->id,
                    'user_id' => $location->user_id,
                    'location' => json_decode($location->location, true) ?? $location->location,
                    'name' => json_decode($location->name, true) ?? $location->name,
                    'phone' => $location->phone ?? $location->phone,
                    'area' => json_decode($location->area, true) ?? $location->area,
                    'landmark' => json_decode($location->landmark, true) ?? $location->landmark,
                    'pincode' => $location->pincode?? $location->pincode,
                    'city' => json_decode($location->city, true) ?? $location->city,
                    'default_address' => json_decode($location->default_address, true) ?? (bool) $location->default_address,
                    'type' => json_decode($location->type, true) ?? $location->type,
                    'latitude' => json_decode($location->latitude, true) ?? (float) $location->latitude??0.00,
                    'longitude' => json_decode($location->longitude, true) ?? (float) $location->longitude??0.00,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Locations retrieved successfully.',
                'data' => $locations,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching locations.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteLocation($id)
    {
        if (isset($id) && !empty($id)) {
            $location = Location::find($id);

            if ($location) {
                // Delete the location
                $location->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Location deleted successfully.',
                ], 200); // Changed to 200 for successful deletion
            } else {
                // If location is not found
                return response()->json([
                    'success' => false,
                    'message' => 'Location not found.',
                ], 404);
            }
        } else {
            // If invalid ID is provided
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID provided.',
            ], 400);
        }
    }
    public function editLocation($id)
    {
        $location = Location::find($id);
        if ($location) {
            return response()->json([
                'data' => $location,
                'success' => true,
                'message' => 'Location Found successfully.',
            ], 201);
        } else {
            return response()->json([
                $location,
                'success' => false,
                'message' => 'Location not found.',
            ], 404);
        }
    }
    public function updateLocation(Request $request, $id)
    {

        try {
            $location = Location::where('id', $id)->where('user_id', auth()->id())->first();

            if (!$location) {
                return response()->json([
                    'success' => false,
                    'message' => 'Location not found or access denied.',
                ], 404);
            }

            // Validate the request data
            $request->validate([
                'location' => 'required',
                'name' => 'required',
                'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
                'area' => 'nullable|string|max:255',
                'landmark' => 'nullable|string|max:255',
                'pincode' => 'required|string|max:10',
                'city' => 'required|string|max:255',
                'default_address' => 'nullable|boolean',
                'type' => 'required|in:office,home',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
            ]);

            if ($request->default_address) {
                // Update all other locations to false
                Location::where('user_id', auth()->id())
                    ->where('id', '!=', $id)
                    ->update(['default_address' => false]);

                $location->default_address = true;
            } else {
                $location->default_address = false;
            }
            $location->save();


            // Update the location fields
            $location->location = $request->location;
            $location->name = $request->name;
            $location->phone = $request->phone;
            $location->area = $request->area;
            $location->landmark = $request->landmark;
            $location->pincode = $request->pincode;
            $location->city = $request->city;
            $location->default_address = $request->default_address ?? false; // Ensure it's not null
            $location->type = $request->type;
            $location->latitude = $request->latitude ?? 0.00;
            $location->longitude = $request->longitude ?? 0.00;

            // Save the updated location
            $location->save();

            return response()->json([
                'data' => $location,
                'success' => true,
                'message' => 'Location updated successfully.',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(), // Return validation errors
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the location.',
                'error' => $e->getMessage(), // Include the exception message
            ], 500);
        }
    }
    public function stroeLocation()
    {
        try {
            $store_location = StoreLocation::first();
    
            if (!$store_location) {
                return response()->json([
                    'success' => false,
                    'message' => 'No store location found.',
                ], 404);
            }
    
            $store_location->distance = json_decode($store_location->distance, true);
            $store_location->distance_charge = json_decode($store_location->distance_charge, true);
    
            return response()->json([
                'success' => true,
                'data' => $store_location,
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the location.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
