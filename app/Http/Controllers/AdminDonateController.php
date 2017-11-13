<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\DonateRequest;
use App\Blacklist;
use Auth;
use App\Notifications\BloodRequestNotification;
use App\Post;
use App\Log;
use App\BloodType;
use \DB;
use App\BloodInventory;
use App\ScreenedBlood;


class AdminDonateController extends Controller
{

    public function donate()
    {
   		$id = Auth::guard('web_admin')->user()->institute->id;

        $donor_requests = DonateRequest::where('institution_id',$id)->where(function($query) 
        {
            $query->whereIn('status',['Ongoing','Pending'])->whereDate('appointment_time', '!=',DB::raw('CURDATE()'));
        })->orderBy('appointment_time')->get();
        // dd($donor_requests);
        $todayRequests = DonateRequest::where('institution_id',$id)->where(function ($query) {
            $query->whereIn('status',['Pending','Ongoing'])->whereNull('appointment_time');
        })->orWhere(function ($query) {
            $query->whereIn('status',['Pending','Ongoing'])->whereDate('appointment_time',DB::raw('CURDATE()'));
        })->orderBy('appointment_time')->get();
        // dd($todayRequests);
        $doneRequests = DonateRequest::where('institution_id',$id)->where('status','Done')->get();
        $cancelledRequests = DonateRequest::where('institution_id',$id)->where('status','Declined')->get();

        // dd($donor_requests);
    	return view('admin.donate',compact('donor_requests','todayRequests','doneRequests','cancelledRequests','donor_requests'));
    }

    public function setAppointment(Request $request)
    {
        // dd($request->input());
        // $hourmin = explode(':' ,$request->input('donatetime'));
        // $hour = $hourmin[0];
        // $min = $hourmin[1];
        // dd($hourmin);
        $appointmentTime = new Carbon($request->input('donatedate').' '.$request->input('donatetime'));
        // dd($appointment_time);
        $donateRequest = DonateRequest::find($request->input('id'));
    	// $donateRequest = DonateRequest::firstOrFail();

        $updates = $donateRequest->updates;
        //change to carbon time 09:00 AM/PM;
        $updates[] = "Changed blood donation appointment time to ".$appointmentTime->format('h:i A').".";
        // change status to ongoing
        $donateRequest->update([
            'appointment_time' => $appointmentTime,
            'status' => 'Ongoing',
            'updates' => $updates]);
        // dd($donateRequest);
    	// notify user;
    	return redirect('/admin/donate')->with('status','Sent notification to user for the change of time');
    }

    public function acceptRequest(Request $request, DonateRequest $donateRequest)
    {
        $donateRequest = DonateRequest::find($request->input('id'));
        // dd($donateRequest);
        $updates = $donateRequest->updates;
        // dd($updates);
        $updates[] = "Philippine Red Cross accepted your blood donation request.";
        // dd($updates);
        $donateRequest->update([
            'status' => 'Ongoing',
            'updates' => $updates]);
        $donateRequest->bloodrequest()->update([
        'status' => 'Ongoing']);
        Log::create([
            'initiated_id' => Auth::guard('web_admin')->user()->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\DonateRequest',
            'reference_id' => $donateRequest->id,
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You have accepted a voluntary blood donation'
            ]);
        $user = $donateRequest->user;
        $class = array("class" => "App\DonateRequest",
            "id" => $donateRequest->id,
            "time" => $donateRequest->created_at->toDateTimeString());
        $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());

        $user->notify(new BloodRequestNotification($class,$usersent,'We have just accepted your donation request. See you soon!'));

        // dd($donateRequest->updates);
        return redirect('/admin/donate')->with('status','Successfully accepted request');
    }

    public function declineRequest(Request $request)
    {
        // dd($request->input());
        $donateRequest = DonateRequest::find($request->input('id'));
        if($donateRequest)
        {
            // dd($donateRequest);

            $updates = $donateRequest->updates;
            $updates[] = "Declined the donation request.";
            $donateRequest->update([
                'reason' => $request->input('message'),
                'status' => 'Declined',
                'updates' => $updates]);
            if($request->input('blacklist') == 'true')
            {
                $blacklist = Blacklist::create([
                    'user_id' => $donateRequest->user->id,
                    'reason' => $request->input('message'),
                    'status' => 'Active'
                    ]);
                // dd($blacklist);
            }
            // dd('12345');
            //log
            Log::create([
            'initiated_id' => Auth::guard('web_admin')->user()->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\DonateRequest',
            'reference_id' => $donateRequest->id,
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You have declined a donate request'
            ]);
            $user = $donateRequest->user;
            $class = array("class" => "App\DonateRequest",
                "id" => $donateRequest->id,
                "time" => $donateRequest->created_at->toDateTimeString());
            $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                    "picture" => Auth::guard('web_admin')->user()->institute->picture());

            $user->notify(new BloodRequestNotification($class,$usersent,'We have declined your donation request.'));
        }

        return redirect('/admin/donate')->with('status','Successfully declined the donation request');

    }
    public function getDonationRequest(Request $request, DonateRequest $request)
    {
        //show interview questions

        //terms and agreement

        //
    }

    public function completeDonateRequestView(Request $request, DonateRequest $donate)
    {
        return view('admin.completedonation',compact('donate'));
    }
    public function completeDonateRequest(Request $request, DonateRequest $donate)
    {
        $donateRequest = $donate;

        $validation = Validator::make($request->all(), [
            'serial_number' => 'required|max:255|unique:screened_bloods',
            ]);

        $validation->validate();
        $updates = $donateRequest->updates;
        $updates[] = "Completed your blood donation.";
        $donateRequest->update([
            'status' => 'Done',
            'updates' => $updates,
            'updated_at' => Carbon::now()
            ]);
        $donateRequest->bloodrequest()->update([
        'status' => 'Done',
        'updated_at' => Carbon::now()]);

        Post::create([
                    'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
                    'initiated_id' => $donateRequest->user->id,
                    'initiated_type' =>  'App\User',
                    'reference_type' => 'App\DonateRequest',
                    'reference_id' => $donateRequest->id,
                    'message' => 'I have just completed a voluntary blood donation. You should too!',
                    'picture' => asset('assets/img/posts/blood-donation.jpg')
                    ]);
        // // dd($donateRequest);
        Log::create([
            'initiated_id' => $donateRequest->user->id,
            'initiated_type' => 'App\User',
            'reference_id' => $donateRequest->id,
            'reference_type' => 'App\DonateRequest',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You have succefully finished your blood donation'
            ]);

        Log::create([
            'initiated_id' => Auth::guard('web_admin')->user()->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_id' => $donateRequest->id,
            'reference_type' => 'App\DonateRequest',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You have completed a voluntary  blood donation'
            ]);
        
        $user = $donateRequest->user;
        $class = array("class" => "App\DonateRequest",
            "id" => $donateRequest->id,
            "time" => $donateRequest->created_at->toDateTimeString());
        $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());

        $user->notify(new BloodRequestNotification($class,$usersent,'We have completed your blood donation. Thank you for donating.'));
        
        // stage the bags

        $screenedBlood = ScreenedBlood::create([
        'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
        'donate_id' => $donateRequest->id,
        'serial_number' => $request->input('serial_number'),
        'bag_type' => $request->input('bag_type'),
        'bag_component' => $request->input('bag_component'),
        'status' => 'Pending'
        ]);

        return redirect('/admin/bloodbags')->with('status','You successfully completed the blood donation. You can now begin to screen the blood bag');

    }    //
    public function acceptDonationRequestView(Request $request, DonateRequest $donate)
    {
        //if dli karon na donation, accept lng dayon 
        //return view to admin/donate with notification
 
        return view('admin.acceptdonation',compact('donate'));
    }

    public function acceptDonationRequest(Request $request, DonateRequest $donate)
    {

    }

}

