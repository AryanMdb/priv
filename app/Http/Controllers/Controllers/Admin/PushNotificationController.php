<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PushNotification;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Http\Requests\BrandMakeRequest;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect;
use App\Services\TextlocalService;
use App\Services\FCMService;

class PushNotificationController extends Controller
{
    protected $textlocalService;

    public function __construct(TextlocalService $textlocalService)
    {
        $this->textlocalService = $textlocalService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $notificationData = '';
            $notification = PushNotification::orderBy('id', 'ASC')->get();
            if(isset($notification) && !empty($notification))
            {   
                $notificationData = $notification;
            } else {
                Alert::error('Failed', 'Registration failed');
                return redirect()->back();
            }
            return view('admin.push_notification.index', compact('notificationData'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('admin.push_notification.create');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function show($id)
    {
        try {
            if(isset($id))
            {
                $notificationData = '';
                $notification = PushNotification::where('id', $id)->first();
                if(isset($notification))
                {
                    $notificationData = $notification;
                }
            }
            return view('admin.push_notification.view', compact('notificationData'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'message'        => 'required|string|min:10',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }else{

                $notificationData = [
                    'title'  => $request['title'] ?? '',
                    'message'  => $request['message'] ?? ''
                ];
                $notification = PushNotification::create($notificationData);
                if($notification){
                    Alert::success('Success', 'Notification created successfully.');
                    return redirect()->route('push_notification.index');
                }else{
                    Alert::error('Failed', 'Entry failed');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            if(isset($id) && !empty($id))
            {
                $notificationData = '';
                $notification = PushNotification::where('id',$id)->first();
                if(isset($notification) && !empty($notification))
                {
                    $notificationData = $notification;
                }
                return view('admin.push_notification.edit',compact('notificationData'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'message'        => 'required|string|min: 10',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }

            if(isset($id) && !empty($id))
            {
                $notification = PushNotification::find($id);
                if(isset($notification) && !empty($notification))
                {
                    $notification->title = $request['title'] ?? '';
                    $notification->message = $request['message'] ?? '';
                    $notification->save();
                    Alert::success('Success', 'Notification Updated Successfully.');
                    return redirect()->route('push_notification.index');
                }else{
                    Alert::error('Failed', 'Entry failed');
                    return redirect()->back();
                }
            } else {
                Alert::error('Failed', 'Record Not Found.');
                return redirect()->back();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id) && !empty($id))
        {
            $notificationData = PushNotification::where('id', $id); $notificationData->delete();
            if($notificationData){
                Alert::success('Success', 'Notification Deleted Successfully !');
                return redirect()->back();
            }
        } else {
            Alert::error('Failed', 'Item deletion failed');
            return redirect()->back();
        }
    }




    public function sendPushNotification($id)
    {
        $notification = PushNotification::find($id);
        $users = User::select('id', 'device_token')->get();
        foreach ($users as $user) {
            FCMService::send(
                $user->device_token,
                [
                    'user_id' => $user->id,
                    'type' => 'push_notification',
                    'title' => $notification->title,
                    'body' => $notification->message,
                    'date' => now()->toDateString(),
                    'time' => now()->toTimeString(),
                ]
            );
        }
        Alert::success('Success', 'Push notification sent successfully to all users.');
        return redirect()->back();
    }
}
