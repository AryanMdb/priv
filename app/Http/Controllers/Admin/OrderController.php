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
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderController extends Controller
{
    protected $googleMapsService;

    public function __construct(GoogleMapsService $googleMapsService)
    {
        $this->googleMapsService = $googleMapsService;
    }
    public function index(Request $request)
    {
        try {
            $allowed = [10, 25, 50, 100];
            $input = (int) $request->input('entries', 10);
    
            if (!in_array($input, $allowed)) {
                $closest = null;
                $minDiff = PHP_INT_MAX;
                foreach ($allowed as $value) {
                    $diff = abs($value - $input);
                    if ($diff < $minDiff) {
                        $minDiff = $diff;
                        $closest = $value;
                    } elseif ($diff == $minDiff && $value > $closest) {
                        $closest = $value;
                    }
                }
                $entries = $closest;
            } else {
                $entries = $input;
            }
    
            $roles = Role::all();
            $query = Order::with('cart', 'user')->latest();
    
            // Apply search filter
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('order_id', 'LIKE', "%{$search}%") // Search by order_id
                      ->orWhereHas('user', function ($q) use ($search) { // Search by user's name
                          $q->where('name', 'LIKE', "%{$search}%");
                      });
                });
            }
    
            $orders = $query->paginate($entries);
            $carts = Cart::where('status', 1)->get();
    
            return view('admin.orders.index', compact('orders', 'roles', 'carts'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    

    public function show($id)
    {
        try {
            if ($id) {
                $order = Order::with('cart', 'user')->find($id);
                $cart = $order->cart ?? null;
                $location = $cart ? Location::find($cart->location_id) : null;
                $latitude = $location->latitude ?? '';
                $longitude = $location->longitude ?? '';
                $address = $location ? $this->googleMapsService->getAddressFromCoordinates($latitude, $longitude) : '';

                return view('admin.orders.view', compact('order', 'address', 'latitude', 'longitude', 'location'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function status(Request $request, $id)
    {
        try {
            $order = Order::withTrashed()->find($id);
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
            $order = Order::withTrashed()->find($id);

            if (!$order) {
                return response()->json(['success' => false, 'error' => 'Order not found']);
            }

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
            DB::beginTransaction();

            $order = Order::with('cart', 'user')->findOrFail($id);

            $order->delete();
            DB::commit();

            Alert::success('Success', 'Order Trashed Successfully!');
            return redirect()->route('order.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error deleting order: " . $e->getMessage());
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);

        $order->restore();

        Alert::success('Success', 'Order Restored Successfully!');
        return redirect()->route('orders.trashed');
    }

    public function forceDelete($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->cart()->delete();
        $order->forceDelete();

        Alert::success('Success', 'Order Permanently Deleted!');
        return redirect()->route('orders.trashed');
    }

    public function trashedItems(Request $request)
    {
        try {
            $allowed = [10, 25, 50, 100];
            $input = (int) $request->input('entries', 10);

            if (!in_array($input, $allowed)) {
                $closest = null;
                $minDiff = PHP_INT_MAX;
                foreach ($allowed as $value) {
                    $diff = abs($value - $input);
                    if ($diff < $minDiff) {
                        $minDiff = $diff;
                        $closest = $value;
                    } elseif ($diff == $minDiff && $value > $closest) {
                        $closest = $value;
                    }
                }
                $entries = $closest;
            } else {
                $entries = $input;
            }

            // $roles = Role::all();
            // $orders = Order::with('cart', 'user')->onlyTrashed()->latest()->paginate($entries);

            // $carts = Cart::where('status', 1)->get();
            // return view('admin.orders.index', compact('orders', 'roles', 'carts'))->with('tab', 'trashed');

            // ////////////////////////////////////


            $roles = Role::all();
            $query = Order::with('cart', 'user')->onlyTrashed()->latest();
    
            if ($request->has('search') && !empty($request->input('search'))) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('order_id', 'LIKE', "%{$search}%") // Search by order_id
                      ->orWhereHas('user', function ($q) use ($search) { // Search by user's name
                          $q->where('name', 'LIKE', "%{$search}%");
                      });
                });
            }
    
            $orders = $query->paginate($entries);
            $carts = Cart::where('status', 1)->get();
    
            return view('admin.orders.index', compact('orders', 'roles', 'carts'));

            // /////////////////////////////////////////
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }



    // public function massDelete(Request $request)
    // {
    //     Order::whereIn('id', $request->order_ids)->delete();
    //     return response()->json(['message' => 'Orders deleted successfully!']);
    // }


}