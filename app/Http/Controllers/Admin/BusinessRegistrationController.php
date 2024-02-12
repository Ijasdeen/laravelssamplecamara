<?php

namespace App\Http\Controllers\Admin;

use App\Models\BusinessRegistration;
use App\Models\BusinessRegistrationUpload;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class BusinessRegistrationController extends Controller
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

            // $data = BusinessRegistration::get();
            $data = BusinessRegistration::select('*');
            return DataTables::of($data) 
               ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             })
            ->addColumn('document', function ($data) {
                return ' <a href="'.url($data->document).'" class="btn btn-primary  document-link" download>
                <i class="fas fa-file-pdf"></i></a>';
                }) 
                ->addColumn('image', function ($data) {
                    return ' <a href="'.url($data->image).'" class="image-link">
                    <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                    })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditBusinessRegistration" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteBusinessRegistration mr-2" > <i class="fas fa-trash">
                         </i> Delete</button>
                         <a class="btn btn-info btn-sm" href="' . route("manage-business-registration.show", $data->id) . '">
                         <i class="fas fa-eye"> </i>   
                         View
                 </a>';
                })
                ->rawColumns(['description_data','image','document','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage business registration';
        $data['link'] = route('manage-business-registration.index');
        return view('admin.businessregistration.index', $data);
    }
 

    public function show($id)
    {
        $url=url('/'); 
        
         $BusinessRegistrationUpload = BusinessRegistrationUpload::select
         ('business_registration_upload.id','business_registration_upload.user_id','users.name',
         DB::raw("CONCAT('".$url."/',business_registration_upload.document) as document"))
        ->leftJoin('users', 'users.id', '=', 'business_registration_upload.user_id')
        ->where('business_registration_upload.business_registration_id',$id)->get();
         $data['BusinessRegistrationUpload'] = $BusinessRegistrationUpload;  
        
        $data['title'] = 'Business registration details';
        $data['link'] = route('manage-business-registration.index');

        return view('admin/businessregistration/show', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->official_document_id))
        { 
            $validator = Validator::make($request->all(), [
                'title'=>"required|string|max:220|unique:official_document",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'document' => "required|mimes:pdf|max:10000"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
        
        $path = public_path('uploads/businessregistration/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->document != null) {
            $document = rand(0, 999999) . time() . '.' . $request->document->extension();
            $request->document->move($path, $document); 
            $documentpath="uploads/businessregistration/" . $document; 
        }
        else{
            $BusinessRegistration = BusinessRegistration::select('*')->where('id',$request->official_document_id)->first();
            $documentpath=$BusinessRegistration->document;
        }
     

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/businessregistration/" . $image; 
        }
        else{
            $BusinessRegistration = BusinessRegistration::select('*')->where('id',$request->official_document_id)->first();
            $imagepath=$BusinessRegistration->image;
        }

        $BusinessRegistration = BusinessRegistration::updateOrCreate(['id' => $request->official_document_id],
        [ 
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
            "document"=>$documentpath,
            'image'=>$imagepath
        ]);
       
        
        
        $message=(empty($request->official_document_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Business registration '.$message.' successfully']);

     }
 

    public function edit($id)
    { $url=url('/'); 
        $BusinessRegistration = BusinessRegistration::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"),DB::raw("CONCAT('".$url."/',document) as documenturl"))->find($id);
        return response()->json($BusinessRegistration);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $BusinessRegistration=BusinessRegistration::select('*')->where('id',$id)->first();
            
        $file =public_path($BusinessRegistration->document); 
        if ($file) {
            File::delete($file);
        }
        BusinessRegistration::destroy($id);
        return response()->json(['success' => 'Business registration deleted successfully']);
    }
}

