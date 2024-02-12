<?php

namespace App\Http\Controllers\Admin;

use App\Models\Career;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class CareerController extends Controller
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

            
             $data = Career::select('career.*','category.category_name as category')->leftJoin('category', 'category.id', '=', 'career.cat_id');

            return DataTables::of($data) 
                ->addColumn('category', function ($data) {
                    return  $data->category;
                })
               ->addColumn('description_data', function ($data) {
                     return Str::words(strip_tags($data->description), 30);
                })
               ->addColumn('image', function ($data) {
                    return ' <a href="'.url($data->image).'" class="image-link">
                    <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditCareer" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteCareer" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })->filter(function ($instance) use ($request) {
                    if (!empty($request->get('cat_id'))) {
                        $instance->where('cat_id', $request->get('cat_id'));
                    } 
                })
                ->rawColumns(['category','description_data','image','Actions'])
                ->make(true);
        }
        $data['category']=Category::get();
        $data['title'] = 'Manage career';
        $data['link'] = route('manage-career.index');
        return view('admin.career.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->career_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:career",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
        
        $path = public_path('uploads/career/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/career/" . $image; 
        }
        else{
            $Career = Career::select('*')->where('id',$request->career_id)->first();
            $imagepath=$Career->image;
        }
        
        $career = Career::updateOrCreate(['id' => $request->career_id],
        [ 
            "cat_id"=>$request->cat_id,
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
            "career_date"=>$request->career_date,
            "company_name"=>$request->company_name,
            "pay_scale"=>$request->pay_scale,
            "email"=>$request->email,
            "image"=>$imagepath
        ]);
         
        $message=(empty($request->career_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Career '.$message.' successfully']);
    }
 

    public function edit($id)
    {
        $url=url('/'); 
        $Career = Career::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        return response()->json($Career);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $careerImage=Career::select('*')->where('id',$id)->first();
            
        $file =public_path($careerImage->image); 
        if ($file) {
            File::delete($file);
        }
        Career::destroy($id);
        return response()->json(['success' => 'Career deleted successfully']);
    }
}

