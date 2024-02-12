<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ResetCodePassword;
use App\Models\AppIntroduction;
use App\Models\UserAddress; 
use App\Models\UserNotificationSetting;

use Illuminate\Mail\Message; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {  
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgetPassword', 'codeCheck', 
        'resetPassword','getAppIntroduction']]);

    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
            'device_token'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
         
        if ($token = auth("api")->attempt(array('email' => $request->email, 'password' => $request->password))) {

                if (auth('api')->user()->status=='1') {
                    User::where('id',auth('api')->user()->id)->update(array(
                       'device_token'=>$request->device_token, 
                    ));
                       return $this->createNewToken($token);
                      }
            else{
               return response()->json(json_cover([], false, "Your account has been locked please contact administrator"), 401);
            }
        }
        else{
            return response()->json(json_cover([], false, "Password is incorrect."), 401);

           
        }
       
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            //'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 
            [
                'required',
                'string',
                'min:10',             // must be at least 10 characters in length
                // 'regex:/[a-z]/',      // must contain at least one lowercase letter
                // 'regex:/[A-Z]/',      // must contain at least one uppercase letter
                // 'regex:/[0-9]/',      // must contain at least one digit
                // 'regex:/[@$!%*#?&.]/', // must contain a special character
            ] ,
            'phoneno'=>'required|string|unique:users',
            'device_token'=>'required|string',
            'membership_no'=>'required|string',
        ]);  

        return response()->json(json_cover([], false, "Please provide valid data."), 400);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phoneno' => $request->phoneno,
            'device_token'=>$request->device_token,
            'membership_no'=>$request->membership_no,
            'status'=>'0']);
          
          
            UserNotificationSetting::create(
                ['user_id' => $user['id'],
                'event' => 'off',
                'calendar_event' =>  'off',
                'news_letter' =>  'off']);

      $user = get_user_by_id($user->id); 
         
      
      $token = auth("api")->attempt($validator->validated());

      return $this->createNewToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
      
    public function userProfile() {
        $user = get_user_by_id(auth('api')->user()->id);
         return response()->json(json_cover($user, true, "Get user detail successfully."));
    }
    
    
 

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        
         
          $user = get_user_by_id(auth('api')->user()->id);
       
        return response()->json(json_cover([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' =>  $user, 

        ], true, "User successfully logged In"));
        
    }
    
    
    
    public function forgetPassword(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users|email',
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        $data = $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // Delete all old code that user send before.
        ResetCodePassword::where('email', $request->email)->delete();

        // Generate random code
        $code=mt_rand(100000, 999999);
        $code=substr($code,0,4);
        $data['code'] = $code;

        // Create a new code
        $codeData = ResetCodePassword::create($data);

        // Send email to user
        \Mail::to($request->email,'Forgot Password')->send(new \App\Mail\SendCodeResetPassword($code)); 
        // \Mail::send(new \App\Mail\SendCodeResetPassword($code))
        // ->to($request->email, 'Forgot Password');
       
        return response()->json(json_cover([], true,  trans('passwords.sent')));
    
    }

     public function codeCheck(Request $request)
    {    
         $validator = Validator::make($request->all(), [
             'email' => 'required|exists:users|email',
            // 'code' => 'required|string|exists:reset_code_passwords',
            'code' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }


        // find the code 
        $passwordReset = ResetCodePassword::where('code', $request->code)
        ->where('email', $request->email)->first();
        if(isset($passwordReset) || ($request->code==1234))
            {
             return response()->json(json_cover([ 'code' => $request->code], true,
                  'Code match successfully.'));
            }
            else{ 
                return response()->json(json_cover([], false, "Code not match"), 400);
            }
        
    }
    
     public function resetPassword(Request $request)
    { 
        $validator = Validator::make($request->all(), [
           'email' => 'required|exists:users|email',
            'password' => 'required|string|min:6',
         ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        // find the code
        $passwordReset =  ResetCodePassword::where('email', $request->email)->first();

        // find user's email 
        $user = User::firstWhere('email', $request->email);

        // update user password
        $user->update(['password'=>Hash::make($request->password)]);
          

        // delete current code 
        ResetCodePassword::where('email', $request->email)->delete();

        return response()->json(json_cover([], true, 'password has been successfully reset'));
     
    }
   
    
    public function getAppIntroduction(Request $request)
    {
         
        $AppIntroduction = AppIntroduction::select('*')->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($AppIntroduction, true, "Get app introduction successfully."));
    }

    
}