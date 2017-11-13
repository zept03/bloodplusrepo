<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\BloodRequest;
use App\phpSerial;
use App\User;
use App\DonateRequest;
use App\Jobs\SendTextBlast;
use Illuminate\Console\Command;
use Artisan;
use Auth;
use App\Notifications\BloodRequestNotification;
use App\donorstemp;
use Carbon\Carbon;
use App\Post;
use App\Log;
use App\Campaign;
use App\BloodInventory;

class AdminController extends Controller
{
    

    public function index()
    {
        //get new donors since last week.
        $nxt = new Carbon('last sunday');
        // dd($nxt->toDateTimeString());
        $newlyDonors = count(Auth::guard('web_admin')->user()->institute->newlyFollowedInstitutions);
        // dd($newlyDonors);
        $bloodDonors = count(User::where('status','active')->get());
        $campaignCount = count(Campaign::where('status','Done')->get());
        $logs = Log::where('initiated_id',Auth::guard('web_admin')->user()->id)->orderBy('created_at','desc')->paginate(10);

    	return view('admin.dashboard',compact('logs','campaignCount','newlyDonors','nxt'));
    }

    public function request() {

        $id = Auth::guard('web_admin')->user()->institute->id;

        $requests = BloodRequest::with(['details','user' => function ($query) {
        }])->where('institution_id',$id)->orderBy('created_at')->get();
        $ongoingRequests = BloodRequest::with([
            'donors' => function ($query) {
                $query->where('status','Ongoing');
            }])->where('institution_id',$id)->where('status', 'Ongoing')->orderBy('created_at')->get();
        
        // dd($requests);
    	return view('admin.request',compact('requests','ongoingRequests'));
    }

    public function donors() {
        $tmpDonors = Auth::guard('web_admin')->user()->institute->followers;
        $donors = array();
        $count = 0;
        // dd($donors);
        foreach($tmpDonors as $donor)
        {
            // dd($donor->name());
            $donors[$count]['id'] = $donor->id;
            $donors[$count]['blood_type'] = $donor->bloodType;
            $donors[$count]['name'] = $donor->name();
            $donors[$count]['gender'] =  $donor->gender;
            $donors[$count]['contact'] = '0'.$donor->contactinfo;
            $donors[$count]['email'] = $donor->email;
            $donors[$count]['joinDate'] = $donor->pivot->created_at->format('F d Y');

            $lastRequest = DonateRequest::where('status','Done')->where('initiated_by',$donor->id)->orderBy('appointment_time','desc')->first();
            if($lastRequest)
            {
                if($lastRequest->appointment_time)
                {
                    $donors[$count]['last'] = $lastRequest->appointment_time->format('F d Y');
                    $date = $lastRequest->appointment_time;
                }
                else
                {
                    $donors[$count]['last'] = $lastRequest->created_at->format('F d Y');
                    $date = $lastRequest->created_at;
                }
            $now = Carbon::now();
            if($date->addDays(90) >= $now)
                {
                    $donors[$count]['eligible'] = 'No';
                }
            else
                {
                    $donors[$count]['eligible'] = 'Yes';
                }
            }
            else
            {
            $donors[$count]['last'] = '';
            $ongoingRequest = DonateRequest::where('initiated_by',$donor->id)->whereIn('status',['Pending','Ongoing'])->get();
            if(count($ongoingRequest) > 0) 
                {
                    $donors[$count]['eligible'] = 'No';
                }
            else
                {
                    $donors[$count]['eligible'] = 'Yes';
                }
            }
            $count++;
        }

        // dd($donors);
        return view('admin.donor',compact('donors'));
    }
    public function pendingRequests() {

    	$id = Auth::guard('web_admin')->user()->institute->id;

    	$requests = BloodRequest::with(['details','user' => function ($query) {
            
    	}])->where('institution_id',$id)->get();
        // dd($requests);
    	return $requests;
    }

    public function viewRequest(Request $request)
    {
        // dd(BloodRequest::with('details','user')->find($request->input('id'))->updates);
        return BloodRequest::with('details','user')->find($request->input('id'));

    }

    public function updateToActive(Request $request)
    {
        $bloodRequest = BloodRequest::find($request->input('id'));
        // $this->sendTextBlast($bloodRequest);
        $updates = $bloodRequest->updates;              
        $updates[] = 'The request has been accepted and notified to eligible donors.';    
        $bloodRequest->update([
            'status' => 'Ongoing',
            'updates' => $updates
            ]);

        if($bloodRequest->details->blood_type == 'AB+')
            $picture = asset('assets/img/bloodtype/ab+.jpg');
        else if($bloodRequest->details->blood_type == 'AB-')
            $picture = asset('assets/img/bloodtype/ab-.jpg');
        else if($bloodRequest->details->blood_type == 'A-')
            $picture = asset('assets/img/bloodtype/a-.jpg');
        else if($bloodRequest->details->blood_type == 'A+')
            $picture = asset('assets/img/bloodtype/a+.jpg');
        else if($bloodRequest->details->blood_type == 'B-')
            $picture = asset('assets/img/bloodtype/b-.jpg');
        else if($bloodRequest->details->blood_type == 'B+')
            $picture = asset('assets/img/bloodtype/b+.jpg');
        else if($bloodRequest->details->blood_type == 'O-')
            $picture = asset('assets/img/bloodtype/O-.jpg');
        else if($bloodRequest->details->blood_type == 'O+')
            $picture = asset('assets/img/bloodtype/O+.jpg');

        // dd($picture);
        $post = Post::create([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'Someone is in need of blood heroes!.',
            'picture' => $picture,
            'initiated_id' => Auth::guard('web_admin')->user()->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\BloodRequest',
            'reference_id' => $bloodRequest->id
            ]);
        Log::create([
            'initiated_id' => Auth::guard('web_admin')->user()->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\BloodRequest',
            'reference_id' => $bloodRequest->id,
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => Auth::guard('web_admin')->user()->institute->name().' just accepted a blood request!'
            ]);
        // dd('12345');
        $user = $bloodRequest->user;
        $class = array("class" => "App\BloodRequest",
            "id" => $bloodRequest->id,
            "time" => $bloodRequest->created_at->toDateTimeString());
        $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());

        $user->notify(new BloodRequestNotification($class,$usersent,'We have just accepted your request and broadcasted to eligible donors.'));
        
        // notify uban donors
        $sameBloodTypeUsers = User::with(['donations' => function ($query) {
        //latest niyang donation that is not cancelled
            $query->where('status','!=','Cancelled')->orderBy('created_at','desc')->first();
        }])->whereHas('followedInstitutions', function($query) {
            $query->where('id',Auth::guard('web_admin')->user()->institution_id);
        })->where('bloodType','B+')->get();

        foreach($sameBloodTypeUsers as $user)
        {
            if($user->id != $bloodRequest->initiated_by)
            {
            if(count($user->donations) != 0)
            {
                if($user->donations->first()->status == 'Done')
                {
                    $date = $user->donations->first()->appointment_time;
                    $now = Carbon::now();
                    if($date->addDays(90) >= $now)
                    {
                        $user->notify(new BloodRequestNotification($class,$usersent, 'Someone is in need of your blood. Please donate to Philippine Red Cross.'));
                    }
                }
                else
                {
                    $user->notify(new BloodRequestNotification($class,$usersent,'Someone is in need of your blood. Please donate to Philippine Red Cross'));
                }
            }
            else
            {
                $user->notify(new BloodRequestNotification($class,$usersent,'Someone is in need of your blood. Please donate to Philippine Red Cross'));
            }
            }
        }

        //textblast here 

        return redirect('/admin/request')->with('status', 'Request successfully accepted. Notified eligible donors!');
    }

    public function claimRequest(Request $request)
    {
        // dd(Carbon::now()->toDateTimeString());
        // return response()->json($request->input());
        $bloodRequest = BloodRequest::find($request->input('acceptId'));
        $user = $bloodRequest->user;
        $class = array("class" => "App\BloodRequest",
            "id" => $bloodRequest->id,
            "time" => Carbon::now()->toDateTimeString());
        $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());

        $user->notify(new BloodRequestNotification($class,$usersent,'Your blood bags are ready to be claimed. Please come as soon as possible.'));
        return response()->json(['status' => 'User successfully notified!']);
    }

    public function showCompleteRequest(Request $request, BloodRequest $bloodRequest)
    {
        if($bloodRequest->status == "Done" || $bloodRequest->status == "Declined")
        {
            return redirect("admin/request");            
        }
        $availBloods = $bloodRequest->details->bloodType->nonReactive();
        return view('admin.completerequestform',compact('bloodRequest','availBloods'));
    }
    public function updateToDone(Request $request, BloodRequest $bloodRequest)
    {
        // dd($request->input('serial'));
        // $bloodRequest = BloodRequest::find($request->input('id'));
        $updates = $bloodRequest->updates;              
        $updates[] = 'The blood request is completed and finished';   
         
        $bloodRequest->update([
            'status' => 'Done',
            'updates' => $updates
            ]);
        $bloodRequest->details()->update(['status' => 'Done']);
        //if the blood request has call to arms
        //$post = Post::create([
        //     'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
        //     'message' => 'A hero just saved someone someone someone',
        //     'picture' => asset('assets/img/posts/blood-donation.jpg'),
        //     'initiated_id' => Auth::guard('web_admin')->user()->id,
        //     'initiated_type' => 'App\InstitutionAdmin',
        //     'reference_type' => 'App\BloodRequest',
        //     'reference_id' => $bloodRequest->id
        //     ]);

        Log::create([
            'initiated_id' => $bloodRequest->user->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\BloodRequest',
            'reference_id' => $bloodRequest->id,
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just succesfully completed a blood request transaction!'
            ]);


        //get blood bag given the blood bag serial number
        // make it used 
        // $bloodBag = $bloodRequest->details->bloodType;
        // $bloodBag->update(['qty' => $bloodBag->qty - $bloodRequest->details->units]);

        $user = $bloodRequest->user;
        $class = array("class" => "App\BloodRequest",
            "id" => $bloodRequest->id,
            "time" => $bloodRequest->created_at->toDateTimeString());
        $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());

        $user->notify(new BloodRequestNotification($class,$usersent,'We have completed your blood request.'));

        BloodInventory::whereIn('id',$request->input('serial'))
        ->update([
            'status' => 'Sold',
            'br_detail_id' => $bloodRequest->details->id,
            ]);

        // $hero = $bloodRequest->user;
        // dispatch(new SendTextBlast($hero,$message)); 

        return redirect('/admin/request')->with('status', 'Request successfully completed!');
    }

    public function deleteRequest(Request $request)
    {
        $bloodRequest = BloodRequest::find($request->input('id'));
        // dd($request->input());
        $updates = $bloodRequest->updates;
        $updates[] = $bloodRequest->institute->name().' has declined your blood request';
        // dd($updates);
        $bloodRequest->update([
            'status' => 'Declined',
            'reason' => $request->input('message'),
            'updates' => $updates
            ]);

        Log::create([
            'initiated_id' => Auth::guard('web_admin')->user()->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\BloodRequest',
            'reference_id' => $bloodRequest->id,
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just declined a blood request!'
            ]);
        $hero = $bloodRequest->user;
        $message="Hi! Your blood request has been declined. For the reason of: ".$request->input('message');
        $class = array("class" => "App\BloodRequest",
            "id" => $bloodRequest->id,
            "time" => $bloodRequest->created_at->toDateTimeString());
        $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());

        $hero->notify(new BloodRequestNotification($class,$usersent,'We have declined your blood request.'));
        // dispatch(new SendTextBlast($hero,$message));
        return redirect('/admin/request')->with('status', 'Request successfully declined!');
    }

    public function sendTextBlast(Bloodrequest $request)
    {      
        $message = "Hi Hero! Somebody is in need of your ".$request->details->blood_type." blood. If you are willing and able to donate, please go to the Philippines Red Cross in Fuente and donate there."."Your blood will be donated to request id ".$request->uuid.". Thank you.";

        //retrieve donors with same blood type
        $heroes= User::where('bloodType',$request->details->blood_type)->get();
        //sort donors to those na maka donate lang(if previous donor d sa pwde);
        if($heroes->isEmpty())
            return redirect('/admin/request')->with('status', 'No available donors!');
        else{
            
        foreach($heroes as $hero)
        {
            dispatch(new SendTextBlast($hero,$message));
            // event(new DonorsTextBlasted($hero,$message));
        }
        }
    }
    public function sendMessage(Request $request)
    {
        //claim na ta ni.
        $bloodRequest = BloodRequest::find($request->input('id'));
        // $hero = $bloodRequest->user;
        // $message = $request->input('message');
        // dispatch(new SendTextBlast($hero,$message));
        $updates = $bloodRequest->updates;
        $updates[] = 'The request has been accepted and your blood is ready to be claimed';
        $bloodRequest->update([
            'status' => 'Done',
            'updates' => $updates
            ]);

        // if($bloodRequest->details->blood_type == 'AB+')
        //     $picture = asset('assets/img/bloodtype/ab+.jpg');
        // else if($bloodRequest->details->blood_type == 'AB-')
        //     $picture = asset('assets/img/bloodtype/ab-.jpg');
        // else if($bloodRequest->details->blood_type == 'A-')
        //     $picture = asset('assets/img/bloodtype/a-.jpg');
        // else if($bloodRequest->details->blood_type == 'A+')
        //     $picture = asset('assets/img/bloodtype/a+.jpg');
        // else if($bloodRequest->details->blood_type == 'B-')
        //     $picture = asset('assets/img/bloodtype/b-.jpg');
        // else if($bloodRequest->details->blood_type == 'B+')
        //     $picture = asset('assets/img/bloodtype/b+.jpg');
        // else if($bloodRequest->details->blood_type == 'O-')
        //     $picture = asset('assets/img/bloodtype/o-.jpg');
        // else if($bloodRequest->details->blood_type == 'O+')
        //     $picture = asset('assets/img/bloodtype/o+.jpg');
        // ??? if naa bay dugo, required ba mu post.
        // $post = Post::create([
        //     'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
        //     'message' => 'Someone is in need of blood my lords and ladies.',
        //     'picture' => $picture,
        //     'initiated_id' => Auth::guard('web_admin')->user()->id,
        //     'initiated_type' => 'App\InstitutionAdmin',
        //     'reference_type' => 'App\BloodRequest',
        //     'reference_id' => $bloodRequest->id
        //     ]);
        // if($bloodRequest->details->units >= $bloodRequest->details->bloodBag->qty)
        // {
        //     $bloodBag = $bloodRequest->details->bloodBag;
        //     $bloodBag->update(['qty' => $bloodBag->qty - $bloodRequest->details->units]);
        // }


        Log::create([   
            'initiated_id' => Auth::guard('web_admin')->user()->id,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\BloodRequest',
            'reference_id' => $bloodRequest->id,
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just accepted and completed a blood request!'
            ]);
        $user = $bloodRequest->user;
        $class = array("class" => "App\BloodRequest",
            "id" => $bloodRequest->id,
            "time" => $bloodRequest->created_at->toDateTimeString());

        $usersent = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());

        $user->notify(new BloodRequestNotification($class,$usersent,'We have just accepted your blood request. The blood is ready to be claimed'));
        return redirect('/admin/request')->with('status', 'Successfully sent message!');
    }
    public function notifyViaText(Request $request)
    {
        $var = $request->input('donorsArray');
        $users = User::whereIn('id',$var)->get();
        $message = $request->input('msg');
        foreach($users as $user)
        {
            dispatch(new SendTextBlast($user,$message));
        }
        return response()->json(Array('status' => 'OK'));
    }
    
}
