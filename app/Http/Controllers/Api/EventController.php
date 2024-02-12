<?php

namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Banner; 
use App\Models\Services;  
use App\Models\Benefits;  
use App\Models\Event; 
use App\Models\EventAttend;
use App\Models\category;
use App\Models\Newsletter;
use App\Models\Faq;
use App\Models\ChambersOfCommerce;
use App\Models\Career;
use App\Models\OfficialDocument;
use App\Models\BusinessRegistration;
use App\Models\MemberDirectory;
use App\Models\BusinessRegistrationUpload;
use App\Models\OfficialDocumentUpload;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Mail\Message; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use DB;

class EventController extends Controller
{
     public function __construct() {
        $this->middleware('auth:api');
    } 
  
    public function getBanner(Request $request)
    {   
        $url=url('/'); 
        $getbanner = Banner::select('*', DB::raw("CONCAT('".$url."/',banner_image) as banner_image"))->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($getbanner, true, "Get banner successfully."));
    }

    public function getBannerDetails(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'banner_type' => 'required|string|exists:banner' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        $url=url('/'); 

        $getbanner = Banner::select('*', DB::raw("CONCAT('".$url."/',banner_image) as banner_image"))
        ->where('banner_type',$request->banner_type)->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($getbanner, true, "Get banner successfully."));
    }


   

    public function getServices(Request $request)
    {
        $url=url('/'); 
        $getservices = Services::select('id','title','description', DB::raw("CONCAT('".$url."/',image) as image"))->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($getservices, true, "Get services successfully."));
    }

    public function getServiceDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:services' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $url=url('/'); 
        $getservices = Services::select('id','title','description', DB::raw("CONCAT('".$url."/',image) as image"))
                                 ->where('id',$request->id)->first();
        return response()->json(json_cover($getservices, true, "Get service details successfully."));
     
    }
    
    
    public function getBenefits(Request $request)
    {
        $url=url('/'); 
        $getBenefits = Benefits::select('benefits.id',  'benefits.title',
         DB::raw("CONCAT('".$url."/',benefits.image) as image"))
         ->leftJoin('category', 'category.id', '=', 'benefits.cat_id')
         ->where('benefits.end_date','>=', date('Y-m-d'))
         ->orderBy('benefits.created_at', 'desc')
         ->get(); 

        return response()->json(json_cover($getBenefits, true, "Get benefits successfully."));
    }

    public function getBenefitDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:benefits' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }      

        $url=url('/'); 

        $getBenefits = Benefits::select('benefits.id', 'category.category_name','benefits.title','benefits.start_date','benefits.end_date','benefits.description',
         DB::raw("CONCAT('".$url."/',benefits.image) as image"))
         ->leftJoin('category', 'category.id', '=', 'benefits.cat_id')
         ->where('benefits.end_date','>=', date('Y-m-d'))
         ->where('benefits.id', '=',$request->id) 
         ->first();
        
         $start_date = date("d", strtotime( $getBenefits->start_date));
         $end_date = date("d-F-Y",  strtotime( $getBenefits->end_date));
       
         if(date("m", strtotime( $getBenefits->start_date)) == date("m", strtotime( $getBenefits->end_date)))
         {
             $getBenefits->validity= $start_date.' to '.$end_date;
         }else
         {
            $getBenefits->validity= date("d-F-Y",  strtotime($getBenefits->start_date)).' to '.$end_date;
         }
         
         unset($getBenefits->start_date);
         unset($getBenefits->end_date);

        return response()->json(json_cover($getBenefits, true, "Get benefit details successfully."));
    }


    public function getNewsletter(Request $request)
    {
        $url=url('/'); 
        $getNewsletter = Newsletter::select('newsletter.id', 'category.category_name as category' ,
                            'newsletter.title','newsletter.description','newsletter.created_at',
                        DB::raw("CONCAT('".$url."/',newsletter.image) as image"),DB::raw("CONCAT('".$url."/',newsletter.n_file) as file"))
                        ->leftJoin('category', 'category.id', '=', 'newsletter.cat_id') 
                        ->orderBy('newsletter.created_at', 'desc')
                        ->get(); 

          $response=array();
          if(isset($getNewsletter)) 
          { 
            foreach ($getNewsletter as $value) {

                $value['news_date']= date("dS F Y",  strtotime($value['created_at']));
                unset($value['created_at']);
                $response[]=$value;
                 
            } 
          }      

        return response()->json(json_cover($response, true, "Get newsletter successfully."));
    }

    public function getNewsletterDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:newsletter' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }      

        $url=url('/'); 
        $getNewsletter = Newsletter::select('newsletter.id',  'newsletter.title',  'category.category_name as category' ,
                'newsletter.description','newsletter.created_at',
                 DB::raw("CONCAT('".$url."/',newsletter.image) as image"),
                 DB::raw("CONCAT('".$url."/',newsletter.n_file) as file"))
                ->leftJoin('category', 'category.id', '=', 'newsletter.cat_id') 
                ->where('newsletter.id', $request->id)
                ->orderBy('newsletter.created_at', 'desc')
                ->first(); 
 
        $getNewsletter->news_date= date("dS F Y",  strtotime($getNewsletter->created_at));
        unset($getNewsletter->created_at);
        

        return response()->json(json_cover($getNewsletter, true, "Get newsletter details successfully."));
    }
    
    public function getEvents(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'page_no' => 'required|numeric|min:1',
            'per_page' => 'required|numeric|min:1' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $url=url('/'); 
        $per_page = $request->per_page;
        $offset = $per_page * ($request->page_no - 1);

        $getEvents = Event::select('event.*', 'category.category_name',
                     DB::raw("CONCAT('".$url."/',event.image) as image"))
                            ->leftJoin('category', 'category.id', '=', 'event.cat_id')
                            ->where('event.end_datetime','>=', date('Y-m-d H:i:s'))  
                            ->orderBy('event.created_at', 'desc')
                            ->offset($offset)->limit($per_page)
                            ->get();

        $response=array();
        if(isset($getEvents)){
            foreach ($getEvents as  $value) {
                $response[]=eventdetails($value); 

              }   
        }
                        
        return response()->json(json_cover($response, true, "Get event successfully."));
    }


    public function getEventDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:event' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }      

        $url=url('/'); 

        $getEvents = Event::select('event.*', 'category.category_name',
                     DB::raw("CONCAT('".$url."/',event.image) as image"))
                            ->leftJoin('category', 'category.id', '=', 'event.cat_id')
                            // ->where('event.end_datetime','>=', date('Y-m-d H:i:s')) 
                            ->where('event.id', '=',$request->id)  
                            ->orderBy('event.created_at', 'desc')
                             ->first();  

        $start_date = date("dS-F-Y",  strtotime($getEvents->start_datetime));
        $end_date = date("dS-F-Y", strtotime($getEvents->end_datetime));
        
        if($start_date==$end_date)
        {
            $getEvents->event_date= $start_date;
        }else
        {
            $getEvents-> event_date= $start_date.' to '.$end_date;
        }

        $getEvents->event_time=  date('h:i a', strtotime($getEvents->start_datetime)).' to '. date('h:i a', strtotime($getEvents->end_datetime));


        $attend_status=  EventAttend::select('*')->where('user_id',auth('api')->user()->id)->where('event_id',$getEvents->id)->first();
        if(isset($attend_status))
        {
            $getEvents->attend_status= ($attend_status->status == '1') ? 'attend' : 'not attend';
        }
        else{
            $getEvents->attend_status=  '';
        }
 
        unset($getEvents->start_datetime);
        unset($getEvents->end_datetime);
        unset($getEvents->cat_id);
        return response()->json(json_cover($getEvents, true, "Get event details successfully."));
    }

    public function EventAttendNotattend(Request $request)
    {
        $user_id=auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|integer|min:1|exists:event,id' ,
            'attend_status'=> ['required', RULE::in(['1', '2']) ] ,
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }       

        $coach_class_bookmark = EventAttend::updateOrCreate(
                        ['event_id' => $request->event_id,
                        'user_id' => $user_id],
                        ['event_id' =>  $request->event_id,
                        'user_id' => $user_id, 'status' => $request->attend_status]);

               $message = ($request->attend_status == '1') ? 'Event attend successfully' : 'Event not attend successfully' ;
               return response()
                   ->json(['message' => $message, 'attend_status' => $request->attend_status], 200);
    }

    public function getAttendEvents(Request $request)
    {
        $user_id=auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'page_no' => 'required|numeric|min:1',
            'per_page' => 'required|numeric|min:1' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $url=url('/'); 
        $per_page = $request->per_page;
        $offset = $per_page * ($request->page_no - 1);
        $response=array();

        $geteventId=EventAttend::select(DB::raw("GROUP_CONCAT(event_id) as eventids"))  
                    ->where('user_id', $user_id) 
                    ->where('status', '1')
                    ->first();

        if($geteventId->eventids) 
        {
            $eventIds= explode(',', $geteventId->eventids);

            $getEvents = Event::select('event.*', 'category.category_name',
            DB::raw("CONCAT('".$url."/',event.image) as image"))
                   ->leftJoin('category', 'category.id', '=', 'event.cat_id')
                   ->whereIn('event.id', $eventIds)  
                   ->orderBy('event.created_at', 'desc')
                   ->offset($offset)->limit($per_page)
                   ->get();


            if(isset($getEvents)){
            foreach ($getEvents as  $value) {
                $start_date = date("dS-F-Y", strtotime($value['start_datetime']));
                $end_date = date("dS-F-Y",  strtotime($value['end_datetime']));
                if($start_date==$end_date)
                {
                    $value['event_date']= $start_date;
                }else
                {
                    $value['event_date']= $start_date.' to '.$end_date;
                }

                $value['event_time']=  date('h:i a', strtotime($value['start_datetime'])).' to '. date('h:i a', strtotime($value['end_datetime']));
 
                    $response[]=$value;
                    unset($value['cat_id']);
                    unset($value['start_datetime']);
                    unset($value['end_datetime']);

                }   
            }
        
        }   

              
        return response()->json(json_cover($response, true, "Get attend event successfully."));
    }

    public function getNotAttendEvents(Request $request)
    {
        $user_id=auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'page_no' => 'required|numeric|min:1',
            'per_page' => 'required|numeric|min:1' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $url=url('/'); 
        $per_page = $request->per_page;
        $offset = $per_page * ($request->page_no - 1);
        $response=array();

        $geteventId=EventAttend::select(DB::raw("GROUP_CONCAT(event_id) as eventids"))  
                    ->where('user_id', $user_id) 
                    ->where('status', '1')
                    ->first();

        if($geteventId->eventids) 
        {
            $eventIds= explode(',', $geteventId->eventids);

            $getEvents = Event::select('event.*', 'category.category_name',
            DB::raw("CONCAT('".$url."/',event.image) as image"))
                   ->leftJoin('category', 'category.id', '=', 'event.cat_id')
                   ->whereNotIn('event.id', $eventIds)  
                   ->orderBy('event.created_at', 'desc')
                   ->offset($offset)->limit($per_page)
                   ->get();

        }  else{
            $getEvents = Event::select('event.*', 'category.category_name',
            DB::raw("CONCAT('".$url."/',event.image) as image"))
                   ->leftJoin('category', 'category.id', '=', 'event.cat_id')
                    ->orderBy('event.created_at', 'desc')
                   ->offset($offset)->limit($per_page)
                   ->get();
        }

            if(isset($getEvents)){
            foreach ($getEvents as  $value) {
                $start_date = date("dS-F-Y", strtotime($value['start_datetime']));
                $end_date = date("dS-F-Y",  strtotime($value['end_datetime']));
                if($start_date==$end_date)
                {
                    $value['event_date']= $start_date;
                }else
                {
                    $value['event_date']= $start_date.' to '.$end_date;
                }

                $value['event_time']=  date('h:i a', strtotime($value['start_datetime'])).' to '. date('h:i a', strtotime($value['end_datetime']));
 
                    $response[]=$value;
                    unset($value['cat_id']);
                    unset($value['start_datetime']);
                    unset($value['end_datetime']);

                }   
            }
        
      

              
        return response()->json(json_cover($response, true, "Get attend event successfully."));
    }

    

    public function getCalendarEvents(Request $request)
    {
        $user_id=auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'month_year' =>  'required|date_format:m-Y' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }       

              //  $getCalendardate= Event::select('*')
            //     ->whereRaw("DATE_FORMAT(start_datetime, '%m-%Y') = '".$request->month_year."'")
            //     ->orderBy('start_datetime', 'asc')
            //     ->get(); 
            $month_year= (explode("-",$request->month_year));
            $total_days = cal_days_in_month(CAL_GREGORIAN,  $month_year[0],  $month_year[1]);
            
            $response=array();
            for ($i=01; $i <=$total_days; $i++) { 
              
                $date=$month_year[1].'-'.$month_year[0].'-'.sprintf("%02d", $i);
                

                $sqlQuery="select COUNT(id) as totalId from event where
                 '".$date."' between date(start_datetime) and date(end_datetime)";
                    
                $geteventcount = DB::select(DB::raw($sqlQuery))[0];


                $response[]=array(
                    'date'=>$date,
                    'total'=>$geteventcount->totalId
                );

            }

            return response()->json(json_cover($response, true, "Get calendar events successfully."));

    }
   
    public function getCalendarEventDetails(Request $request)
    {
        $user_id=auth('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'event_date' =>  'required|date_format:Y-m-d' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }   
 
        $url=url('/');  

        $sqlQuery=" select event.*, category.category_name,
        CONCAT('".$url."/',event.image) as image from event
         left join category on category.id = event.cat_id 
         where '".$request->event_date."' between date(start_datetime) and date(end_datetime)
          order by event.created_at desc";
          $getEvents =  DB::select(DB::raw($sqlQuery));
                    

          $response=array();
          if(isset($getEvents)){
              foreach ($getEvents as  $value) {
                
                    $value=(array)$value;

                    $response[]=eventdetails($value); 
  
                }   
          }

          return response()->json(json_cover($response, true, "Get calendar event successfully."));
     
    }

    public function sendNotification(Request $request)
    {
        $user_id=auth('api')->user()->id;
        $firebaseToken=[];
        
        array_push($firebaseToken, "dvdMFAwzT_uXc3V28BI0Tb:APA91bET8S9v-6q3Ewv_Po7A-oP5i88Xcrx8vR16u9d8yyRy8HD_sa4IAGt-59S_EgB8fmRUMs19DHmnE7uEioBlyQpjUhVTWhDSPLiz4aM7jEMqi_p5mdQSq-yWqXjgGOiRT53Whu58");
        $SERVER_API_KEY = env('FCM_SERVER_KEY');
    
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'First Test 123 ',
                "body" => 'First Test Message 123',  
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
        print_r($response);
        die();
    }
    

    public function getFaq(Request $request)
    {
        $url=url('/'); 
        $getFaq = Faq::select('id','question','answer')->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($getFaq, true, "Get Faq successfully."));
    }

    public function getFaqDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:faq' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        } 
        $getfaq = Faq::select('id','question','answer')
                                 ->where('id',$request->id)->first();
        return response()->json(json_cover($getfaq, true, "Get faq details successfully."));
     
    }

    public function getChambersOfCommerce(Request $request)
    {
        $url=url('/'); 
        $getChambersOfCommerce = ChambersOfCommerce::select('id','title','description', DB::raw("CONCAT('".$url."/',image) as image"))->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($getChambersOfCommerce, true, "Get chambers of commerce successfully."));
    }

    public function getChambersOfCommerceDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:chambers_of_commerce' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $url=url('/'); 
        $getChambersOfCommerceDetails = ChambersOfCommerce::select('id','title','description', DB::raw("CONCAT('".$url."/',image) as image"))
                                 ->where('id',$request->id)->first();
        return response()->json(json_cover($getChambersOfCommerceDetails, true, "Get chambers of commerce  details successfully."));
     
    }

    public function getOfficialDocument(Request $request)
    {
        $url=url('/'); 
        $getOfficialDocument = OfficialDocument::select('id','title','description', DB::raw("CONCAT('".$url."/',document) as document"), DB::raw("CONCAT('".$url."/',image) as image"))->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($getOfficialDocument, true, "Get official document successfully."));
    }

    public function getOfficialDocumentDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:official_document' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $url=url('/'); 
        $getOfficialDocumentDetails = OfficialDocument::select('id','title','description',
         DB::raw("CONCAT('".$url."/',document) as document"),DB::raw("CONCAT('".$url."/',image) as image"))
                                 ->where('id',$request->id)->first();
        return response()->json(json_cover($getOfficialDocumentDetails, true, "Get official document details successfully."));
     
    }

    public function OfficialDocumentUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:official_document' ,
            'document' => "required|mimetypes:application/pdf|max:10000"
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        $path = public_path('uploads/officialdocumentupload/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->document != null) {
            $document = rand(0, 999999) . time() . '.' . $request->document->extension();
            $request->document->move($path, $document); 
            $documentpath="uploads/officialdocumentupload/" . $document; 
        } 

        OfficialDocumentUpload::create( 
        [ 
            "official_document_id"=>$request->id,
            "user_id"=>auth('api')->user()->id, 
            "document"=>$documentpath
        ]);

        return response()->json(json_cover([], true, "Official document upload successfully."));
     
    }



    public function getCareer(Request $request)
    {
        $url=url('/'); 
        $getCareer = Career::select('career.*', 'category.category_name as category',DB::raw("CONCAT('".$url."/',image) as image"))
                        ->leftJoin('category', 'category.id', '=', 'career.cat_id') 
                        ->orderBy('career.created_at', 'desc')
                        ->get(); 

           

        return response()->json(json_cover($getCareer, true, "Get career successfully."));
    }

    public function getCareerDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:career' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }      

        $url=url('/'); 
        $getcareer = Career::select('career.*', 'category.category_name as category',DB::raw("CONCAT('".$url."/',image) as image"))
        ->leftJoin('category', 'category.id', '=', 'career.cat_id') 
            ->where('career.id', $request->id) 
                ->first();  

        return response()->json(json_cover($getcareer, true, "Get career details successfully."));
    }


    public function getMemberDirectory(Request $request)
    {
        $url=url('/'); 
        $getMemberDirectory = MemberDirectory::select('*', DB::raw("CONCAT('".$url."/',image) as image"))->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($getMemberDirectory, true, "Get member directory successfully."));
    }


    public function getMemberDirectoryDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:member_directory' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }      

        $url=url('/'); 
        $getmember_directory = MemberDirectory::select('*',DB::raw("CONCAT('".$url."/',image) as image"))
         ->where('id', $request->id) 
                ->first();  

        return response()->json(json_cover($getmember_directory, true, "Get member directory details successfully."));
    }

    public function getBusinessRegistration(Request $request)
    {
        $url=url('/'); 
        $BusinessRegistration = BusinessRegistration::select('id','title','description', 
        DB::raw("CONCAT('".$url."/',document) as document"),DB::raw("CONCAT('".$url."/',image) as image"))->orderBy('created_at', 'desc')->get();
        return response()->json(json_cover($BusinessRegistration, true, "Get business registration successfully."));
    }

    public function getBusinessRegistrationDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:business_registration' 
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }
        $url=url('/'); 
        $BusinessRegistration = BusinessRegistration::select('id','title','description',
         DB::raw("CONCAT('".$url."/',document) as document"),DB::raw("CONCAT('".$url."/',image) as image"))
                                 ->where('id',$request->id)->first();
        return response()->json(json_cover($BusinessRegistration, true, "Get business registration details successfully."));
     
    }

    
 public function BusinessRegistrationUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1|exists:business_registration' ,
            'document' => "required|mimetypes:application/pdf|max:10000"
        ]);

        if ($validator->fails()) {
            return response()->json(json_cover($validator->errors(), false, "Please provide valid data."), 400);
        }

        $path = public_path('uploads/businessregistrationupload/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->document != null) {
            $document = rand(0, 999999) . time() . '.' . $request->document->extension();
            $request->document->move($path, $document); 
            $documentpath="uploads/businessregistrationupload/" . $document; 
        } 

        BusinessRegistrationUpload::create( 
        [ 
            "business_registration_id"=>$request->id,
            "user_id"=>auth('api')->user()->id, 
            "document"=>$documentpath
        ]);

        return response()->json(json_cover([], true, "Business registration upload successfully."));
     
    }

    
}
