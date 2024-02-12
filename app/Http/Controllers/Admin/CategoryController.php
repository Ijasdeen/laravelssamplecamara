<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;

class CategoryController extends Controller
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

            // $data = Category::get();
            $data = Category::select('*');

            return DataTables::of($data) 
                ->addColumn('Actions', function ($data) { 
                    return '<a class="btn btn-primary btn-sm" href="' . route("manage-category.edit", $data->id) . '">
                   <i class="fas fa-pencil-alt">
                   </i> Edit </a> <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteCategory" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage category';
        $data['link'] = route('manage-category.index');
        return view('admin.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validate["category_name"] = "required|string|max:220|unique:category";
        $this->validate($request, $validate); 

        $category = Category::create([
            "category_name" => $request->category_name
        ]);
        $category->save();

        return redirect()->route('manage-category.index')->with('message', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = Category::find($id);
        $data['title'] = 'Edit category type';
        $data['link'] = route('manage-category.index');
        return view('admin.category.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
  
        $validate["category_name"] = [
            "required",
            "string",
            "max:220",
            Rule::unique('category')->ignore($id),
        ];

        $this->validate($request, $validate);

        $category_update=array("category_name" => $request->category_name); 
        
        $category->update($category_update);
        $category->save();
        return redirect()->route('manage-category.index')->with('message', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        return response()->json(['success' => 'Category deleted successfully']);
    }
}

