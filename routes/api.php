<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EventController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

  
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user-profile', [AuthController::class, 'userProfile']); 
    
    Route::post('forget-password', [AuthController::class, 'forgetPassword']); 
    Route::post('code-check', [AuthController::class, 'codeCheck']); 
    Route::post('reset-password', [AuthController::class, 'resetPassword']); 
    
     
    Route::post('update-userprofile', [UserController::class, 'updateProfile']); 
    Route::post('change-password', [UserController::class, 'changePassword']); 

    Route::post('notification-setting', [UserController::class, 'notificationSetting']); 
    Route::get('get-notification-setting', [UserController::class, 'getNotificationSetting']); 


    Route::post('add-address', [UserController::class, 'addAddress']);  
    Route::get('get-address', [UserController::class, 'getAddress']);  
    Route::post('update-address', [UserController::class, 'updateAddress']);
    Route::post('delete-address', [UserController::class, 'deleteAddress']); 

    
    Route::get('app-introduction', [AuthController::class, 'getAppIntroduction']); 

    
 
});

Route::group([
    'middleware' => 'api',
], function ($router) {


    Route::post('staticpage-details', [UserController::class, 'getStaticpageDetails']); 
    Route::post('contact-us', [UserController::class, 'ContactUs']); 
    

    Route::get('get-banner', [EventController::class, 'getBanner']);  
    Route::post('banner-details', [EventController::class, 'getBannerDetails']); 
 

    Route::get('get-services', [EventController::class, 'getServices']); 
    Route::post('service-details', [EventController::class, 'getServiceDetails']); 


    Route::get('get-benefits', [EventController::class, 'getBenefits']); 
    Route::post('benefit-details', [EventController::class, 'getBenefitDetails']); 
    
    Route::get('get-newsletter', [EventController::class, 'getNewsletter']); 
    Route::post('newsletter-details', [EventController::class, 'getNewsletterDetails']); 
    
    Route::post('get-events', [EventController::class, 'getEvents']); 
    Route::post('event-details', [EventController::class, 'getEventDetails']); 

    Route::post('attend-notattend-event', [EventController::class, 'EventAttendNotattend']); 
    Route::post('get-attend-events', [EventController::class, 'getAttendEvents']); 
    Route::post('get-notattend-events', [EventController::class, 'getNotAttendEvents']); 

    
    Route::post('get-calendar-events', [EventController::class, 'getCalendarEvents']); 
    Route::post('get-calendar-event-details', [EventController::class, 'getCalendarEventDetails']); 

    Route::post('send-notification', [EventController::class, 'sendNotification']); 


    Route::get('get-faq', [EventController::class, 'getFaq']); 
    Route::post('faq-details', [EventController::class, 'getFaqDetails']); 
 

    Route::get('get-chambers-of-commerce', [EventController::class, 'getChambersOfCommerce']); 
    Route::post('chambers-of-commerce-details', [EventController::class, 'getChambersOfCommerceDetails']); 

    Route::get('get-official-document', [EventController::class, 'getOfficialDocument']); 
    Route::post('official-document-details', [EventController::class, 'getOfficialDocumentDetails']); 
    Route::post('official-document-upload', [EventController::class, 'OfficialDocumentUpload']); 


    Route::get('get-business-registration', [EventController::class, 'getBusinessRegistration']); 
    Route::post('business-registration-details', [EventController::class, 'getBusinessRegistrationDetails']); 
    Route::post('business-registration-upload', [EventController::class, 'BusinessRegistrationUpload']); 


    Route::get('get-career', [EventController::class, 'getCareer']); 
    Route::post('career-details', [EventController::class, 'getCareerDetails']); 
    
    Route::get('get-member-directory', [EventController::class, 'getMemberDirectory']); 
    Route::post('member-directory-details', [EventController::class, 'getMemberDirectoryDetails']); 


   
});