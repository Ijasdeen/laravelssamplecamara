<?php

namespace App\Http\Controllers\Admin;

use App\Models\Benefits;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class BenefitsController extends Controller
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

            // $data = Benefits::get();
            $data = Benefits::select('benefits.*','category.category_name as category')->leftJoin('category', 'category.id', '=', 'benefits.cat_id');
            return DataTables::of($data) 
            
            ->addColumn('category', function ($data) {
                return  $data->category;
             })
              ->addColumn('benefits_date', function ($data) {
                return $data->start_date .' - '. $data->end_date ;
             })
             ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             })
            ->addColumn('image', function ($data) {
                return ' <a href="'.url($data->image).'" class="image-link">
                <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditBenefits" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteBenefits" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('cat_id'))) {
                        $instance->where('cat_id', $request->get('cat_id'));
                    } 
                })
                ->rawColumns(['category','benefits_date','description_data','image','Actions'])
                ->make(true);
        }

        $data['category']=Category::get();
        $data['title'] = 'Manage benefits';
        $data['link'] = route('manage-benefits.index');
        return view('admin.benefits.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->benefit_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:benefits",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
        
        $path = public_path('uploads/benefits/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/benefits/" . $image; 
        }
        else{
            $Benefits = Benefits::select('*')->where('id',$request->benefit_id)->first();
            $imagepath=$Benefits->image;
        }
     
        $benefits_date=explode(' - ',$request->benefits_date);
        $benefits = Benefits::updateOrCreate(['id' => $request->benefit_id],
        [ 
            "cat_id"=>$request->cat_id,
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
            "start_date"=>$benefits_date[0], 
            "end_date"=>$benefits_date[1], 
            "image"=>$imagepath
        ]);
       
        
        
        $message=(empty($request->benefit_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Benefits '.$message.' successfully']);

        // return redirect()->route('manage-benefits.index')->with('message', 'Benefits added successfully');
    }
 

    public function edit($id)
    { $url=url('/'); 
        $Benefits = Benefits::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        return response()->json($Benefits);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $benefitsImage=Benefits::select('*')->where('id',$id)->first();
            
        $file =public_path($benefitsImage->image); 
        if ($file) {
            File::delete($file);
        }
        Benefits::destroy($id);
        return response()->json(['success' => 'Benefits deleted successfully']);
    }
}

