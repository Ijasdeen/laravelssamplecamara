<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

use App\Models\Services;  
use App\Models\Benefits;  
use App\Models\Event; 

use Illuminate\Support\Facades\File;

class BannerController extends Controller
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

            // $data = Banner::get();
            $data = Banner::select('*');
            return DataTables::of($data) 
            ->addColumn('redirection', function ($data) {
                if($data->redirection=='on')
                {
                    return '<span class="btn btn-primary btn-sm">'.$data->redirection.'</span>';
                }else{
                    return '<span class="btn btn-warning btn-sm">'.$data->redirection.'</span>';
                }
             
                })
            ->addColumn('banner_image', function ($data) {
                return ' <a href="'.url($data->banner_image).'" class="image-link">
                      <img src="'.url($data->banner_image).'" width="60" class="img-thumbnail"></a>';
                })
                ->addColumn('Actions', function ($data) {

                    return '<button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteBanner" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['redirection','banner_image','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage banner';
        $data['link'] = route('manage-banner.index');
        $data['events'] = Event::select('id','title')->get();
        $data['benefits'] = Benefits::select('id','title')->get(); 
        $data['Services'] = Services::select('id','title')->get();
        return view('admin.banner.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = array();
        $validate["banner_image"] =  "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048";
        
        $this->validate($request, $validate);
        
        $path = public_path('uploads/banner/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if ($request->banner_image != null) {
            $banner_image = rand(0, 999999) . time() . '.' . $request->banner_image->extension();
            $request->banner_image->move($path, $banner_image); 
        }
     
        $banner = Banner::create([
            "banner_image" => "uploads/banner/" . $banner_image, 
            "redirection"=>$request->redirection,
            "banner_type"=>$request->banner_type,

        ]);
        $banner->save();

        return redirect()->route('manage-banner.index')->with('message', 'Banner added successfully');
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bannerImage=Banner::select('*')->where('id',$id)->first();
            
        $file =public_path($bannerImage->banner_image); 
        if ($file) {
            File::delete($file);
        }
        Banner::destroy($id);
        return response()->json(['success' => 'Banner deleted successfully']);
    }
}

