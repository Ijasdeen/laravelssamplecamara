<?php

namespace App\Http\Controllers\Admin;

use App\Models\OfficialDocument;
use App\Models\OfficialDocumentUpload;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class OfficialDocumentController extends Controller
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

            // $data = OfficialDocument::get();
            $data = OfficialDocument::select('*');
            return DataTables::of($data) 
               ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             })
             ->addColumn('image', function ($data) {
                return ' <a href="'.url($data->image).'" class="image-link">
                <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
            ->addColumn('document', function ($data) {
                return ' <a href="'.url($data->document).'" class="btn btn-primary  document-link" download>
                <i class="fas fa-file-pdf"></i></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditOfficialDocument" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm  mr-2 DeleteOfficialDocument" > <i class="fas fa-trash">
                         </i> Delete</button>
                         <a class="btn btn-info btn-sm" href="' . route("manage-official-document.show", $data->id) . '">
                         <i class="fas fa-eye"> </i>   
                         View
                 </a>';
                })
                ->rawColumns(['image','description_data','document','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage official document';
        $data['link'] = route('manage-official-document.index');
        return view('admin.officialdocument.index', $data);
    }
 
    public function show($id)
    {
        $url=url('/'); 
         $OfficialDocumentUpload = OfficialDocumentUpload::select
         ('official_document_upload.id','official_document_upload.user_id','users.name' ,DB::raw("CONCAT('".$url."/',official_document_upload.document) as document"))
        ->leftJoin('users', 'users.id', '=', 'official_document_upload.user_id')
        ->where('official_document_upload.official_document_id',$id)->get();
         $data['OfficialDocumentUpload'] = $OfficialDocumentUpload;  
        
        $data['title'] = 'Official document details';
        $data['link'] = route('manage-official-document.index');

        return view('admin/officialdocument/show', $data);
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
      
        
        $path = public_path('uploads/officialdocument/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->document != null) {
            $document = rand(0, 999999) . time() . '.' . $request->document->extension();
            $request->document->move($path, $document); 
            $documentpath="uploads/officialdocument/" . $document; 
        }
        else{
            $OfficialDocument = OfficialDocument::select('*')->where('id',$request->official_document_id)->first();
            $documentpath=$OfficialDocument->document;
        }

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/officialdocument/" . $image; 
        }
        else{
            $OfficialDocument = OfficialDocument::select('*')->where('id',$request->official_document_id)->first();
            $imagepath=$OfficialDocument->image;
        }
     
        $officialdocument = OfficialDocument::updateOrCreate(['id' => $request->official_document_id],
        [ 
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
            "document"=>$documentpath,
            "image"=>$imagepath
        ]); 
        
        $message=(empty($request->official_document_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Official document '.$message.' successfully']);

     }
 

    public function edit($id)
    { $url=url('/'); 
        $OfficialDocument = OfficialDocument::select('*',DB::raw("CONCAT('".$url."/',image) as image"),
        DB::raw("CONCAT('".$url."/',document) as documenturl"))->find($id);
        return response()->json($OfficialDocument);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $officialdocument=OfficialDocument::select('*')->where('id',$id)->first();
            
        $file =public_path($officialdocument->document); 
        if ($file) {
            File::delete($file);
        }
        OfficialDocument::destroy($id);
        return response()->json(['success' => 'Official document deleted successfully']);
    }
}

