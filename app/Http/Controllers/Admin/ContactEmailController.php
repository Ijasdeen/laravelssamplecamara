<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;

class ContactEmailController extends Controller
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

            // $data = ContactEmail::get();
            $data = ContactEmail::select('*');

            return DataTables::of($data) 
                ->addColumn('Actions', function ($data) { 
                    return '<a class="btn btn-primary btn-sm" href="' . route("manage-contact-email.edit", $data->id) . '">
                   <i class="fas fa-pencil-alt">
                   </i> Edit </a> <button type="button" data-id="' . $data->id . '"  class="btn btn-danger btn-sm DeleteContactEmail" > <i class="fas fa-trash">
                         </i> Delete</button>';
                })
                ->rawColumns(['Actions'])
                ->make(true);
        }

        $data['title'] = 'Manage contact email';
        $data['link'] = route('manage-contact-email.index');
        return view('admin.contactemail.index', $data);
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
        $validate["email"] = "required|string|max:220|unique:contact_email";
        $this->validate($request, $validate); 

        $contactemail = ContactEmail::create([
            "email" => $request->email
        ]);
        $contactemail->save();

        return redirect()->route('manage-contact-email.index')->with('message', 'Contact email added successfully');
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
        $data['contactemail'] = ContactEmail::find($id);
        $data['title'] = 'Edit contact email';
        $data['link'] = route('manage-contact-email.index');
        return view('admin.contactemail.index', $data);
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
        $contactemail = ContactEmail::find($id);
  
        $validate["email"] = [
            "required",
            "string",
            "max:220",
            Rule::unique('contact_email')->ignore($id),
        ];

        $this->validate($request, $validate);

        $contactemail_update=array("email" => $request->email); 
        
        $contactemail->update($contactemail_update);
        $contactemail->save();
        return redirect()->route('manage-contact-email.index')->with('message', 'Contact email updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ContactEmail::destroy($id);
        return response()->json(['success' => 'Contact email deleted successfully']);
    }
}

