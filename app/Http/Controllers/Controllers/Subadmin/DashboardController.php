<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_orders = 0;
        $subadmin = auth()->user();
        $subadminRoleId = $subadmin->roles->first()->id;
        $total_orders = Order::with('cart', 'user')->where('role_id', $subadminRoleId)->count();

        if(isset($total_orders) && !empty($total_orders))
        {
            $total_orders = $total_orders;
        }
        return view('subadmin.dashboard',compact('total_orders'));
    }

    public function changePassword()
    {
        return view('subadmin.change-password');

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
}
