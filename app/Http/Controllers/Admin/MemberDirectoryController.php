<?php

namespace App\Http\Controllers\Admin;

use App\Models\MemberDirectory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class MemberDirectoryController extends Controller
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

            // $data = MemberDirectory::get();
            $data = MemberDirectory::select('*');
            return DataTables::of($data)  
            ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 20);
             })
               ->addColumn('website', function ($data) {
                return ' <a href="'.$data->website.'" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-globe" aria-hidden="true"></i>
               Open Website </a>';
                })
                
            ->addColumn('image', function ($data) {
                return ' <a href="'.url($data->image).'" class="image-link">
                <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditMemberDirectory" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteMemberDirectory" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['description_data','website','image','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage member directory';
        $data['link'] = route('manage-member-directory.index');
        return view('admin.memberdirectory.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->memberdirectory_id))
        { 
            $validator = Validator::make($request->all(), [
                'company_name'=>"required|string|max:220|unique:member_directory",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
        
        $path = public_path('uploads/memberdirectory/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/memberdirectory/" . $image; 
        }
        else{
            $MemberDirectory = MemberDirectory::select('*')->where('id',$request->memberdirectory_id)->first();
            $imagepath=$MemberDirectory->image;
        }
     
        $services = MemberDirectory::updateOrCreate(['id' => $request->memberdirectory_id],
        [ 
            "company_name"=>$request->company_name,
            "website"=>$request->website, 
            "email"=>$request->email, 
            "contact_no"=>$request->contact_no, 
            "poc_name"=>$request->poc_name, 
            "sector"=>$request->sector, 
            "image"=>$imagepath,
            "description"=>strip_tags($request->description), 
        ]);
       
        
        
        $message=(empty($request->memberdirectory_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Member directory '.$message.' successfully']);

        // return redirect()->route('manage-member-directory.index')->with('message', 'MemberDirectory added successfully');
    }
 

    public function edit($id)
    { 
        $url=url('/'); 
        $MemberDirectory = MemberDirectory::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        return response()->json($MemberDirectory);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $servicesImage=MemberDirectory::select('*')->where('id',$id)->first();
            
        $file =public_path($servicesImage->image); 
        if ($file) {
            File::delete($file);
        }
        MemberDirectory::destroy($id);
        return response()->json(['success' => 'Member directory deleted successfully']);
    }
}

