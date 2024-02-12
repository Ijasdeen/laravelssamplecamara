<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\EventAttend;
use App\Models\Event;


use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class UserController extends Controller
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
      	$data = User::whereIn("type", array("0"))->select('*');

            return DataTables::of($data)
                  ->addColumn("status", function ($data) {
                    $status = ($data->status == '1') ? 'checked' : '';
                    return '<input type="checkbox" class="chkToggle2 btn-sm"
                    ' . $status . '  data-id="' . $data->id . '" data-toggle="toggle"
                    data-onstyle="primary" data-offstyle="warning">
                    ';
                }) 
                ->addColumn('Actions', function ($data) {

                    return '
                    <button  type="button"  data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditUser" > <i class="fas fa-edit">
                         </i> Edit</button>
                     <a class="btn btn-info btn-sm mr-2" href="' . route("manage-user.show", $data->id) . '">
                     <i class="fas fa-eye"> </i>
                     View
                     </a><button type="button" data-id="' . $data->id . '"  data-email="' . $data->email . '"  data-name="' . $data->name . '"  class="btn btn-danger btn-sm DeleteUser mr-2" > <i class="fas fa-trash">
                     </i> Delete</button>
                      ';
                })
                ->rawColumns([ 'status',  'Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage user';
        $data['link'] = route('manage-user.index');
        return view("admin/user/index", $data);
    }
 
    public function show($id)
    { 

        // $Event = Event::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        $user = User::select('*')->whereIn("type", array("0"))->where('id',$id)->first();
      
        $data['user_details'] = $user; 


        // $attended_user_counter=EventAttend::select('*')->where('event_id',$id)->count();

        $event_attended_ids= EventAttend::select(DB::raw('group_concat(event_id) as event_ids'))
        ->leftJoin('users', 'users.id', '=', 'event_attend.user_id')->where('event_attend.user_id',$id)->first();
        $url=url('/'); 
        $data['event_attended_user']=array();
        
        if($event_attended_ids)
        {
            $data['event_attended_user']= Event::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))
            ->whereIn('id', explode(',',$event_attended_ids->event_ids))->get();
        }  
        
        $data['title'] = 'User Details';
        $data['link'] = route('manage-user.index');

        return view('admin/user/show', $data);
    }

    public function destroy($id)
    {
         
        User::destroy($id);
        return response()->json(['success' => 'User deleted successfully']);
    }

    public function edit($id)
    { $url=url('/'); 
        $User = User::select('*')->find($id);
         return response()->json($User);
    }

    public function store(Request $request)
    { 
        if(empty($request->user_id))
        { 
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:100',
                'phoneno'=>'required|string',
                'membership'=>'required|string',
                'membership_no'=>'required|string',
                'validity'=>'required|string|date'
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
        
         $user = User::updateOrCreate(['id' => $request->user_id],
        [ 
            "email"=>$request->email,
            "phoneno"=>$request->phoneno,
            "membership"=>$request->membership,
            "membership_no"=>$request->membership_no,
            "validity"=>$request->validity
        ]); 
        
        $message=(empty($request->benefit_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'User '.$message.' successfully']);

    }
 
}
