<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Campaign;
use Auth;
use App\Post;
use App\Log;
use App\Institution;
use App\Notifications\BloodRequestNotification;

class AdminCampaignController extends Controller
{
    public function campaign() {
        $pendingCampaigns = Campaign::with('initiated.institute')->where('status','Pending')->get();
        // dd($campaigns);
        
        $ongoingCampaigns = Campaign::with('initiated.institute')->where('status','Ongoing')->orderBy('date_start','asc')->get();

        $doneCampaigns = Campaign::with('initiated.institute')->where('status','Done')->orderBy('date_start','desc')->get();

    	return view('admin.campaign',compact('pendingCampaigns','ongoingCampaigns','doneCampaigns'));
    }

    public function createCampaign(Request $request)
    {
    	$validation = Validator::make($request->all(), [
            'campaign_name' => 'required|string|max:255',
            'campaign_description' => 'required|string|max:255',
            'exactcity' => 'required|string',
            'campaign_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'campaign_avatar' => 'image',
            'end_time' => 'required|date_format:H:i'
            ]);

        $validation->validate();

        $address = 
            array('place' => $request->input('exactcity'),
            'longitude' => $request->input('cityLng'),
            'latitude' => $request->input('cityLat'));
        // print_r($address);
        $date_start = new Carbon($request->input('campaign_date').' '.$request->input('start_time'));
        $date_end = new Carbon($request->input('campaign_date').' '.$request->input('end_time'));
        $id = $str = strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7));
        if($request->file('campaign_avatar'))
        {
        $ext = \File::extension($request->file('campaign_avatar')->getClientOriginalName()); 
        $path = $request->file('campaign_avatar')->storeAs('campaigns',$id.'.'.$ext); 
        $picture = asset('/storage/'.$path);

        }
        else
            $picture = null;
        
        $initiated_by = Auth::guard('web_admin')->user()->id;
        $create = Campaign::create([
        	'id' => $id,
        	'name' => $request->input('campaign_name'),
        	'address' => $address,
        	'description' => $request->input('campaign_description'),
        	'date_start' => $date_start, 
        	'date_end' => $date_end,
        	'status' => 'Pending',
            'initiated_by' => $initiated_by,
            'picture' => $picture
        	]);
        // dd($create->id);
        // dd($initiated_by);
        if($picture == null)
            $picture = asset('assets/img/posts/blood-donation.jpg');

        $post = Post::create([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'We have recently initiated a campaign. Come and join our cause!',
            'picture' => $picture,
            'initiated_id' => $initiated_by,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_type' => 'App\Campaign',
            'reference_id' => $create->id
            ]);
        Log::create([
            'initiated_id' => $initiated_by,
            'initiated_type' => 'App\InstitutionAdmin',
            'reference_id' => $create->id,
            'reference_type' => 'App\Campaign',
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You initiated a campaign!'
            ]);
        $institute = Institution::find(Auth::guard('web_admin')->user()->institute->id);
        $followers = $institute->followers;
        // dd('niagi dri');
        $id = $create->id;
        $class = array("class" => "App\Campaign",
            "id" => $create->id,
            "time" => $create->created_at->toDateTimeString());
        $user = array("name" => Auth::guard('web_admin')->user()->institute->name(),
                "picture" => Auth::guard('web_admin')->user()->institute->picture());
        $message = Auth::guard('web_admin')->user()->institute->name().' just initiated a campaign. Join Now!';
        foreach($followers as $follower)
        {
            $follower->notify(new BloodRequestNotification($class,$user,$message));
        }
        return redirect('/admin/campaign/'.$create->id)->with('status', 'Campaign successfully made!');
    	// $contents = Storage::url('avatars/'.$name);
    	// dd($request);
    }

    public function viewCampaign(Campaign $campaign)
    {
        // dd($campaign);

        return view('admin.showCampaign',compact('campaign'));
    }
    public function showCreate()
    {
        return view('admin.createcampaign');
    }
}
