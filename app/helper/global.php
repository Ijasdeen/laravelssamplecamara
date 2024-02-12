<?php
use App\Models\User;
use App\Models\EventAttend;
function json_cover($data,$status,$message)
{
    if($status == false)
    {
        return [
            "message" => $message,
            "errors" => $data
        ];
    }
    else
    {
        return [
            "success" => $status,
            "data" => $data,
            "message" => $message,
        ];
    }
}
 
// Get user by id
function get_user_by_id($user_id)
{
    $user = User::select('id', 'name', 'email',  'phoneno',  'occupation','age','company_name','membership','membership_no','validity')->where('id', $user_id)->first();
    
      if (isset($user))
      {
         return null_to_empty_string_convert($user);
         
      }
          else{
                return [];
              }
   

}

function null_to_empty_string_convert($data)
{
    $data = json_decode($data);
    $response_data = [];
    foreach ($data as $key => $value) {
        $response_data[$key] = $value;
        if (is_null($value)) {
            $response_data[$key] = "";
        }
    }
    return $response_data;
}

 function eventdetails($data)
{
    // $start_date = date("dS-F-Y", strtotime($data['start_datetime']));
    // $end_date = date("dS-F-Y",  strtotime($data['end_datetime']));

    $start_date = date("d/m/Y", strtotime($data['start_datetime']));
    $end_date = date("d/m/Y",  strtotime($data['end_datetime']));

    if($start_date==$end_date)
    {
        $data['event_date']= $start_date;
    }else
    {
        $data['event_date']= $start_date.' to '.$end_date;
    }

    $data['event_time']=  date('h:i a', strtotime($data['start_datetime'])).' to '. date('h:i a', strtotime($data['end_datetime']));

    $attend_status=  EventAttend::select('*')->where('user_id',auth('api')->user()->id)->where('event_id',$data['id'])->first();
      if(isset($attend_status))
        {
            $data['attend_status']= ($attend_status->status == '1') ? 'attend' : 'not attend';
        }
        else{
            $data['attend_status']= '';
        } 
 
      unset($data['cat_id']);
      unset($data['start_datetime']);
      unset($data['end_datetime']);
      return $data;
}

function sendNotification($title,$eventdate,$type){
   if($type=='event')
   {
    $user = User::select('users.id', 'users.device_token')
    ->leftJoin('user_notification_setting', 'user_notification_setting.user_id', '=', 'users.id')
    ->where("user_notification_setting.event",'on')
     ->get(); 
   }
   else{
    $user = User::select('users.id', 'users.device_token')
            ->leftJoin('user_notification_setting', 'user_notification_setting.user_id', '=', 'users.id')
            ->where("user_notification_setting.news_letter",'on')
            ->get(); 
    }
   

                if(isset($user))
                {
                 
                    foreach($user as $value)
                    {
                        $firebaseToken=[];
                        if(!empty($value['device_token']))
                        {
                            
                            array_push($firebaseToken, $value['device_token']);
                            $SERVER_API_KEY = env('FCM_SERVER_KEY');
                        
                            $data = [
                                "registration_ids" => $firebaseToken,
                                "notification" => [
                                    "title" => $title,
                                    "body" => $eventdate,  
                                ]
                            ];
                            
                            $dataString = json_encode($data);
                        
                            $headers = [
                                'Authorization: key=' . $SERVER_API_KEY,
                                'Content-Type: application/json',
                            ];
                        
                            $ch = curl_init();
                            
                            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                                    
                            $response = curl_exec($ch);
                            // print_r($response);
                        }
                    }
        
                }
}