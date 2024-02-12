<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Event;
use App\Models\Benefits;
use App\Models\Newsletter;
use App\Models\Services;
use App\Models\User; 
use App\Models\AppIntroduction; 
use App\Models\Staticpage;
use App\Models\ContactEmail;
 use App\Models\Faq;
use App\Models\ChambersOfCommerce;
use App\Models\Career;
use App\Models\OfficialDocument;
use App\Models\BusinessRegistration;
use App\Models\MemberDirectory;

class DashboardController extends Controller
{
    public function index()
    { 
        $data['title'] = 'Dashboard';

        $data['banner'] =  Banner::count();
        $data['benefits'] =  Benefits::where('status','1')->count();
        $data['category'] =  Category::count();
        $data['appintroduction'] =  AppIntroduction::count();
        $data['staticpage'] =  Staticpage::count();

        
        
        $data['event'] =  Event::where('status','1')->count();
        $data['newsletter'] = Newsletter::where('status','1')->count();
        $data['services'] =  Services::where('status','1')->count();
        $data['users'] =  User::where('type','0')->count();


        $data['contact_email'] =  ContactEmail::count();
        $data['faq'] =  Faq::count();
        $data['ChambersOfCommerce'] =  ChambersOfCommerce::count();
        $data['OfficialDocument'] =  OfficialDocument::count();
        $data['BusinessRegistration'] =  BusinessRegistration::count();
        $data['MemberDirectory'] =  MemberDirectory::count();

        $data['Career'] =  Career::count();





        $data['link'] = route('admin.dashboard');
        return view('admin.dashboard', $data);
    }

    public function change_password_view()
    {
        $data['title'] = 'Change password';
        $data['link'] = route('admin.change_password');
        $data['user'] = auth()->user();
        return view("admin.change_password", $data);
    }

    public function change_password(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            "password" => "required|max:10|min:6",
            "new_password" => "required|max:10|min:6",
            "password_confirmation" => "required|same:new_password",
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with("error", "Current password Incorrect Try again");
        }

        $user->update([
            "password" => Hash::make($request->new_password),
        ]);
        return redirect()->back()->with("message", "Password Updated Successfully");
    }

    public function  update_profile_view()
    {
        $data['title'] = 'Update Profile';
        $data['link'] = route('admin.update_profile');
        $data['user'] = auth()->user();
        return view("admin.update_profile_view", $data);
    }

    public function update_profile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required', 
            // 'email' =>  [
            //     'required',
            //     Rule::unique('users')->ignore(auth()->user()->id),
            // ],
        ]);
        
        $path = public_path('uploads/admin/');

        if (!File::isDirectory($path)) {

            File::makeDirectory($path, 0777, true, true);
        }

        $user = auth()->user();
        

        if ($request->name != null) {
            $user->name = $request->name;
        }
        if ($request->email  != null) {
            $user->email  = $request->email;
        }
        if ($request->user_image != null) {
            $imageName = rand(0, 999999) . time() . '.' . $request->user_image->extension();
            $request->user_image->move($path, $imageName);
            $user->user_image =  'uploads/admin/' . $imageName;
        }

        $user->save();
        return redirect()->back()->with("message", "Profile Updated Successfully");
    }
    
    //common Function for change status
    public function changeStatus(Request $request)
    {
        $filename = $request->data;

        $model = '\\App\\Models\\' . $filename;

        $data = $model::find($request->id);
        $data->status = $request->status;
        $data->save();
        return response()->json(['success' => 'Status change successfully']);
    }


}
