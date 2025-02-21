<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use App\Services\TextlocalService;
use Illuminate\Validation\Rule;
use App\Events\OtpVerificationEvent;

class DeleteUserAccountController extends Controller
{
    protected $textlocalService;

    public function __construct(TextlocalService $textlocalService)
    {
        $this->textlocalService = $textlocalService;
    }

    public function deleteAccountView(){
        return view('admin.users.delete-account');
    }

    public function deleteAccountSendOtp(Request $request){
        try {
            $phone = $request->phone;
            $otp = strval(rand(1000, 9999));

            $user = User::where(['phone' => $phone, 'is_verified' => 1])->first();
            if (!$user) {
                return response()->json(['error' => true, 'message' => 'User not found']);
            }

            $response = $this->textlocalService->sendOtp($phone, $otp);
            if ($response['status'] == 'success') {
                $user->otp = $otp;
                $user->save();
                return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
            } else {
                return response()->json(['error' => true, 'message' => 'Failed to send OTP.']);
            }

            $user->otp = $otp;
            $user->save();
            return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }


    public function verifyOtp(Request $request)
    {
        try {
            $phone = $request->phone;
            $otp = $request->otp;

            $user = User::where(['phone' => $phone, 'is_verified' => 1])->first();

            if (!$user) {
                return response()->json(['error' => true, 'message' => 'User not found']);
            }
            
            if ($user->otp != $otp) {
                return response()->json(['error' => true, 'message' => 'Invalid OTP']);
            }

            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}