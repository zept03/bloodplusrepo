<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\BloodRequest;
use App\DonateRequest;
use App\Log;
use App\Post;
use Auth;
use App\BloodRequestDetail;
use App\BloodCategory;
use App\BloodType;
use Carbon\Carbon;
use App\InstitutionAdmin;
use App\BloodRequestDonor;
use App\Notifications\BloodRequestNotification;


class BloodRequestController extends Controller
{
    
	public function createBloodRequest(Request $request)
    {
        if(!BloodRequest::where('initiated_by',Auth::guard('api')->user()->id)->where(function ($query) {
            $query->where('status','Pending')->orWhere('status','Ongoing');
        })->first())
        {
        $validator = Validator::make($request->all(), [
            'pname' => 'required|string|max:255',
            'institution_id' => 'required|string',
            'diagnose' => 'required|string|max:255',
            'units' => 'required|integer|min:0',
            'bloodType' => 'required',
            'bloodCategory' => 'required'
            ]);
        if($validator->fails()) {
            $message = $validator->messages();
            return response()->json($message);
        }
        // $name = $request->input('bloodType');
        // // dd($request->input('bloodCategory'));
        // // dd($name);
        // // dd(BloodType::all()->first()->bloodCategory->first());
        // $bloodBag = BloodType::whereHas('bloodCategory', function ($query) use ($name)
        //     {
        //         $query->where('name',$name);
        //     })->where('category',$request->input('bloodCategory'))->first();
        // dd($bloodBag);
        $bloodRequest = BloodRequest::create([
            'id' => $str = strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'patient_name' => ucwords($request->input('pname')),
            'institution_id' => $request->input('institution_id'),
            'diagnose' => $request->input('diagnose'),
            'status' => 'Pending',
            'initiated_by' => Auth::user()->id
            ]);
        // dd($bloodRequest->id);

        $name = $request->input('bloodType');

        // dd($name);
        $bloodBag = BloodType::whereHas('bloodCategory', function ($query) use ($name)
            {
                $query->where('name',$name);
            })->where('category',$request->input('bloodCategory'))->first();
        // return response()->json($bloodBag);
        $bloodRequestDetail = BloodRequestDetail::create([
            'blood_request_id' => $bloodRequest->id,
            'blood_type' => $request->input('bloodType'),
            'bloodbag_id' => $bloodBag->id,
            'blood_category' => $request->input('bloodCategory'),
            'units' => $request->input('units'),
            'status' => 'Pending'
            ]);

        // dd($bloodBag);
        
        Log::create([
            'initiated_id' => Auth::user()->id,
            'initiated_type' => 'App\User',
            'reference_id' => $bloodRequest->id,
            'referece_type' => 'App\BloodRequest',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just requested for blood'
            ]);
        //notify
        $admins = InstitutionAdmin::where('institution_id',$request->input('institution_id'))->get();

        $class = array("class" => "App\BloodRequest",
            "id" => $bloodRequest->id,
            "time" => $bloodRequest->created_at->toDateTimeString());
        $user = array("name" => Auth::user()->name(),
                "picture" => Auth::user()->picture());
        $message = Auth::user()->name().' made a blood request!';
        foreach($admins as $admin)  
        {
            $admin->notify(new BloodRequestNotification($class,$user,$message));
        
        }
        return response()->json(array("bloodRequest"=>$bloodRequest->load(['institute','details']),
            "status" => 'Successful',
            "message" => 'Successfully created blood request'));
        }
        else
        {
            return response()->json(array("status" => 'Error',
                "message" => 'You already have an ongoing blood request'));
        }     
    }

    public function getOngoingBloodRequest() 
    {
   		$bloodRequest = BloodRequest::with(['institute','details'])->whereNotIn('status',['Done','Cancelled'])->where('initiated_by',Auth::user()->id)->first();  
   		if($bloodRequest)
   		return response()->json([
   			'bloodRequest' => $bloodRequest,
            'status' => 'Successful',
   			'message' => 'Successfully retrieved ongoing blood request'
   			]);
   		else
   		return response()->json([
   			'bloodRequest' => null,
            'status' => 'Error Error',
   			'message' => 'You have no ongoing blood request'
   			]);		

    }

    public function donateToBloodRequest(Request $req, BloodRequest $request)
    {
        $lastDonation = DonateRequest::where('initiated_by',Auth::user()->id)->where('status','Done')->latest()->first();
        if($lastDonation)
        {
            if($lastDonation->appointment_time)
            {
            $date = $lastDonation->appointment_time;
            }
            else
            $date = $lastDonation->created_at;
            $now = Carbon::now();
            // dd($date);
            if(!($date->addDays(90) >= $now))
            {
        
            }
            else
            {
               return response()->json(['donateRequest' => null,
                'status' => 'Error',    
                'message' => 'Cannot donate to this request2']);
            }
        }
        else
        {
            $ongoingDonation = DonateRequest::where('initiated_by',Auth::user()->id)->whereIn('status', ['Pending','Ongoing'])->first();
            if($ongoingDonation)
            {
                return response()->json(['donateRequest' => null,
                'status' => 'Error',    
                'message' => 'Cannot donate to this request3']);
            }
        }
        $donateRequest = DonateRequest::create([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'initiated_by' => Auth::user()->id,
            'institution_id' => $request->institution_id,
            'status' => 'Pending']);
        $brDonor = BloodRequestDonor::create([
            'blood_request_id' => $request->id,
            'donate_request_id' => $donateRequest->id,
            'status' => 'Pending'
            ]);

        $admins = InstitutionAdmin::where('institution_id',$request->institution_id)->get();
        $class = array("class" => 'App\DonateRequest',
        "id" => $donateRequest->id,
        "time" => $donateRequest->created_at->toDateTimeString());
        $user = array('name' => $donateRequest->user->name(),
            'picture' => $donateRequest->user->picture());
        $message = $donateRequest->user->name().' responded to a blood request.';
        foreach($admins as $admin)  
        {
            $admin->notify(new BloodRequestNotification($class,$user,$message));
        }
        Log::create([
        'initiated_id' => Auth::user()->id,
        'initiated_type' => 'App\User',
        'reference_id' => $donateRequest->id,
        'reference_type' => 'App\DonateRequest',
        'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
        'message' => 'You initiated a voluntary blood donation'
        ]);

        return response()->json(['donateRequest' => $donateRequest,
                'status' => 'Successful',
                'message' => 'Successfully responded to this blood request']);


    }

    public function getSpecificBloodRequest(BloodRequest $request)
    {
        if($request->user->id == Auth::user()->id)
        {
        $tmpReq = $request->load('details','user','institute');
        // dd($req);
        $req['id'] = $tmpReq->id;
        $req['patient_name'] = $tmpReq->patient_name;
        $req['status'] = $tmpReq->status;
        $req['diagnose'] = $tmpReq->diagnose;
        $req['updates'] = $tmpReq->updates;
        $req['details']['blood_type'] = $tmpReq->details->blood_type;
        $req['details']['blood_category'] = $tmpReq->details->blood_category;
        $req['details']['units'] = $tmpReq->details->units;
        $req['institution']['name'] = $tmpReq->institute->name();
        $req['institution']['address'] = $tmpReq->institute->address;
        return response()->json([
            'request' => $req,
            'message' => 'Successfully retrieved blood request',
            'status' => 'Successful']);
        }
        else
        {
            return response()->json([
                'request' => null,
                'message' => 'ERror error error',
                'status' => 'Error']);
        }
    }
    //notifications
}
