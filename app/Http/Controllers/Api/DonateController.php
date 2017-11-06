<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DonateRequest;
use Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Log;

class DonateController extends Controller
{
	    //create donate request
	public function createDonateRequest(Request $request)
	{
		// dd(Auth::user()->id);
		if(!DonateRequest::where('initiated_by',Auth::user()->id)->where(function ($query) {
            $query->where('status','Pending')->orWhere('status','Ongoing');
        })->with('institute')->first())
    	{
	    	$validator = Validator::make($request->all(), [
	            'institution_id' => 'required',	
	            'donatedate' => 'required|date|after:yesterday',
	            'donatetime' => 'required|date_format:H:i',
	        ]);

	        if($validator->fails()) {
            $message = $validator->messages();
            return response()->json($message);
        }
	        //'id','user_id','appointment_time','institution_id','status'
	        $appointment_time = new Carbon($request->input('donatedate').' '.$request->input('donatetime'));
	        // dd(Auth::user()->id);
			// dd($appointment_time->format(' jS \\of F Y')); 
	        $donateRequest = DonateRequest::create([
	            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
	            'institution_id' => $request->input('institution_id'),
	            'initiated_by' => Auth::user()->id,
	            'appointment_time' => $appointment_time,
	            'status' => 'Pending'
	        ]);

	        if($donateRequest)
	        {
		        Log::create([
		            'initiated_id' => Auth::user()->id,
		            'initiated_type' => 'App\User',
		            'reference_id' => $donateRequest->id,
		            'reference_type' => 'App\DonateRequest',
		            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
		            'message' => 'You initiated a voluntary blood donation'
	            ]);
		        
		        return response()->json(array('donateRequest' => $donateRequest,
		        	'status' => 'Successful',
		        	'message' => 'You have initiated a voluntary donation!'));

	        }
        	else  
        	{  	
        		return response()->json(array('status' => 'Error','message' => 'Error Error Error'));
			}
		}
		else
		{
			return response()->json(array('status' => 'Error','message' => 'Ongoing Request'));
		}		
	}
    //retrieve ongoing voluntary donation
	public function getDonateRequest()
	{
		$donateRequest = DonateRequest::with('institute')->where('initiated_by',Auth::user()->id)->where(function ($query) {
			$query->where('status','Pending')->orWhere('status','Ongoing');
		})->with('institute')->first();
		if($donateRequest)
   		return response()->json([
   			'donateRequest' => $donateRequest,
            'status' => 'Successful',
   			'message' => 'Successfully retrieved ongoing volluntary donation request'
   			]);
   		else
   		return response()->json([
   			'donateRequest' => null,
            'status' => 'Error Error',
   			'message' => 'You have no ongoing blood request'
   			]);
	}
}
