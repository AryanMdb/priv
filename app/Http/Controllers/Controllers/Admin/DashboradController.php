<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DashboradController extends Controller
{
    public function dashboard()
    {
        $totalUser = 0;
        $totalSubadmin = 0;
        $totalEarnings = 0;
        $total_orders = 0;
        $totalUser = User::where(['role' => 'customer', 'is_verified' => 1])->count();
        if(isset($totalUser) && !empty($totalUser))
        {
            $totalUser = $totalUser;
        }
        $total_orders = Order::count();
        if(isset($total_orders) && !empty($total_orders))
        {
            $total_orders = $total_orders;
        }
        $totalSubadmin = User::where(['role' => 'subadmin'])->count();
        if(isset($totalSubadmin) && !empty($totalSubadmin))
        {
            $totalSubadmin = $totalSubadmin;
        }
        $totalEarnings = Cart::where(['status' => 1])->sum('grant_total');
        if(isset($totalEarnings) && !empty($totalEarnings))
        {
            $totalEarnings = $totalEarnings;
        }

        $categories = Category::active()->get();
        return view('admin.dashboard',compact('totalUser', 'total_orders', 'totalSubadmin', 'totalEarnings', 'categories'));
        // return view('admin.dashboard');
    }

    public function changePassword()
    {
        return view('admin.change-password');

    }

    public function changePasswordUpdate(Request $request)
    {

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|string|min:6',
        ]);

        if (! (Hash::check($request->old_password, Auth::user()->password))) {

            Alert::error('message', 'Your current password does not matches with the password you provided! Please try again.');

            return redirect()->back();
        }
        
        $new_password = trim($request->new_password);

        if (strcmp($request->old_password, $new_password) == 0) {

            Alert::error('message', 'New Password cannot be same as your current password! Please choose a different password.');

            return redirect()->back();
        }

        $user = Auth::user();
        $user->password = $new_password;
        $user->save();

        Alert::success('message', 'Password changed successfully.');

        return redirect()->back();
    }

    public function getOrdersByCategory($id)
    {
        $category = Category::find($id);
        $orderCount = $category->carts()->whereHas('order')->count();
        return response()->json([
            'category' => $category->title,
            'orderCount' => $orderCount
        ]);
    }
}
