<?php

namespace App\Http\Controllers\Admin;

use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class ServicesController extends Controller
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

            // $data = Services::get();
            $data = Services::select('*');
            return DataTables::of($data) 
               ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             })
            ->addColumn('image', function ($data) {
                return '<a href="'.url($data->image).'" class="image-link">
                <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditServices" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteServices" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['description_data','image','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage services';
        $data['link'] = route('manage-services.index');
        return view('admin.services.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->service_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:services",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
        
        $path = public_path('uploads/services/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/services/" . $image; 
        }
        else{
            $Services = Services::select('*')->where('id',$request->service_id)->first();
            $imagepath=$Services->image;
        }
     
        $services = Services::updateOrCreate(['id' => $request->service_id],
        [ 
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
            "image"=>$imagepath
        ]);
       
        
        
        $message=(empty($request->service_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Services '.$message.' successfully']);

        // return redirect()->route('manage-services.index')->with('message', 'Services added successfully');
    }
 

    public function edit($id)
    { 
        $url=url('/'); 
        $Services = Services::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        return response()->json($Services);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $servicesImage=Services::select('*')->where('id',$id)->first();
            
        $file =public_path($servicesImage->image); 
        if ($file) {
            File::delete($file);
        }
        Services::destroy($id);
        return response()->json(['success' => 'Services deleted successfully']);
    }
}

