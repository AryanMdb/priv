<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Faq;
use App\Models\CMSPage;
use App\Models\ContactUs;
use App\Models\Slider;
use App\Http\Resources\SubcategoryResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\StoreLocationResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\File;
use App\Services\FCMService;
use App\Models\Notification;
use App\Models\StoreLocation;
use App\Services\GoogleMapsService;

class UserController extends BaseController
{
    protected $googleMapsService;

    public function __construct(GoogleMapsService $googleMapsService)
    {
        $this->googleMapsService = $googleMapsService;
    }
    public function completeProfile(Request $request){
        try{
            $userId = auth()->id();

            if (!$userId) {
                return $this->sendError([], 'Token expired or user not authenticated', 401);
            }
            $user = User::find(auth()->user()->id);
            $automatic_location = $request->automatic_location == 'true' ? 1 : 0;
            $user->update([
                'lang' => $request->lang ?? '',
                'location' => $request->location ?? '',
                'latitude' => $request->latitude ?? '',
                'longitude' => $request->longitude ?? '',
                'automatic_location' => $automatic_location,
            ]);
            FCMService::send(
                $user->device_token,
                [
                    'user_id' => $user->id,
                    'type' => 'profile_completed',
                    'title' => 'Profile Completed!',
                    'body' => 'Your profile is completed.',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                ]
            );
    
            return $this->sendResponse(new UserResource($user), 'Profile details updated successfully', 200);
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }

    }

    public function insertOrUpdateProfileImage(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'image' => 'image|mimes:jpeg,png,jpg|required',
            ]);
            if ($validator->fails()) 
            {
                return $this->sendError([],$validator->errors()->first(), 201);

            } else {

                $user = User::find(auth()->user()->id);
                $profilePicture = '';
                if ($request->hasFile('image')) {
                    // Delete the existing image
                    if (isset($user?->image)) {
                        $existingImagePath = public_path('storage/profile_image/'.$user?->image);
                        if (File::exists($existingImagePath)) {
                            File::delete($existingImagePath);
                        }
                    }
                    $profilePicture = time().'.'.$request->image->extension();
                    $image = $request->image->move(public_path('storage/profile_image'), $profilePicture);

                    $user->image = $profilePicture;
                    $user->save();
                }

                return $this->sendResponse(new UserResource($user), 'Profile image updated successfully', 200);
            }

        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function updateUser(Request $request){
        try{
            $user = User::find(auth()->user()->id);
            $user->update([
                'name' => $request->name ?? '',
                'gender' => $request->gender ?? 'male',
            ]);
            FCMService::send(
                $user->device_token,
                [
                    'user_id' => $user->id,
                    'type' => 'profile_updated',
                    'title' => 'Profile Updated!',
                    'body' => 'Your profile is updated successfully.',
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                ]
            );
            return $this->sendResponse(new UserResource($user), 'User details updated successfully', 200);
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function deleteUser(){
        try{
            // Define the phone number of the protected user
            $protectedUserPhoneNumber = '9024303836';

            $user = User::find(auth()->user()->id);

            // Check if the authenticated user has the protected phone number
            if ($user->phone == $protectedUserPhoneNumber) {
                return $this->sendError([], 'This account is fixed and cannot be deleted!', 403);
            }

            $user->delete();
            return $this->sendResponse([], 'Account deleted successfully', 200);
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function getMyProfileData(){
        try{
            $user = User::find(auth()->user()->id);
            return $this->sendResponse(new UserResource($user), 'My profile data', 200);
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function getFaqs(){
        try{
            $faqs = Faq::where('status', 1)->get();
            return $this->sendResponse($faqs,'Faqs', 200);
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function getCMSPages(){
        try{
            $cms_pages = CMSPage::where('status', 1)->get();
            return $this->sendResponse($cms_pages,'CMS Pages', 200);
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function getSliders(){
        try{
            $slider = Slider::where('status', 1)->get();
            return $this->sendResponse($slider,'Slider', 200);
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function contactUs(Request $request){
      
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'phone_no' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {

                return $this->sendError([],$validator->errors()->first(), 201);
            }
                $contact_us = ContactUs::create([
                    'name' => $request->name ?? '',
                    'email' => $request->email ?? '',
                    'phone_no' => $request->phone_no ?? '',
                    'description' => $request->description ?? '',
                ]);

                Mail::to(config('constants.admin_email'))->send(new ContactUsMail($contact_us));
                return $this->sendResponse($contact_us,'Contact us form submitted successfully', 200);
            
        }catch (\Exception $e) {
            return $this->sendError([],$e->getMessage(), 500);
        }
    }

    public function getNotifications(){
        try {
            $notifications = Notification::where('user_id', auth()->user()->id)->get();
            return $this->sendResponse(NotificationResource::collection($notifications), 'User notifications', 200);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function notificationsCount(){
        try {
            $notifications = Notification::where(['user_id'=> auth()->user()->id, 'is_read' => 0]);
            $count = $notifications->count();
            $notifications_datas = $notifications->get();
            foreach($notifications_datas as $notifications_data){
                $notifications_data->is_read = 1;
                $notifications_data->save();
            }
            return $this->sendResponse($count, 'User notifications count', 200);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function getStoreLocation(){
        try {
            $store_location = StoreLocation::get();
            return $this->sendResponse(StoreLocationResource::collection($store_location), 'Privykart store location', 200);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}