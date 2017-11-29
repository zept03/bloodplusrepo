<?php

use App\Log;
use App\Institution;
use App\InstitutionAdmin;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use App\User;
use App\BloodRequest;
use App\BloodRequestDetail;
use App\Post;
use App\Notifications\BloodRequestNotification;
use Carbon\Carbon;
// use FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use App\BloodType;
use App\BloodCategory;
use App\BloodInventory;
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
Route::get('/abcdefg',function (){

    // dd(Auth::user()->with(['followedInstitutions' => function ($query) {
        // $query->where('created_at')
    // }]));
    // $collection = BloodType::find('5B782AA')->nonReactive();
    // dd($collection);
    // dd(Auth::guard('web_admin')->user());
    
    
    // $sameBloodTypeUsers = User::with(['donations' => function ($query) {
    //     //latest niyang donation that is not cancelled
    //         $query->where('status','!=','Cancelled')->orderBy('created_at','desc')->first();
    //     }])->whereHas('followedInstitutions', function($query) {
    //         $query->where('id',Auth::guard('web_admin')->user()->institution_id);
    //     })->where('bloodType','B+')->get();

    // dd($sameBloodTypeUsers);
    // $exitCode = Artisan::call('queue:work');
    // $bloodType = BloodType::first();
    // dd($bloodType->bloodCategory);
    // $exitCode = Artisan::call('cache:clear');
    // dd(Carbon::now()->timezone('Asia/Manila')->toDateTimeString());
    // $optionBuilder = new OptionsBuilder();
    // $optionBuilder->setTimeToLive(60*20);
    // $notificationBuilder = new PayloadNotificationBuilder('my title');
    // $notificationBuilder->setBody('Hello world')
    //                     ->setSound('default');
    // $dataBuilder = new PayloadDataBuilder();
    // $dataBuilder->addData(['a_data' => 'my_data']);

    // $option = $optionBuilder->build();
    // $notification = $notificationBuilder->build();
    // $data = $dataBuilder->build();
    // $token = "123456789";

    // $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    // dd($downstreamResponse);
    // return response()->json($downstreamResponse);
    // $downstreamResponse->numberSuccess();
    // $downstreamResponse->numberFailure();
    // $downstreamResponse->numberModification();

    // //return Array - you must remove all this tokens in your database
    // $downstreamResponse->tokensToDelete(); 

    // //return Array (key : oldToken, value : new token - you must change the token in your database )
    // $downstreamResponse->tokensToModify(); 

    // //return Array - you should try to resend the message to the tokens in the array
    // $downstreamResponse->tokensToRetry();

    // $exitCode = Artisan::call('db:seed');
    // $exitCode = Artisan::call('config:cache');
    // $exitCode = Artisan::call('storage:link');
});
Route::get('/', function () {
    //return all blooddrequest na ongoing. orderby priority paginate 5
    $requests = BloodRequest::where('status','Ongoing')->get();
    $counter = 0;

    return view('landing.index',compact('requests','counter'));
});

Route::get('/whoweare', function () {

    return view('landing.whoweare');
});

Route::get('/whatwedo', function () {
    return view('landing.whatwedo');
});

Route::get('/contact', function () {
    return view('landing.contact');
});
Route::post('/sendinquiry', 'UserController@sendInquiry');

Auth::routes();

Route::get('/inventory', 'UserController@inventory');
Route::get('/verifyaccountscreen', function() {
    if(Auth::user()->verified == 1)
        return redirect('home');
    else
    return view('auth.verifyaccount');
});
Route::get('/unauthorize', function() {
    return view('auth.unauthorize');
});
Route::post('/resendtoken', function() {
        $user = Auth::user();
        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
        return Redirect::back()->with('status','Successfully resend verification link.');
    });
Route::get('notifications','BloodPlusController@getNotifications');
Route::get('notifications/unread','BloodPlusController@unreadNotifications');
Route::get('/notifications/{notification}','NotificationController@getNotification');


Route::group(['middleware' => ['auth']], function() {
    Route::group(['middleware' => 'verified'], function() {
    // Route::get('notifications','BloodPlusController@getNotifications');


    Route::post('/request', 'BloodPlusController@makeBloodRequest');
    Route::post('/request/{request}/donate','BloodPlusController@donateToBloodRequest');
    Route::get('/request/{request}','BloodPlusController@getRequest');
    Route::get('/home', 'BloodPlusController@index');
    Route::get('/request', 'BloodPlusController@request');
    Route::post('/request', 'BloodPlusController@makeBloodRequest');
    Route::get('/profile', 'BloodPlusController@showProfile');
    Route::get('/donate', 'UserDonateController@donate'); 
    Route::get('/donate/{donate}', 'UserDonateController@getDonateRequest'); 
    Route::post('/donate', 'UserDonateController@makeDonationRequest');
    Route::get('/campaign/{campaign}', 'BloodPlusController@getCampaign');
    Route::post('/request/{request}/cancel','BloodPlusController@cancelBloodRequest');
    Route::post('/donate/{request}/cancel','UserDonateController@cancelDonateRequest');
    Route::post('/user/{user}/changebanner','BloodPlusController@changeBanner');
    Route::post('/user/{user}/changepp','BloodPlusController@changePicture');
    
    //search users like name%
    Route::get('/user/searchajax','SocialController@searchUsersAjax');
    Route::get('/user/search','SocialController@searchUsers');


    //get user na iya gi clickan(view profile) 
    Route::get('/user/search/{user}','SocialController@getUser');
    
    Route::get('/user/{user}','SocialController@getUser');

    Route::post('/user/{user}/follow','SocialController@followUser');
    Route::post('/user/{user}/unfollow','SocialController@unFollowUser');
    Route::post('/post/{post}/react','SocialController@react');
    Route::post('/post/{post}/unreact','SocialController@unReact');



    });
});

// Route::get('/test','AdminDonateController@setAppointment');
Route::get('/upload', function() {
    return view('upload');
}); 
Route::post('/upload', function(Request $request) {
    // dd($request);
    $name = $request->file('avatar')->getClientOriginalName();
    $path = $request->file('avatar')->storeAs('avatars/profile',$name);
    $contents = Storage::url('avatars/'.$name);
    dd(asset(''));
    return view('/showupload',compact('path'));
});

// Route::get('/somethinggood', 'BloodPlusController@test');
Route::get('/verifyemail/{token}', 'BloodPlusController@verify');
// Route::get('/test','AdminController@test');

Route::prefix('admin')->group(function () {

	Route::group(['middleware' => 'admin_guest'], function() {
    Route::get('/register', 'AdminAuth\RegisterController@show');
    Route::post('/register', 'AdminAuth\RegisterController@register');
    Route::get('/reset','AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::post('/sendreset','AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/reset/{token}','AdminAuth\ResetPasswordController@showResetForm');
    Route::post('/reset','AdminAuth\ResetPasswordController@reset');
    Route::get('/login', 'AdminAuth\LoginController@show');
    Route::post('/login', 'AdminAuth\LoginController@login');

    //todos
    Route::get('/password/reset','AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::post('/password/email','AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('/password/reset/{token}','AdminAuth\ResetPasswordController@showResetForm');
    Route::post('/password/reset','AdminAuth\ResetPasswordController@reset');
	});
	
    Route::group(['middleware' => 'admin_auth'], function() {

    Route::post('/logout', 'AdminAuth\LoginController@logout');
    Route::get('/', 'AdminController@index');
    Route::get('/request','AdminController@request');
    Route::get('/donors','AdminController@donors');
    Route::get('/pendingrequests','AdminController@pendingRequests');
    Route::post('/request/view','AdminController@viewRequest');
    //send textblast to tanan available(meaning walay blood);
    Route::post('/request/accept','AdminController@updateToActive');
    
    Route::post('/request/delete','AdminController@deleteRequest');
    Route::post('/request/claim','AdminController@claimRequest');
    //reply to user for update dayon;
    Route::post('/request/reply','AdminController@sendMessage');
    Route::get('/request/{bloodRequest}/accept','AdminController@showCompleteRequest');
    Route::get('/request/{bloodRequest}/complete','AdminController@showCompleteRequest');
    Route::post('/request/{bloodRequest}/complete','AdminController@updateToDone');

    // Route::get('/sendTextBlast','AdminController@sendTextBlast');
    Route::post('/donors/notify','AdminController@notifyViaText');
    Route::get('/donate','AdminDonateController@donate');
    Route::post('/donate/accept','AdminDonateController@acceptRequest');
    Route::post('/donate/delete','AdminDonateController@declineRequest');
    Route::post('/donate/settime','AdminDonateController@setAppointment');
    Route::get('/campaign','AdminCampaignController@campaign');
    Route::post('/campaign/create','AdminCampaignController@createCampaign');
    Route::get('/campaign/create','AdminCampaignController@showCreate');
    Route::get('/campaign/{campaign}','AdminCampaignController@viewCampaign');  
    Route::get('/donate/{donate}/complete','AdminDonateController@completeDonateRequestView');
    Route::post('/donate/{donate}/complete','AdminDonateController@completeDonateRequest');
    Route::get('/donate/{donate}/view','AdminDonateController@getDonationRequest');
    // Route::get('/donate/{donate}/accept','AdminDonateController@acceptDonationRequestView');
    // Route::post('/donate/{donate}/accept','AdminDonateController@acceptRequest');


    Route::post('/request/{request}/bloodbag','AdminInventoryController@getBloodBagStatus');
    Route::get('/inventory','AdminInventoryController@index');
    Route::get('/bloodbags','AdminInventoryController@showBloodbags');

    Route::get('/bloodbags/{bloodbag}/screen','AdminInventoryController@showSingleStatustoStagedView');
    Route::post('/bloodbags/{bloodbag}/screen','AdminInventoryController@setSingleStatusToStaged');

    Route::get('/bloodbags/screen','AdminInventoryController@showStatustoStagedView');
    Route::post('/bloodbags/screen','AdminInventoryController@setStatusToStaged');

    Route::get('/bloodbags/stagedbloodbag','AdminInventoryController@showStagedBloodbags');
    //view sa staged single blood bag nga pending gipili
    Route::get('/bloodbags/{staged}/stage','AdminInventoryController@showSingleCompleteScreenedBlood');
    Route::post('/bloodbags/{staged}/stage','AdminInventoryController@completeSingleScreenedBlood');

    Route::get('/bloodbags/stage','AdminInventoryController@showCompleteScreenedBlood');
    Route::post('/bloodbags/stage','AdminInventoryController@completeScreenedBlood');

    });
});


Route::group(['prefix' => 'bpadmin', 'middleware' => 'bpadmin'], function () 
{
    Route::get('/', function () {
        return view('bpadmin.index');
    });
    Route::get('/institutions','Super\InstitutionsController@getInstitutions');

    //connected bloodbanks/status etc
    // Route::get('/','Super\SuperAdminController@index');
    //add bloodbank (with their credentials and then add 1 account)
       // Route::post('/bbank/create','Super\SuperAdminController@addBloodBank');
       // Route::post('/bbank/admin/create','Super\SuperAdminController@addInstitutionAdmin');

    //add another admin
        // Route::post('/sadmin/create','Super\SuperAdminController@addSuperAdmin');
});
