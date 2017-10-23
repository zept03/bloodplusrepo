<?php

use Illuminate\Http\Request;
use App\User;
use App\Log;

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
Route::post('testtt',function(Request $request) {
		$array = array();
		$hello = json_decode($request->input('params'));
		// for($i = 0; $i < 3; $i++)
		// {
		// 	array_push($array,$request->input('params'.$i));
		// 	echo $request->input('params'.$i)."<br>";
		// }
		return response()->json($hello);
	});

Route::group(['middleware' => 'preAuth'], function () {
	Route::post('register', 'Api\AuthenticationController@register');
	Route::post('login', 'Api\AuthenticationController@login');
	Route::get('/institutions','Api\InstitutionController@getInstitutions');
	Route::get('/campaigns','Api\CampaignController@getCampaigns');
	
	Route::get('/user/{user}','Api\SocialController@getUser');
	Route::get('/users','Api\SocialController@getUsers');
	Route::get('/post/{post}/comments','Api\CommentController@getComments');
	// Route::post('/user','Api\SocialController@searchUsers');
 	Route::group(['middleware' => 'auth:api'], function() {
 		Route::post('/users','Api\SocialController@getAllUsers');
 		Route::get('/following/retrieve','Api\SocialController@getFollowing');
 		Route::get('/followers/retrieve','Api\SocialController@getFollowers');
 		Route::post('/history','Api\HistoryController@getHistory');
 		Route::post('profile','Api\SocialController@profile');
 		Route::post('/follow/{user}','Api\SocialController@followUser');
 		Route::post('/unfollow/{user}','Api\SocialController@unFollowUser');
 		Route::post('/request/retrieve','Api\BloodRequestController@getOngoingBloodRequest');
 		Route::post('/request/{request}/donate','Api\BloodRequestController@donateToBloodRequest');
 		Route::post('/request/{request}/retrieve','Api\BloodRequestController@getSpecificBloodrequest');
 		Route::post('/donate/create','Api\DonateController@createDonateRequest');
 		Route::post('/request/create','Api\BloodRequestController@createBloodRequest');
 		Route::post('/donate/retrieve','Api\DonateController@getDonateRequest');
 		Route::post('/campaign/join/{campaign}','Api\CampaignController@joinCampaign');
 		Route::post('/campaigns/retrieve','Api\CampaignController@retrieveCampaigns');
		Route::post('/campaign/{campaign}','Api\CampaignController@getSpecificCampaign');
		Route::post('/posts/retrieve','Api\PostController@getAllPost');
 		Route::post('/post/{post}/react','Api\SocialController@react');
    	Route::post('/post/{post}/unreact','Api\SocialController@unReact');
    	Route::post('/post/{post}/comment/create','Api\CommentController@createComment');
    	Route::post('/notifications','Api\NotificationsController@getNotifications');
    
		Route::post('/test',function(Request $request) {
		// dd($request->input());	
	 	Log::create(['action' => 'Someone just went to: post /test']);
	 	$user = Auth::guard('api')->user();
	 	return response()->json(['user' => $user,'inputs' => $request->input()]);
 		});
 		Route::get('/test',function(Request $request) {
	 	Log::create(['action' => 'Someone just went to: get /test']);
	 	$user = Auth::guard('api')->user();
	 	return response()->json(Array($user,$request->input()));
	 	}); 
 	});
});