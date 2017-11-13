<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Log;
use App\Post;
use App\DonateRequest;
use App\BloodRequest;
use App\Institution;
use Carbon\Carbon;
use Auth;
use App\Notifications\BloodRequestNotification;

class SocialController extends Controller
{
    public function react(Post $post) {
        // $posts->first()->likes()->attach('170E0F5',['initiated_by' => Auth::user()->id]);
        $post->likes()->attach('170E0F5',['initiated_by' => Auth::user()->id]);
        return response()->json($post->id);
    }

    public function unReact(Post $post) {
        $bool = $post->specificLike()->detach(Auth::user()->id);
        return response()->json($post->id);
    }

    public function changeReact() {
    	
    }

    public function getUser($user)
    {
        try{
        // dd($user);
            $user = User::findOrFail($user);
            if($user->id == Auth::user()->id)
                return redirect('/profile');

            $followings = Auth::user()->followedUsers;
            $following = false;
            foreach($followings as $tmpFollowing)
            {
                if($tmpFollowing->id == $user->id)
                {
                    $following = true;
                    break;
                }
            }
            $posts = $user->posts;
            if(!count($posts))
                $posts = null;

            $posts = Post::where('initiated_id',$user->id)->with('reference')->orderBy('created_at','desc')->get();
            $donateCount = count(DonateRequest::where('status','Done')->where('initiated_by',$user->id)->get());
            $requestcount = count(BloodRequest::where('status','Done')->where('initiated_by',$user->id)->get());


            //follow ni user
            $followedUsers = Auth::user()->followedUsers;
            $authFollowees = $followedUsers->merge(Auth::user()->followedInstitutions)->push(Auth::user());

            $followedUsers = $user->followedUsers;
            $userFollowees = $followedUsers->merge($user->followedInstitutions);
            $userFollowers = $user->followers;
            $followers = true;
            $followees = true;
            $mutualFollowing = null;
            $notMutualFollowing = null;
            $mutualFollowers = null;
            $notMutualFollowers = null;
            if(count($userFollowers) == 0)
            {
                $followers = false;  
            }
            else
            {
                $mutualFollowers = $userFollowers->intersect($authFollowees);
                $notMutualFollowers = $userFollowers->diff($mutualFollowers);    
            }
            if(count($userFollowees) == 0)
            {
                $followees = false;
            }
            else
            {
                $mutualFollowing = $userFollowees->intersect($authFollowees);
                $notMutualFollowing = $userFollowees->diff($mutualFollowing);    
            }
            // dd($mutualFollowing);
            // dd($notMutualFollowers);
            return view('user.viewprofile',compact('user','donateCount','logs','followees','followers','mutualFollowers','notMutualFollowers','mutualFollowing','notMutualFollowing','posts','following'));
        }
        catch(\Exception $e)
        {
            try{
            $user = Institution::findOrFail($user);
            }
            catch(\Exception $e)
            {
                return view('something na wala ni exist');
            }
        }

    }

    public function unFollowUser(User $user) {

        Auth::user()->followedUsers()->detach($user->id);
        return response()->json(['status' => 'Successful',
            'message' => 'Successfully unfollowed user']);
    }

    public function followUser(User $user)
    {
        $date = Carbon::now();
        $class = array("class" => 'App\User',
            "id" => Auth::user()->id,
            "time" => $date->toDateTimeString());
        $creator = array('name' => Auth::user()->name(),
                'picture' => Auth::user()->picture());
        $message = Auth::user()->name().' just followed you.';

        $user->notify(new BloodRequestNotification($class,$creator,$message));
        Auth::user()->followedUsers()->attach($user->id);
        return response()->json(['status' => 'Successful',
            'message' => 'Successfully followed user']);
    }

    public function searchUsersAjax(Request $request)
    {
        $wildcard = $request->input('term');
        // dd($wildcard)
        $tmpUsers = User::where('fname', 'like', $wildcard."%")->orWhere('lname','like', $wildcard."%")->get();
        //get orgs
        $tmpOrgs = Institution::where('institution','like','%'.$wildcard.'%')->get();
        $tmpUsers = $tmpUsers->merge($tmpOrgs);
        //join with tmp users;
        $users = array();
        $count = 0;
        foreach($tmpUsers as $tmpUser)
        {
            $users[$count]['value'] = $tmpUser->id;
            $users[$count]['label'] = $tmpUser->name();
            $count++;
        }
        return response()->json($users);
    }
    public function searchUsers(Request $request)
    {
        $wildcard = $request->input('term');
        // dd($wildcard)
        $tmpUsers = User::where('fname', 'like', $wildcard."%")->orWhere('lname','like', $wildcard."%")->get();
        $users = array();
        $count = 0;
        foreach($tmpUsers as $tmpUser)
        {
            $users[$count]['id'] = $tmpUser->id;
            $users[$count]['address'] = $tmpUser->address['place'];
            $users[$count]['name'] = $tmpUser->name();
            $users[$count]['picture'] = $tmpUser->picture();
            $count++;
        }

        $tmpOrgs = Institution::where('institution','like',"%".$wildcard."%")->get();
        $orgs = array();
        $count = 0;
        foreach($tmpOrgs as $org)
        {
            $orgs[$count]['id'] = $org->id;
            $orgs[$count]['name'] = $org->name();
            $orgs[$count]['address'] = $org->address['place'];
            $orgs[$count]['picture'] = $org->picture();
            $count++;
        }
        return view('user.usersearch',compact('users','orgs'));
    }
}
