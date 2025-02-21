<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\OtpVerificationEvent;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rule;
use App\Services\TextlocalService;
use App\Services\FCMService;

class AuthController extends BaseController
{
    protected $textlocalService;

    public function __construct(TextlocalService $textlocalService)
    {
        $this->textlocalService = $textlocalService;
    }

    public function signup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => [
                    'required',
                    'numeric',
                    Rule::unique('users')->where(function ($query) {
                        $query->whereNull('deleted_at')
                        ->where('is_verified', 1);
                    }),
                ],
                'gender' => 'required',
                'device_token' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError([],$validator->errors()->first(), 201);
            }

            $otp = strval(rand(1000, 9999));

            $response = $this->textlocalService->sendOtp($request->phone, $otp);

            if ($response['status'] == 'success') {
                $user = User::create([
                    'name' => $request->name ?? '',
                    'phone' => $request->phone ?? '',
                    'device_token' => $request->device_token ?? '',
                    'gender' => $request->gender ?? 'male',
                    'role' => 'customer',
                    'status' => 1
                ]);

                event(new OtpVerificationEvent($user, $otp));
                $userData = $user;
                $userData['otp'] = $otp;
                return $this->sendResponse($userData, 'Otp sent', 200);
            } else {
                return $this->sendError([],'Failed to send OTP', 500);
            }

        } catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }

    }

    public function verifyOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError([],$validator->errors()->first(), 201);
        }

        $user = User::where('phone', $request->phone)->orderBy('created_at', 'desc')->first();

        if (! $user) {
            return $this->sendError([],'User not found', 202);
        }

        if ($user->otp == $request->otp && $user->expires_at > now()->subMinutes(5)) {
            if($user->is_verified == 0){
                FCMService::send(
                    $user->device_token,
                    [
                        'user_id' => $user->id,
                        'type' => 'account_created',
                        'title' => 'Welcome to the Privykart',
                        'body' => 'Your account has been created successfully.',
                        'date' => now()->toDateString(),
                        'time' => now()->toTimeString(),
                    ]
                );
            }
            $user->update(['otp' => null, 'expires_at'=> null, 'is_verified' => 1]);

            $token = JWTAuth::fromUser($user);
            $userData = $user;
            $userData['token'] = $token;
            return $this->sendResponse($user, 'OTP verified successfully', 200);
        }

        return $this->sendError([],'Invalid OTP', 202);

    }

    public function resendOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError([],$validator->errors()->first(), 201);
            }

            $user = User::where('phone', $request->phone)->orderBy('created_at', 'desc')->first();

            if (! $user) {
                return $this->sendError([],'User not found', 202);
            }

            // Define the special phone number and OTP
            $specialPhoneNumber = '9024303836';
            $specialOtp = '1234';

             // Check if the request phone number is the special phone number
            if ($request->phone == $specialPhoneNumber) {
                // Update user's OTP and expiration time with the special OTP
                $user->update([
                    'otp' => $specialOtp,
                    'expires_at' => now(),
                ]);

                // Simulate sending the OTP (assuming your service allows this)
                $response = $this->textlocalService->sendOtp($user->phone, $specialOtp);
                if ($response['status'] == 'success') {
                    $userData = $user;
                    $userData['otp'] = $specialOtp;
                    return $this->sendResponse($userData, 'Otp sent', 200);
                } else {
                    return $this->sendError([], 'Failed to send OTP', 500);
                }
            }

            // Generate a new OTP
            $otp = strval(rand(1000, 9999));

            // Update user's OTP and expiration time
            $user->update([
                'otp' => $otp,
                'expires_at' => now(),
            ]);
            $response = $this->textlocalService->sendOtp($user->phone, $otp);
            if ($response['status'] == 'success') {
                $userData = $user;
                $userData['otp'] = $otp;
                return $this->sendResponse($userData, 'Otp sent', 200);
            } else {
                return $this->sendError([],'Failed to send OTP', 500);
            }

        } catch (JWTException $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|numeric',
                'device_token' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendError([],$validator->errors()->first(), 201);
            }

            $specialPhoneNumber = '9024303836';
            $specialOtp = '1234';

            // Check for special case
            if ($request->phone == $specialPhoneNumber) {
                $user = User::where('phone', $request->phone)->orderBy('created_at', 'desc')->first();
                if (!$user) {
                    return $this->sendError([], 'User not found please signup', 202);
                }
                if ($user->is_verified == 0) {
                    return $this->sendError([], 'User not registered', 202);
                }

                $user->device_token = $request->device_token;
                $user->save();

                event(new OtpVerificationEvent($user, $specialOtp));
                $userData = $user;
                $userData['otp'] = $specialOtp;
                return $this->sendResponse($userData, 'Otp sent', 200);
            }

            $otp = strval(rand(1000, 9999));

            $user = User::where('phone', $request->phone)->orderBy('created_at', 'desc')->first();
            if (! $user) {
                return $this->sendError([],'User not found please signup', 202);
            }
            if ($user->is_verified == 0) {
                return $this->sendError([],'User not registered', 202);
            }

            $user->device_token = $request->device_token;
            $user->save();

            $response = $this->textlocalService->sendOtp($user->phone, $otp);

            if ($response['status'] == 'success') {
                event(new OtpVerificationEvent($user, $otp));
                $userData = $user;
                $userData['otp'] = $otp;
                return $this->sendResponse($userData, 'Otp sent', 200);
            } else {
                return $this->sendError([],'Failed to send OTP', 500);
            }

        } catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }

    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->sendResponse([], 'Successfully logged out', 200);
        } catch (\Exception $e) {
            return $this->sendError([],'Failed to logout', 500);
        }
    }
}
