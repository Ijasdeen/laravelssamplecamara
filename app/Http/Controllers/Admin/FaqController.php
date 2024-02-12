<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;

class FaqController extends Controller
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

            // $data = Faq::get();
            $data = Faq::select('*');
            return DataTables::of($data) 
               ->addColumn('answer', function ($data) {
                return Str::words(strip_tags($data->answer), 30);
             }) 
             ->addColumn('Actions', function ($data) {
                    
                    return '<button type="button" data-id="' . $data->id . '" class="btn btn-warning btn-sm mr-2 EditFaq" > <i class="fas fa-edit">
                         </i> Edit</button>
                         <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteFaq" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['answer_data','Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage Faq';
        $data['link'] = route('manage-faq.index');
        return view('admin.faq.index', $data);
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request)
    { 
        if(empty($request->faq_id))
        { 
            $validator = Validator::make($request->all(), [
                'question'=>"required|string|unique:faq", 
                'answer'=>"required|string", 
            ]);
                
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json(["success" => false,'error' => $error]);
                exit();
             }
         }
        $Faq = Faq::updateOrCreate(['id' => $request->faq_id],
        [ 
            "question"=>$request->question,
            "answer"=>strip_tags($request->answer), 
         ]);
       
      
        $message=(empty($request->faq_id)) ? "added" : "update";
        return response()->json(["success" => true,'success' => 'Faq '.$message.' successfully']);

     }
 

    public function edit($id)
    { $url=url('/'); 
        $Faq = Faq::select('*')->find($id);
        return response()->json($Faq);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        
        Faq::destroy($id);
        return response()->json(['success' => 'Faq deleted successfully']);
    }
}

