<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\minimum_order_value;
use Illuminate\Http\Request;

class MinimumOrderController extends Controller
{
    public function index()
    {
        $value = minimum_order_value::all();
        return view('admin.settings.min_order', compact('value'));

    }

    public function add(Request $request)
    {
        // ----------- Get Value if exist in Table --------------------
        $existingValue = minimum_order_value::first();

        // ----------- Check if have value work only update -----------
        if ($existingValue) {
            $existingValue->update([
                'minimum_order_value' => $request->min_value,
            ]);
            return redirect()->back()->with('success', 'Settings updated successfully');
        } else {

            // ----------- Check if not have value add new Value ------
            minimum_order_value::create([
                'minimum_order_value' => $request->min_value
            ]);

            // ----------- if edit or insert succesfully send success message ------
            return response()->json(['success' => true, 'message' => 'Minimum order value updated successfully.']);
        }
    }

}
