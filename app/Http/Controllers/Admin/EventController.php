<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Category;
use App\Models\EventAttend;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {

            // $data = Event::get();
            $data = Event::select('event.*','category.category_name as category')
            ->leftJoin('category', 'category.id', '=', 'event.cat_id');
            return DataTables::of($data) 
            
            ->addColumn('category', function ($data) {
                return  $data->category;
             })
              ->addColumn('event_date', function ($data) {
                return date('Y-m-d h:i A', strtotime($data->start_datetime)) .' - '. date('Y-m-d h:i A', strtotime($data->end_datetime)) ;
             })
             ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 20);
             }) 
            ->addColumn('image', function ($data) {
                return ' <a href="'.url($data->image).'" class="image-link">
                <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditEvent" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm mr-2  DeleteEvent" > <i class="fas fa-trash">
                         </i> Delete</button>
                         <a class="btn btn-info btn-sm" href="' . route("manage-event.show", $data->id) . '">
                                    <i class="fas fa-eye"> </i>
                                    View
                            </a>';
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('cat_id'))) {
                        $instance->where('cat_id', $request->get('cat_id'));
                    } 
                })
                ->rawColumns(['category','event_date','description_data','image','Actions'])
                ->make(true);
        }
 
        $data['category']=Category::get();
        $data['title'] = 'Manage event';
        $data['link'] = route('manage-event.index');
        return view('admin.event.index', $data);
    }
 


    public function show($id)
    {
        $url=url('/'); 
        // $Event = Event::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        $Event = Event::select('event.*','category.category_name as category',DB::raw("CONCAT('".$url."/',image) as imageurl"))
        ->leftJoin('category', 'category.id', '=', 'event.cat_id')->where('event.id',$id)->first();
        $Event->event_date=date('Y-m-d h:i A', strtotime($Event->start_datetime)) .' - '. date('Y-m-d h:i A', strtotime($Event->end_datetime)) ;
     
        $data['event'] = $Event; 

        $attended_user_counter=EventAttend::select('*')->where('event_id',$id)->count();

        $data['attended_user']=EventAttend::select('event_attend.*','users.name')
        ->leftJoin('users', 'users.id', '=', 'event_attend.user_id') 
        ->where('event_attend.event_id',$id)->get();

        $data['attended_user_counter']=$attended_user_counter; 
        
        $data['title'] = 'Event Details';
        $data['link'] = route('manage-event.index');

        return view('admin/event/show', $data);
    }

    public function store(Request $request)
    { 
        if(empty($request->benefit_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:event",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
        
        $path = public_path('uploads/event/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       
        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/event/" . $image; 
        }
        else{
            $Event = Event::select('*')->where('id',$request->benefit_id)->first();
            $imagepath=$Event->image;
        }
     
        $event_date=explode(' - ',$request->event_date);
        $event = Event::updateOrCreate(['id' => $request->benefit_id],
        [ 
            "cat_id"=>$request->cat_id,
            "title"=>$request->title,
            "description"=>strip_tags($request->description),  
            "start_datetime"=>date('Y-m-d H:i:s', strtotime($event_date[0])), 
            "end_datetime"=>date('Y-m-d H:i:s', strtotime($event_date[1])), 
            "address"=>$request->address, 
            "event_share"=>$request->event_share,
            "latitude"=>'21.192572', 
            "longitude"=>'72.799736',  
            "image"=>$imagepath
        ]);
        
        if(empty($request->benefit_id))
        {
            $eventdate = "Event date is ".date('d-m-Y', strtotime($event_date[0]));
            sendNotification($request->title,$eventdate,'event');
        }

        $message=(empty($request->benefit_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Event '.$message.' successfully']);

    }
 

    public function edit($id)
    { $url=url('/'); 
        $Event = Event::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        $Event->event_date=date('Y-m-d h:i A', strtotime($Event->start_datetime)) .' - '. date('Y-m-d h:i A', strtotime($Event->end_datetime)) ;
        return response()->json($Event);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $eventImage=Event::select('*')->where('id',$id)->first();
            
        $file =public_path($eventImage->image); 
        if ($file) {
            File::delete($file);
        }
        Event::destroy($id);
        return response()->json(['success' => 'Event deleted successfully']);
    }
}

