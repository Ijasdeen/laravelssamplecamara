<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staticpage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class StaticPageController extends Controller
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

            // $data = Staticpage::get();
            $data = Staticpage::select('*');
            return DataTables::of($data) 
               ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             }) 
             ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditStaticPage" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteStaticPage" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['description_data','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage static page';
        $data['link'] = route('manage-static-page.index');
        return view('admin.staticpage.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->staticpage_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:staticpage", 
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
        $Staticpage = Staticpage::updateOrCreate(['id' => $request->staticpage_id],
        [ 
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
         ]);
       
      
        $message=(empty($request->staticpage_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Static page '.$message.' successfully']);

        // return redirect()->route('manage-static-page.index')->with('message', 'Staticpage added successfully');
    }
 

    public function edit($id)
    { $url=url('/'); 
        $Staticpage = Staticpage::select('*')->find($id);
        return response()->json($Staticpage);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        
        Staticpage::destroy($id);
        return response()->json(['success' => 'Static page deleted successfully']);
    }
}

