<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppIntroduction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class AppIntroductionController extends Controller
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

            // $data = AppIntroduction::get();
            $data = AppIntroduction::select('*');
            return DataTables::of($data) 
               ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             }) 
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditAppIntroduction" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteAppIntroduction" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['description_data','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage  app-introduction';
        $data['link'] = route('manage-app-introduction.index');
        return view('admin.appintroduction.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    {  
        if(empty($request->app_introduction_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:app_introduction", 
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
         
        $appintroduction = AppIntroduction::updateOrCreate(['id' => $request->app_introduction_id],
        [ 
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
         ]);   
       
        $message=(empty($request->service_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'App introduction id '.$message.' successfully']);
 
     }
 

    public function edit($id)
    {  
        $AppIntroduction = AppIntroduction::select('*')->find($id);
        return response()->json($AppIntroduction);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $servicesImage=AppIntroduction::select('*')->where('id',$id)->first();
            
        AppIntroduction::destroy($id);
        return response()->json(['success' => 'App introduction deleted successfully']);
    }
}

