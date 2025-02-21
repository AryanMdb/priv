<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\GoogleMapsService;

class OrderController extends Controller
{
    protected $googleMapsService;

    public function __construct(GoogleMapsService $googleMapsService)
    {
        $this->googleMapsService = $googleMapsService;
    }
    public function index()
    {
        try {
            $roles = Role::get();
            $orders = Order::with('cart', 'user')->latest()->get();

            $carts = Cart::where('status', 1)->get();
            return view('admin.orders.index', compact('orders', 'roles', 'carts'));
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
                return view('admin.orders.view', compact('order', 'address', 'latitude', 'longitude'));
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

    public function assignRole(Request $request, $id)
    {
        try {
            $order = Order::find($id);
            $roleIds = $request->role_id ?? [];
            $order->role_id = json_encode($roleIds);
            $order->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getOrderData()
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }

    public function destroy($id)
    {
        try {
            $order = Order::with('cart', 'user')->findOrFail($id);
            $order->cart()->delete();
            $order->delete();
            Alert::success('Success', 'Order Deleted Successfully!');
            return redirect()->route('order.index');
        } catch (Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }

    // public function massDelete(Request $request)
    // {
    //     Order::whereIn('id', $request->order_ids)->delete();
    //     return response()->json(['message' => 'Orders deleted successfully!']);
    // }


}