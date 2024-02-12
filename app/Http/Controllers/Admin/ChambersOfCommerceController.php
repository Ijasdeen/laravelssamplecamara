<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChambersOfCommerce;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class ChambersOfCommerceController extends Controller
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

             $data = ChambersOfCommerce::select('*');
            return DataTables::of($data) 
               ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             })
            ->addColumn('image', function ($data) {
                return ' <a href="'.url($data->image).'" class="image-link">
                <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditChambersOfCommerce" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteChambersOfCommerce" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['description_data','image','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage chambers of commerce';
        $data['link'] = route('manage-chambers-of-commerce.index');
        return view('admin.chambersofcommerce.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->chambers_of_commerce_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:chambers_of_commerce",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
        
        $path = public_path('uploads/chambersofcommerce');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/chambersofcommerce/" . $image; 
        }
        else{
            $ChambersOfCommerce = ChambersOfCommerce::select('*')->where('id',$request->chambers_of_commerce_id)->first();
            $imagepath=$ChambersOfCommerce->image;
        }
     
        $chambers_of_commerce = ChambersOfCommerce::updateOrCreate(['id' => $request->chambers_of_commerce_id],
        [ 
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
            "image"=>$imagepath
        ]);
       
        
        
        $message=(empty($request->chambers_of_commerce_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Chambers of commerce '.$message.' successfully']);

     }
 

    public function edit($id)
    { $url=url('/'); 
        $ChambersOfCommerce = ChambersOfCommerce::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        return response()->json($ChambersOfCommerce);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $chambers_of_commerce=ChambersOfCommerce::select('*')->where('id',$id)->first();
            
        $file =public_path($chambers_of_commerce->image); 
        if ($file) {
            File::delete($file);
        }
        ChambersOfCommerce::destroy($id);
        return response()->json(['success' => 'Chambers of commerce deleted successfully']);
    }
}

