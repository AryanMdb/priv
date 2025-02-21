<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DeliveryChargesController extends Controller
{
    public function view(){
        $deliveryCharges = DeliveryCharge::get();
        return view('admin.delivery_charges.form', compact('deliveryCharges'));
    }

    public function updateDeliveryCharges(Request $request){
        $messages = [
            'delivery_charges.*.max' => 'You cannot add more than 1000 rupees',
            'delivery_charges.*.numeric' => 'Delivery charges should be in number only',
            'delivery_charges.*.required' => 'Delivery charges are required',
            'delivery_charges' => 'Delivery charges are required',
        ];
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:delivery_charges,id',
            'delivery_charges' => 'required|array',
            'delivery_charges.*' => 'required|numeric|min:0|max:1000'
        ], $messages);
    
        $ids = $request->ids;
        $deliveryCharges = $request->delivery_charges;
    
        foreach ($ids as $index => $id) {
            $deliveryCharge = DeliveryCharge::findOrFail($id);
            $deliveryCharge->update([
                'delivery_charges' => $deliveryCharges[$index]
            ]);
        }
        Alert::success('Success', 'Delivery charges updated successfully.');
        return redirect()->back();
    }
}