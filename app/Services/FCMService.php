<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Notification;

class FCMService
{
    public static function send($token, $notification)
    {
        try {
            Notification::create([
                'user_id' => $notification['user_id'] ?? '',
                'type' => $notification['type'] ?? '',
                'title' => $notification['title'] ?? '',
                'body' => $notification['body'] ?? '',
            ]);

            $response = Http::acceptJson()->withToken(config('constants.firebase_token'))->post(
                'https://fcm.googleapis.com/fcm/send',
                [
                    'to' => $token,
                    'notification' => $notification,
                ]
            );
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}