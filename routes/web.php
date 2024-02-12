<?php
  
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\BannerController; 
use App\Http\Controllers\Admin\ServicesController; 
use App\Http\Controllers\Admin\AppIntroductionController;  
use App\Http\Controllers\Admin\StaticPageController;  
use App\Http\Controllers\Admin\BenefitsController; 
use App\Http\Controllers\Admin\NewsletterController;  
use App\Http\Controllers\Admin\EventController; 
use App\Http\Controllers\Admin\ContactEmailController;  
use App\Http\Controllers\Admin\FaqController;  
use App\Http\Controllers\Admin\OfficialDocumentController;
use App\Http\Controllers\Admin\ChambersOfCommerceController;
use App\Http\Controllers\Admin\BusinessRegistrationController;
use App\Http\Controllers\Admin\MemberDirectoryController;
use App\Http\Controllers\Admin\CareerController;



use App\Http\Controllers\Admin\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route("login");
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
// Route::middleware(['auth', 'user-access:admin'])->group(function () {
Route::group(['prefix' => 'admin', 'middleware' => ['user-access:admin', 'auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/change-password', [DashboardController::class, "change_password_view"])->name("admin.change_password");
    Route::put('/change_password', [DashboardController::class, "change_password"])->name("edit_password");
    Route::get('/update-profile', [DashboardController::class, "update_profile_view"])->name("admin.update_profile");
    Route::put('/update_profile', [DashboardController::class, "update_profile"])->name("edit_profile");
     Route::post('/changeStatus', [DashboardController::class, 'changeStatus'])->name('admin.changeStatus');
    
    Route::resource('manage-user', UserController::class);    
     
    Route::resource('manage-category', CategoryController::class);
    
    Route::resource('manage-banner', BannerController::class); 
    Route::resource('manage-services', ServicesController::class);
    Route::resource('manage-app-introduction', AppIntroductionController::class);
    Route::resource('manage-static-page', StaticPageController::class);
    Route::resource('manage-benefits', BenefitsController::class); 
    Route::resource('manage-newsletter', NewsletterController::class);
    Route::resource('manage-contact-email', ContactEmailController::class);

         

    
    
    Route::resource('manage-event', EventController::class); 
    Route::resource('manage-faq', FaqController::class); 
   
    Route::resource('manage-official-document', OfficialDocumentController::class);
    Route::resource('manage-chambers-of-commerce',ChambersOfCommerceController::class);
    Route::resource('manage-business-registration', BusinessRegistrationController::class);

    Route::resource('manage-member-directory', MemberDirectoryController::class);
    Route::resource('manage-career', CareerController::class);

    

    
    
}); 


