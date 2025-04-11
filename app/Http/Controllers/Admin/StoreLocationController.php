<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreLocation;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class StoreLocationController extends Controller
{
    public function view()
    {
        $store_location = StoreLocation::first();
        return view('admin.settings.store_location', compact('store_location'));
    }

    public function updateStoreLocation(Request $request)
    {

        try {
            $store_location = StoreLocation::updateOrCreate(
                ['id' => 1],
                values: [
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'delivery_radius' => $request->delivery_radius,
                    'distance' => json_encode($request->distance) ?? 0,
                    'distance_charge' => json_encode($request->distance_charge ?? 0),
                ]
            );

            Alert::success('Success', 'Store Location Updated Successfully!');
            return redirect()->route('store_location.view');

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}