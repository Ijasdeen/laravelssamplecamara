<?php

namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress; 
use App\Models\UserNotificationSetting;


use App\Models\Staticpage;
use App\Models\ContactEmail;

 
use Illuminate\Validation\Rule;
use Illuminate\Mail\Message; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
     public function __construct() {
       
        $this->middleware('auth:api',['except' => ['getStaticpageDetails','ContactUs']]);
    }
    
     public function updateProfile(Request $request)
    { 
           
        $validator = Validator::make($request->all(), [
          'name' => 'required|string|between:2,100',
           'occupation' => 'required|string',
           'age' => 'required|string',
           'company_name'=> 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        
        $user = User::find(auth("api")->user()->id);

        if ($request->name != null) {
            $user->name = $request->name;
        }

        if ($request->occupation != null) {
            $user->occupation = $request->occupation;
        }

       if ($request->age != null) {
            $user->age = $request->age;
        }
        if ($request->company_name != null) {
            $user->company_name = $request->company_name;
        }
        
        
        $user->save();
        $user = get_user_by_id(auth('api')->user()->id);
        return response()->json(json_cover($user, true, "User Profile Updated Successfully."));
    }
    
     public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);


        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        if (!Hash::check($request->old_password, auth("api")->user()->password)) {
            return response()->json(json_cover(["old_password" => "Your old password is not match with our records."], false, "Please provide valid data."), 400);
        }

        $user = User::find(auth("api")->user()->id);

        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json(json_cover([], true, "User password updated successfully."));
    }

    public function notificationSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event' => 'required|in:on,off',
            'calendar_event' => 'required|in:on,off',
            'news_letter' => 'required|in:on,off'
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        
        $user = UserNotificationSetting::updateOrCreate([
            'user_id' => auth('api')->user()->id],
            ['event' => $request->event,
             'calendar_event' => $request->calendar_event,
             'news_letter' => $request->news_letter]);
        
        return response()->json(json_cover([], true, "Notification setting updated successfully."));
    }

    public function getNotificationSetting(Request $request)
    {
        $user_NotificationSetting = UserNotificationSetting::select('event','calendar_event','news_letter')->where('user_id',auth('api')->user()->id)->first();
        if(empty($user_NotificationSetting))
        {
            $user_NotificationSetting=array('event'=>'off','calendar_event'=>'off','news_letter'=>'off');
        }

        return response()->json(json_cover($user_NotificationSetting, true, "Get user notification successfully."));
      
    }

    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_type' => 'required|in:home,office',
            'address' => 'required|string', 
            // 'additional_details' => 'required|string', 
            'latitude' => 'required|string', 
            'longitude' => 'required|string', 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        $user = UserAddress::Create([
            'user_id' => auth('api')->user()->id,
            'address_type' => $request->address_type,
             'address' => $request->address,
             'additional_details' => ($request->additional_details) ? $request->additional_details : '',
             'latitude' => $request->latitude, 
             'longitude' => $request->longitude]);
        
        return response()->json(json_cover([], true, "Add address successfully."));
   
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:user_address',
            'address_type' => 'required|in:home,office',
            'address' => 'required|string', 
            // 'additional_details' => 'required|string', 
            'latitude' => 'required|string', 
            'longitude' => 'required|string', 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
       
        $user_address = UserAddress::where('id',$request->id)->update([
            'user_id' => auth('api')->user()->id,
            'address_type' => $request->address_type,
             'address' => $request->address,
             'additional_details' => ($request->additional_details) ? $request->additional_details : '',
             'latitude' => $request->latitude, 
             'longitude' => $request->longitude]);
        
        return response()->json(json_cover([], true, "Update address successfully."));
   
    }

    public function deleteAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:user_address', 
        ]);


        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        $id=$request->id;
 
        $user_address_check = UserAddress::where('id', $id)->where('user_id', auth('api')->user()->id)->get();

        if (count($user_address_check) == 0)
        {
            return response()->json(json_cover([], false, "Sorry you can not delete other user's address") , 400);
        }
        else
        {
            UserAddress::find($id)->delete();
        
                return response()->json(['message' => 'User address deleted successfully'], 200);
            
        }
        
        
        return response()->json(json_cover([], true, "Delete address successfully."));
    }


    public function getAddress(Request $request)
    {
        $user_address = UserAddress::select('id','address_type','address','additional_details','latitude','longitude')->where('user_id',auth('api')->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover(['user_address'=>$user_address], true, "Update address successfully."));
        
    }

    public function ContactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string' ,
            'message' => 'required|string'  
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

         // Send email to admin
        $info['subject']=$request->subject;
        $info['message']=$request->message;

        $ContactEmail = ContactEmail::select('*')->get();
        if(isset($ContactEmail))
        {
            foreach($ContactEmail as $value)
            {
                \Mail::to($value['email'],'Contact Us')->send(new \App\Mail\ContactUsMail($info)); 
            }
        }
       
 
         return response()->json(json_cover([], true,'Contact us details send successfully.'));
    }

    public function getStaticpageDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $Staticpagedetails = Staticpage::select('*')->where('title','like', '%'.$request->title.'%')->get();
        return response()->json(json_cover($Staticpagedetails, true, "Get page details successfully."));
    }

    
    
}
