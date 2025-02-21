<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\GoogleMapsService;
use App\Exports\SubadminOrderExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderManageController extends Controller
{
    protected $googleMapsService;

    public function __construct(GoogleMapsService $googleMapsService)
    {
        $this->googleMapsService = $googleMapsService;
    }
    // public function index(){
    //     try{
    //         $subadmin = auth()->user();
    //         $subadminRoleId = $subadmin->roles->first()->id;

    //         $orders = Order::with('cart', 'user')->where('role_id', $subadminRoleId)->latest()->get();

    //         return view('subadmin.orders.index', compact('orders'));
    //     }catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    public function index()
    {
        try {
            $subadmin = auth()->user();
            $subadminRoleId = $subadmin->roles->first()->id;

            // Fetch orders and filter where role_id contains subadminRoleId
            $orders = Order::with('cart', 'user')
                ->whereRaw("JSON_CONTAINS(role_id, '\"$subadminRoleId\"')") // JSON_CONTAINS for MySQL JSON search
                ->latest()
                ->get();

            return view('subadmin.orders.index', compact('orders'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function show($id)
    {
        try {
            if (isset($id)) {
                $order = Order::with('cart', 'user')->find($id);
                $latitude = $order->latitude ?? '';
                $longitude = $order->longitude ?? '';
                $address = $this->googleMapsService->getAddressFromCoordinates($latitude, $longitude);

                $address_to_latitude = $order->address_to_latitude ?? '';
                $address_to_longitude = $order->address_to_longitude ?? '';
                $address_to = $this->googleMapsService->getAddressFromCoordinates($address_to_latitude, $address_to_longitude);

                $address_from_latitude = $order->address_from_latitude ?? '';
                $address_from_longitude = $order->address_from_longitude ?? '';
                $address_from = $this->googleMapsService->getAddressFromCoordinates($address_from_latitude, $address_from_longitude);

                $property_address_latitude = $order->property_address_latitude ?? '';
                $property_address_longitude = $order->property_address_longitude ?? '';
                $property_address = $this->googleMapsService->getAddressFromCoordinates($property_address_latitude, $property_address_longitude);
                return view('subadmin.orders.view', compact('order', 'address', 'address_to', 'address_from', 'property_address', 'latitude', 'longitude'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function status(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            if ($order) {
                $order->status = $request->status;
                $order->save();

                Alert::success('Success', 'Order Status Changed Successfully!');
                return redirect()->back();
            } else {
                Alert::error('Error', 'Order not found!');
                return redirect()->back();
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function export()
    {
        try {
            $subadmin = auth()->user();
            $subadminRoleId = $subadmin->roles->first()->id;
            $orders = Order::where('role_id', $subadminRoleId)
                ->latest()
                ->get();
            return Excel::download(new SubadminOrderExport($orders), 'orders.xlsx');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}