<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\DonateRequest;
use Auth;
use App\Notifications\BloodRequestNotification;
use App\Post;
use App\Log;
use App\BloodType;
class AdminDonateController extends Controller
{

    public function donate()
    {
   		$id = Auth::guard('web_admin')->user()->institute->id;

        $donor_requests = DonateRequest::where('institution_id',$id)->orderBy('appointment_time')->get();

        // dd($donor_requests);
    	return view('admin.donate',compact('donor_requests'));
    }

    public function setAppointment(Request $request)
    {
        $hourmin = explode(':' ,$request->input('donatetime'));
        $hour = $hourmin[0];
        $min = $hourmin[1];
        // dd($hourmin);
        $appointmentTime = Carbon::createFromTime($hour, $min)->toDateTimeString();

        $donateRequest = DonateRequest::find($request->input('id'));
    	// $donateRequest = DonateRequest::firstOrFail();

        $updates = $donateRequest->updates;
        //change to carbon time 09:00 AM/PM;
        $updates[] = "Changed blood donation appointment time to ".(new Carbon($appointmentTime))->format('h:i A').".";
        // change status to ongoing
        $donateRequest->update([
            'appointment_time' => $appointmentTime,
            'status' => 'Ongoing',
            'updates' => $updates]);
        // dd($donateRequest);
    	// notify user;
    	return redirect('/admin/donate')->with('status','Sent notification to user for the change of time');
    }

    public function acceptRequest(Request $request)
    {
        $donateRequest = DonateRequest::find($request->input('id'));
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
    public function completeDonateRequest(Request $request)
    {
        // dd($request);
        $donateRequest = DonateRequest::find($request->input('id'));
        // dd($donateRequest->user);
        // $donateRequest = DonateRequest::firstOrFail();
        $updates = $donateRequest->updates;
        $updates[] = "Completed your blood donation.";
        $donateRequest->update([
            'status' => 'Done',
            'updates' => $updates
            ]);
        $donateRequest->bloodrequest()->update([
        'status' => 'Done']);
        // //post create

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
        
        // //increase inventory of blood
        $bloodType = BloodType::where('name', $donateRequest->user->bloodType)->first();
        foreach($bloodType->bloodBags as $bloodBag)
        {
            $qty = $bloodBag->qty;
            $bloodBag->update(['qty' => $qty + 1]);
        }

        return redirect('/admin/donate')->with('status','Successfully you completed donate request');

    }

    public function declineRequest(Request $request)
    {
        $donateRequest = DonateRequest::find($request->input('id'));
        if($donateRequest)
        {
            // dd($donateRequest);

            $updates = $donateRequest->updates;
            $updates[] = "Declined the donation request.";
            $donateRequest->update([
                'status' => 'Declined',
                'updates' => $updates]);

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

    //
}
