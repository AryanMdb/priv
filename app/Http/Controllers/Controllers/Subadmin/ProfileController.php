<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $user = Auth::user();
        return view('subadmin.my-profile',compact('user'));
    }

    public function updateProfile(Request $request){
        try{
            $user = Auth::user();
            $user->name = $request->name ?? '';
            $user->save();
            Alert::success('Success', 'Profile updated successfully');
            return redirect()->route('dashboard-page');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
