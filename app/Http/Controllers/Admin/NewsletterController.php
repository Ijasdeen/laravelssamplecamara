<?php

namespace App\Http\Controllers\Admin;

use App\Models\Newsletter;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class NewsletterController extends Controller
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

            // $data = Newsletter::get();
            $data = Newsletter::select('newsletter.*','category.category_name as category')->leftJoin('category', 'category.id', '=', 'newsletter.cat_id');
            return DataTables::of($data) 
            
            ->addColumn('category', function ($data) {
                return  $data->category;
             })
             ->addColumn('file', function ($data) {
                return  "<a class='btn btn-primary btn-sm' target='_blank' href=".url($data->n_file)."><i class='fas fa-file-pdf'></i></a>";
             })
              
             ->addColumn('description_data', function ($data) {
                return Str::words(strip_tags($data->description), 30);
             })
            ->addColumn('image', function ($data) {
                return ' <a href="'.url($data->image).'" class="image-link">
                <img src="'.url($data->image).'" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditNewsletter" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteNewsletter" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('cat_id'))) {
                        $instance->where('cat_id', $request->get('cat_id'));
                    } 
                })
                ->rawColumns(['file','category','description_data','image','Actions'])
                ->make(true);
        }

        $data['category']=Category::get();
        $data['title'] = 'Manage newsletter';
        $data['link'] = route('manage-newsletter.index');
        return view('admin.newsletter.index', $data);
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
                'title'=>"required|string|max:220|unique:newsletter",
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'n_file'=> "required|mimes:pdf|max:10000"
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
      
        
        $path = public_path('uploads/newsletter/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        } 
       

        if ($request->image != null) {
            $image = rand(0, 999999) . time() . '.' . $request->image->extension();
            $request->image->move($path, $image); 
            $imagepath="uploads/newsletter/" . $image; 
        }
        else{
            $Newsletter = Newsletter::select('*')->where('id',$request->benefit_id)->first();
            $imagepath=$Newsletter->image;
        }


        if ($request->n_file != null) {
            $n_file = rand(0, 999999) . time() . '.' . $request->n_file->extension();
            $request->n_file->move($path, $n_file); 
          
            $n_filepath="uploads/newsletter/" . $n_file; 
        }
        else{
            $Newsletter = Newsletter::select('*')->where('id',$request->benefit_id)->first();
            $n_filepath=$Newsletter->n_file;
          
        }
     

         $newsletter = Newsletter::updateOrCreate(['id' => $request->benefit_id],
        [ 
            "cat_id"=>$request->cat_id,
            "title"=>$request->title,
            "description"=>strip_tags($request->description), 
            "image"=>$imagepath,
            "n_file"=>$n_filepath
        ]);
       
        if(empty($request->benefit_id))
        {
            sendNotification($request->title,'News letter added ','news_letter');
        }

        $message=(empty($request->benefit_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Newsletter '.$message.' successfully']);

        // return redirect()->route('manage-newsletter.index')->with('message', 'Newsletter added successfully');
    }
 

    public function edit($id)
    {
         $url=url('/'); 
        $Newsletter = Newsletter::select('*',DB::raw("CONCAT('".$url."/',image) as imageurl"))->find($id);
        return response()->json($Newsletter);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
       
        $newsletterImage=Newsletter::select('*')->where('id',$id)->first();
            
        $file =public_path($newsletterImage->image); 
        if ($file) {
            File::delete($file);
        }
        Newsletter::destroy($id);
        return response()->json(['success' => 'Newsletter deleted successfully']);
    }
}

