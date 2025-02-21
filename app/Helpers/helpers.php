<?php
use App\Models\User;
use App\Models\Notification;

if (!function_exists('addNotificationData')) {
    function addNotificationData($data)
    {
        $userName = isset($data['userName']) ? $data['userName'] : "";
        $bookName = isset($data['bookName']) ? $data['bookName'] : "";
        $groupName = isset($data['groupName']) ? $data['groupName'] : "";
        $trackId = isset($data['trackId']) ? $data['trackId'] : "";
        $deliveryDate = isset($data['deliveryDate']) ? $data['deliveryDate'] : "";


        $receiverId = $data['receiver_id'] ?? '';
        // $senderId = auth()->user()->id;        
        $senderId = !empty(auth()->user()) ? auth()->user()->id : $receiverId;
        
        // $crudNotification = CrudNotification::where('type', $data['type'])->first();

        // if($crudNotification){

        //     $title = $crudNotification->title;
        //     $description = $crudNotification->description; 
            $task = $data['type'];

            $description = str_replace("##USERNAME##",$userName,$description);
            $description = str_replace("##BOOKNAME##",$bookName,$description);
            $description = str_replace("##GROUPNAME##",$groupName,$description);
            
        // }else{
        //     $title = 'N/A';
        //     $description = 'N/A';
        //     $task = 'N/A';    
        // }
        
        $user = User::find($receiverId);
        
        if (!empty($user)) {
            $notification = [
                'usrtoken' => $user->device_token,
                'title' => $title,
                'description' => $description,
                'type' => $data['type'] ?? '',
                'user_status' => $data['user_status'] ?? ''
            ];

            if ($user->notification == '1') {
                $response = sendNotification($notification);
            }

            $notificationArr = [
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'task' => $task,
                'title' => $title,
                'desc' => $description,
                'status'  => '1',
                'seen' => '0',            
            ];

            if (isset($response->success)) {
                $notificationArr['response_status'] = '' . $response->success . '';
            }

            if (isset($response->results[0]->message_id)) {
                $notificationArr['response_id'] = $response->results[0]->message_id;
            }

            $res = Notification::create($notificationArr);


            return $res;
        } else {
            return false;
        }
    }
}


if (!function_exists('sendNotification')) {
    function sendNotification()
    {
        $data = [
        "registration_ids" => json_decode($notification['usrtoken']),
            'to'=>$notification['usrtoken'],

            "notification" => [
                "title" => $notification['title'],
                "body" => $notification['description'],                  
            ],
            "data" => [
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "priority"=> "high",
                "id"=> "1",
                "status"=> "done",
                "type" => $notification['type'] ?? '',
                "bookId" => $notification['bookId'] ?? '',
                "groupId" => $notification['groupId'] ?? '',   
                "user_status" => $notification['user_status'] ?? '',      
            ]
        ];
    
        $dataString = json_encode($data);

        $uniqueId=Carbon::now()->timestamp;
        $to = $notification['usrtoken'] ?? '';
        $title = $notification['title'] ?? '';
        $body = $notification['description'] ?? '';
        $type = $notification['type'] ?? '';

        $headers = [
            'Authorization: key=' . env('FIREBASE_KEY'),
            'Content-Type: application/json',
        ];

        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = json_decode(curl_exec($ch));
        return $response;
    }
}