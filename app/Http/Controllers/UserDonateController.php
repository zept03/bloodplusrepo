<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\DonateRequest;
use App\Institution;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;
use App\InstitutionAdmin;
use App\Notifications\BloodRequestNotification;
use App\Log;

class UserDonateController extends Controller
{
    public function getDonateRequest($request)
    {
        dd(DonateRequest::find($request));
    }
    public function donate()
    {
        // select * from donaterequest where initiatedby = 1 and or
        // dd('abd');
    	$activeRequest = DonateRequest::where('initiated_by',Auth::user()->id)->where(function ($query) {
            $query->where('status','Pending')->orWhere('status','Ongoing');
        })->with('institute')->first();

        $institutions = Institution::all();    
        $activeRequest = null;
        $nextDonation = null;
        $historyRequest = null;
        // return view('user.donate',compact('institutions','activeRequest','historyRequest','nextDonation'));

        $historyRequest = DonateRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->get();
        if(!count($historyRequest))
            $historyRequest = null;

        $lastRequest = DonateRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->orderBy('appointment_time','desc')->first();
        // dd($lastRequest->user->id);
        if($lastRequest)
        {
        if($lastRequest->appointment_time)
        $date = $lastRequest->appointment_time;
        else
            $date = $lastRequest->created_at;
        $now = Carbon::now();
        if($date->addDays(90) >= $now)
            {
                // dd($lastRequest->appointment_time->addDays(90)->toDayDateTimeString());
                $nextDonation = clone $date;
                $monthLeft = $date->diffInMonths($now);
                $daysLeft = $date->subMonth($monthLeft)->diffInDays();
                // dd($nextDonation);
               return view('user.donate',compact('institutions','activeRequest','historyRequest','nextDonation','monthLeft','daysLeft'));         
            }
        }
        $nextDonation = null;
    	return view('user.donate',compact('institutions','activeRequest','historyRequest','nextDonation'));
    }

    public function makeDonationRequest(Request $request)
    {
    	// dd($request);
        // dd($request->input());
        // dd(Auth::user()->id);
    	if(!DonateRequest::where('initiated_by',Auth::user()->id)->where(function ($query) {
            $query->where('status','Pending')->orWhere('status','Ongoing');
        })->with('institute')->first())
    	{
    	$validation = Validator::make($request->all(), [
            'institution_id' => 'required',
            'donatedate' => 'required|date',
            'donatetime' => 'required|date_format:H:i',
            ]);

        $validation->validate();
        //'id','user_id','appointment_time','institution_id','status'
        $appointment_time = new Carbon($request->input('donatedate').' '.$request->input('donatetime'));
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
        $admins = InstitutionAdmin::where('institution_id',$request->input('institution_id'))->get();

        $class = array("class" => 'App\DonateRequest',
            "id" => $donateRequest->id,
            "time" => $donateRequest->created_at->toDateTimeString());
        $user = array('name' => $donateRequest->user->name(),
                'picture' => $donateRequest->user->picture());
        $message = $donateRequest->user->name().' just sent a blood request.';
        foreach($admins as $admin)
        {
            $admin->notify(new BloodRequestNotification($class,$user,'just send a donate request. Please accomodate immediately'));
        }
        return redirect('/donate')->with('status', 'Request successfully made. Please wait for confirmation from the Philippine Red Cross!');

        }
  //       else    	
        // return redirect('/donate')->with('status', 'Oops, there was an error processing your request. Please send the request again');
		}
		else
		{
		// 	// dd('went here');
			return redirect('/donate')->with('status', 'You already have a donation request ongoing.');
		}
		
    }

    public function cancelDonateRequest(DonateRequest $request)
    {
    	$request->update(['status' => 'Cancelled']);
        $request->bloodrequest()->update(['status' => 'Cancelled']);
        Log::create([
            'initiated_id' => Auth::user()->id,
            'initiated_type' => 'App\User',
            'reference_id' => $request->id,
            'reference_type' => 'App\DonateRequest',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just cancelled your donation.'
            ]);
        return redirect('/donate')->with('status', 'Successfully cancelled donation');
    }
}