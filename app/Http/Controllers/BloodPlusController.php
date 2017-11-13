<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BloodRequest;
use App\RequestDetails;
use App\Institution;
use App\InstitutionAdmin;
use App\BloodRequestDetail;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\BloodType;

use App\User;
use App\DonateRequest;
use App\Log;
use App\Post;
use App\Campaign;
use App\Notification;
use Carbon\Carbon;
use App\Notifications\BloodRequestNotification;
use App\BloodRequestDonor;

class BloodPlusController extends Controller
{

    public function index()
    {
        $tmpPosts = Auth::user()->posts;
        // dd($tmpPosts);
        $followers = Auth::user()->load(['followers.posts','followedUsers.posts','followedInstitutions.admins.posts']);
        // dd(Auth::user());
        // foreach(Auth::user()->followers as $follower)
        // {
        //     foreach($follower->posts as $post)
        //     $tmpPosts->push($post);
        //     // dd($follower->posts);
        // }
        foreach(Auth::user()->followedUsers as $follower)
        {
            foreach($follower->posts as $post)
            $tmpPosts->push($post);
            // $smth = $tmpPosts->intersect($follower->post);
            //ipang merge ang mga mapareho in respect sa posts sa user and his followers to the posts sa mga followed user
            // dd($follower->posts);
        }
        foreach(Auth::user()->followedInstitutions as $institution)
        {
            foreach($institution->admins as $admin)
            {
                foreach($admin->posts as $post)
                {
                    $tmpPosts->push($post);
                }
            }
        }
        // foreach
        // dd($smth);
        // $tmpPosts = $tmpPosts->intersect(Auth::user()->load(['followers']));
        $posts = array();
        $counter = 0;
        $sortedTmpPosts = $tmpPosts->sortByDesc('created_at');
        foreach($sortedTmpPosts as $tmpPost)
        {
            $posts[$counter]['id'] = $tmpPost->id;
            $posts[$counter]['class'] = substr($tmpPost->reference_type,4);
            $posts[$counter]['class_id'] = $tmpPost->reference_id;
            $posts[$counter]['userpic'] = $tmpPost->initiated->picture();
            $posts[$counter]['picture'] = $tmpPost->picture;
            $posts[$counter]['time'] = $tmpPost->created_at->diffForHumans(null,true);
            $posts[$counter]['message'] = $tmpPost->message;
            $posts[$counter]['count'] = count($tmpPost->likes);
            $posts[$counter]['liked'] = false;
                // dd($tmpPost->initiated->lname);
            if($tmpPost->initiated->lname)
                $posts[$counter]['name'] = $tmpPost->initiated->name();
            else
                $posts[$counter]['name'] = $tmpPost->initiated->institute->institution;
            foreach($tmpPost->likes as $reaction)
            {
                if($reaction->pivot->initiated_by == Auth::user()->id)
                    $posts[$counter]['liked'] = true;
            }
            $counter++;
        }
        // dd($tmpPosts->first()->likes);
    $pinnedPost = null;
        
        $onGoingDonation = DonateRequest::where('initiated_by',Auth::user()->id)->whereIn('status',['Pending','Ongoing'])->get();
        if(count($onGoingDonation) == 1)
        {

            return view('user.home',compact('posts','pinnedPost'));   
        }
        $pinnedPost = BloodRequest::with('details')->whereHas('details',function ($query) {
            $query->where('blood_type',Auth::user()->bloodType);
        })->where('status','Ongoing')->where('initiated_by','!=',Auth::user()->id)->first();
        if($pinnedPost)
        {
            if($pinnedPost->initiated_by == Auth::user()->id)
            {
                $pinnedPost = null;
                return view('user.home',compact('posts','pinnedPost'));   
            }
            $lastRequest = DonateRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->orderBy('appointment_time','desc')->first();
            if($lastRequest)
            {
                if($lastRequest->appointment_time)
                {
                    $date = $lastRequest->appointment_time;
                }
                else
                {
                    $date = $lastRequest->created_at;   
                }
                $now = Carbon::now();
                if(!($date->addDays(90) >= $now))
                    {
                        return view('user.home',compact('posts','pinnedPost'));

                    }
                else
                    {
                        $pinnedPost = null;
                        return view('user.home',compact('posts','pinnedPost'));
                        
                    }
            }
            else
            {
        	   return view('user.home',compact('posts','pinnedPost'));
            }
        }
        else
        {
            return view('user.home',compact('posts','pinnedPost'));    
        }
    }


    public function getCampaign(Campaign $campaign) {
        return view('user.campaign',compact('campaign'));
    }
    public function request(Request $request) 
    {
        $institutions = Institution::all();    
        $activeRequest = BloodRequest::where('initiated_by',Auth::user()->id)->where(function ($query) {
            $query->where('status','Pending')->orWhere('status','Ongoing');
        })->with('institute')->first();
        $historyRequest = BloodRequest::whereIn('status',['Declined','Done'])->where('initiated_by',Auth::user()->id)->get();
        if(!count($historyRequest))
            $historyRequest = null; 
        // dd($historyRequest);
    	return view('user.request',compact('institutions','activeRequest','historyRequest'));
    }

    public function makeBloodRequest(Request $request)
    {
        //validation
        // dd($request->input());

        // dd(BloodBag::where('category',$request->input('bloodCategory'))->get());
        // $tmpBloodType = $request->input('bloodType');
        if(!BloodRequest::where('initiated_by',Auth::user()->id)->where(function ($query) {
            $query->where('status','Pending')->orWhere('status','Ongoing');
        })->with('institute')->first())
        {
        $validation = Validator::make($request->all(), [
            'pname' => 'required|string|max:255',
            'institution_id' => 'required',
            'diagnose' => 'required|string|max:255',
            'units' => 'required|integer|min:0',
            'bloodType' => 'required',
            'bloodCategory' => 'required'
            ]);

        $validation->validate();
        $bloodRequest = BloodRequest::create([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'patient_name' => ucwords($request->input('pname')),
            'institution_id' => $request->input('institution_id'),
            'diagnose' => $request->input('diagnose'),
            'status' => 'Pending',
            'initiated_by' => Auth::user()->id
            ]);
        $admins = InstitutionAdmin::where('institution_id',$request->input('institution_id'))->get();

        $name = $request->input('bloodType');

        $bloodBag = BloodType::whereHas('bloodCategory', function ($query) use ($name)
            {
                $query->where('name',$name);
            })->where('category',$request->input('bloodCategory'))->first();
        // dd($bloodBag);
        $bloodRequestDetail = BloodRequestDetail::create([
            'blood_request_id' => $bloodRequest->id,
            'bloodbag_id' => $bloodBag->id,
            'blood_type' => $request->input('bloodType'),
            'blood_category' => $request->input('bloodCategory'),
            'units' => $request->input('units'),
            'status' => 'Pending'
            ]);

        $class = array("class" => 'App\BloodRequest',
            "id" => $bloodRequest->id,
            "time" => $bloodRequest->created_at->toDateTimeString());
            $user = array('name' => $bloodRequest->user->name(),
                'picture' => $bloodRequest->user->picture());
        $message = $bloodRequest->user->name().' just sent a blood request.';
        foreach($admins as $admin)  
        {
            $admin->notify(new BloodRequestNotification($class,$user,$message));
        }
        Log::create([
            'initiated_id' => Auth::user()->id,
            'initiated_type' => 'App\User',
            'reference_id' => $bloodRequest->id,
            'reference_type' => 'App\BloodRequest',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just requested for blood'
            ]);
    
        return redirect('/request')
        ->with('status', 'Request successfully made. Please proceed to Philippine Red Cross with your blood request form!');
        }
        else
        {
            return redirect('/request')
            ->with('status', 'You already have ongoing blood request!');
        }     
    }

    public function getRequest(BloodRequest $request) {
        dd($request);
        return BloodRequest::with('details','user')->find($request->input('id'));
    }
    public function showProfile() {
        $posts = Auth::user()->posts;
        if(!count($posts))
            $posts = null;
        // dd($posts);
        //campaigns

        // dd(User::all());   
        // dd(strtotime("now"));
        $followedUsers = Auth::user()->followedUsers; // akong gi follow nga users
        $followees = $followedUsers->merge(Auth::user()->followedInstitutions); // akong gi follow nga organizations
        $followers = Auth::user()->followers; // ang ga follow nako
    

        $mutuals = $followers->intersect($followedUsers);
        $notMutuals = $followers->diff($mutuals);
        $logs = Log::where('initiated_id',Auth::user()->id)->with('reference')->orderBy('created_at','desc')->paginate(10);
        $posts = Post::where('initiated_id',Auth::user()->id)->with('reference')->orderBy('created_at','desc')->get();
        
        // dd($logs);
        $donateCount = count(DonateRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->get());
        $requestCount = count(BloodRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->get());
        // dd($donateCount);
        $user = null;   
        // dd($notMutuals);

        if(count($mutuals) || count($notMutuals))
            $followers = true;
        else
            $followers = false;
        // dd($followees);
        return view('user.profile',compact('user','donateCount','logs','followees','mutuals','notMutuals','followers','posts','requestCount','donateCount'));
    }
    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->verified = 1;
        if($user->save())
        {
        return redirect('/login')->with(['status' => 'Account verified. Login now!']);
        }
    }

    public function test()
    {
        $users = User::all();
        foreach($users as $user)
        {
            // echo str_random(60)."<br>";
            // echo base64_encode($user->email.'kixgwapo')."<br>";
            echo $user->fname."<br>";
            $user->update(['api_token' => base64_encode($user->email.'kixgwapo')]);
            echo 'hello';
        }
    }

    public function changeBanner(Request $request, User $user)
    {
        $id = $user->id;
        $ext = \File::extension($request->file('banner-input')->getClientOriginalName()); 
        $path = $request->file('banner-input')->storeAs('avatars/banner',$id.'.'.$ext); 
        $picture = asset('/storage/'.$path);
        $user->update([
            'banner' => $picture
            ]);
        // dd($user);
        // dd($request);
        return redirect('/profile');
    }
    public function changePicture(Request $request, User $user)
    {
        $id = $user->id;
        $ext = \File::extension($request->file('profile-input')->getClientOriginalName());
        // dd($ext); 
        $path = $request->file('profile-input')->storeAs('avatars/profile',$id.'.'.$ext); 
        // dd($path);
        $picture = asset('/storage/'.$path);
        $user->update([
            'picture' => $picture
            ]);
        // dd($user);
        // dd($request);
        return redirect('/profile');
    }
    
    public function cancelBloodRequest(BloodRequest $request)
    {
        $request->update(['status' => 'Declined']);
        $request->details()->update(['status' => 'Declined']);
        Log::create([
            'initiated_id' => Auth::user()->id,
            'initiated_type' => 'App\User',
            'reference_id' => $request->id,
            'reference_type' => 'App\BloodRequest',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just cancelled your blood request'
            ]);
        return redirect('/request')->with('status', 'Successfully cancelled blood request');
    }

    public function getNotifications()
    {
        if(Auth::guard('web_admin')->check()) {  
            // return response()->json('abcdefg');
            $tmpData = Auth::guard('web_admin')->user()->notifications;
            $data = null;
            $count = 0;
            foreach($tmpData as $tmp)
            {
                $data[$count]['data'] = $tmp->data;
                $data[$count]['read_at'] = $tmp->read_at;
                $count++;
            }
            $count = count(Auth::guard('web_admin')->user()->unReadNotifications);
            return response()->json(['notif' => $data, 'count' => $count]);
        }
        else
        {

            $tmpData = Auth::user()->notifications;
            $data = null;
            $count = 0;
            foreach($tmpData as $tmp)
            {
                $data[$count]['data'] = $tmp->data;
                $data[$count]['read_at'] = $tmp->read_at;
                $count++;
            }
            $count = count(Auth::user()->unReadNotifications);
            return response()->json(['notif' => $data, 'count' => $count]);
        }
    }

    public function unreadNotifications()
    {
        if(Auth::guard('web_admin')->check()) {  
            // return response()->json('abcdefg');
            $user = Auth::guard('web_admin')->user();
            $user->unreadNotifications->markAsRead();
        }
        else
        {
            $user = Auth::user();
            $user->unreadNotifications->markAsRead();
        }
    }

    public function donateToBloodRequest(BloodRequest $request)
    {
        
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

        
            //notify
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
            //log niya
            Log::create([
            'initiated_id' => Auth::user()->id,
            'initiated_type' => 'App\User',
            'reference_id' => $donateRequest->id,
            'reference_type' => 'App\DonateRequest',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You initiated a voluntary blood donation'
            ]);
            return redirect('/donate')->with('status', 'Thank you hero! Please proceed to the hospital/blood bank as soon as possible!');

        
    }

    
}
