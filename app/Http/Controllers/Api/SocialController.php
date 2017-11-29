<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BloodRequest;
use App\DonateRequest;
use App\Follower;
use App\Institution;
use Auth;
use App\User;
use App\Post;	
use App\Notifications\BloodRequestNotification;


class SocialController extends Controller
{
    
    public function profile()
    {
    	$posts = Auth::user()->posts;
    	// $posts = Post
        $donateCount = count(DonateRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->get());
        $requestCount = count(BloodRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->get());

    	$followers = Auth::user()->followers;
    	$tmpFollowing = Auth::user()->followedUsers->merge(Auth::user()->followedInstitutions);
        $following = null;
        $countFollowing = count($tmpFollowing);
        $countFollowers = 0;
		if(count($posts) == 0)
			$posts = null;
		if(count($followers) == 0)
        {
			$mutuals = null;
            $notMutuals = null;
        }
        else
        {
        $tmpMutuals = $followers->intersect(Auth::user()->followedUsers);
        $tmpNotMutuals = $followers->diff($tmpMutuals);
        $mutuals = null;
        $notMutuals = null;
            if(count($tmpMutuals) != 0)
            {
                $countFollowers = count($tmpMutuals);

            } 
            if(count($tmpNotMutuals) != 0)
            {
                $countFollowers = $countFollowers + count($tmpNotMutuals);
            }
        }
    	return response()->json([
    		'posts' => $posts,
    		'following' => $countFollowing,
    		'followers' => $countFollowers,
    		'status' => 'Successful',
            'bloodRequestCount' => $requestCount,
            'bloodDonateCount' => $donateCount,
    		'message' => 'Retrieved posts and followers']);
    }
    
    public function followUser(Request $request,User $user)
    {
    	// dd(Auth::user()->id);
    	$followers = Auth::user()->followers;
        
        if($user->id == Auth::user()->id)
        {
            return response()->json(['status' => 'Error Error',
                'message' => 'Cannot follow yourself']);
        }
    	// dd(count($followers));
    	if(!Auth::user()->followedUsers->contains($user))
    	{
            Auth::user()->followedUsers()->attach($user->id);    
    		return response()->json(['status' => 'Successful', 'message' => 'Successfully followed the user']);
    	}
    	else
    		return response()->json(['status' => 'Error', 'message' => 'Couldn\'t follow the user']);

    }

    public function getFollowers()
    {
        $followers = Auth::user()->followers;
        if(count($followers) == 0)
        {
            $mutuals = null;
            $notMutuals = null;
        }
        else
        {
        $tmpMutuals = $followers->intersect(Auth::user()->followedUsers);
        $tmpNotMutuals = $followers->diff($tmpMutuals);
        $mutuals = null;
        $notMutuals = null;
        $countFollowers = null;
            if(count($tmpMutuals) != 0)
            {
                $mutuals = array();
                $count = 0;
                foreach($tmpMutuals as $mutual)
                {
                    $mutuals[$count]['id'] = $mutual->id;
                    $mutuals[$count]['name'] = $mutual->name();
                    $mutuals[$count]['picture'] = $mutual->picture();
                    $mutuals[$count]['banner'] = $mutual->banner();
                    $count++;
                }
            } 
            if(count($tmpNotMutuals) != 0)
            {
                $notMutuals = array();
                $count = 0;
                foreach($tmpNotMutuals as $notMutual)   
                {
                    $notMutuals[$count]['id'] = $notMutual->id;
                    $notMutuals[$count]['name'] = $notMutual->name();
                    $notMutuals[$count]['picture'] = $notMutual->picture();
                    $notMutuals[$count]['banner'] = $notMutual->banner();
                    $count++;
                }
            }
        }
        return response()->json([
            'followers' => array(
                'mutuals' => $mutuals,
                'notMutuals' => $notMutuals),
            'status' => 'Successful',
            'message' => 'Successfully retrieved user\'s followers'
            ]);
    }

    public function getFollowing()
    {
        $tmpFollowing = Auth::user()->followedUsers->merge(Auth::user()->followedInstitutions);
        $following = null;
        if(count($tmpFollowing) != 0)
        {
            $following = array();
            $count = 0;
            foreach($tmpFollowing as $followings)
            {
                $following[$count]['id'] = $followings->id;
                $following[$count]['name'] = $followings->name();
                $following[$count]['picture'] = $followings->picture();
                $following[$count]['banner'] = $followings->banner();
                $count++;
            }
        }
        return response()->json([
            'following' => $following,
            'status' => 'Successful',
            'message' => 'Succesffully retrieved user\'s followings'
            ]);

    }
    public function unFollowUser(User $user)
    {
    	$bool = $user->followers()->detach(Auth::user()->id);
        if($user->id == Auth::user()->id)
        {
            return response()->json(['status' => 'Error Error',
                'message' => 'Cannot unfollow yourself']);
        }
    	if($bool)
    	{
    		return response()->json(['status' => 'Successful', 'message' => 'Successfully unfollowed the user']);
    	}
    	else
    		return response()->json(['status' => 'Error', 'message' => 'Couldn\'t unfollow the user']);
    }
    public function getAllUsers()
    {
        $users = User::where('id','!=',Auth::user()->id)->get();
        if($users)
        {
            return response()->json([
                'users' => $users,
                'status' => 'Successful',
                'message' => 'Successfully retrieved all users']);
        }
        else
        {
            return response()->json([
                'users' => $users,
                'status' => 'Error',
                'message' => 'Error retrieveing users']);
        }
    }

    public function getUser($user)
    {
        // dd($user);
        try{
        // dd($user);
            $model = User::findOrFail($user);
            $class = 'User';
        }catch(\Exception $e)
        {
            try{
            $model = Institution::findOrFail($user);
            $class = 'Institution';
            }
            catch(\Exception $e)
            {
                return response()->json([
            'status' => 'Error Error',
            'message' => 'User does not exist']);
            }
        }
        return response()->json(['user' => $model,
            'class' => $class,
            'status' => 'Succcessful',
            'message' => 'Successfully retrieved user']);
    }
    public function getUsers(Request $request)
    {
        $wildcard = $request->input('name');
        // dd($wildcard)
        $tmpUsers = User::where('fname', 'like', $wildcard."%")->orWhere('lname','like', $wildcard."%")->get();
        $users = null;
        if(count($tmpUsers) != 0)
        {  
            $users = array();
            $count = 0;
            foreach($tmpUsers as $tmpUser)
            {
                $users[$count]['name'] = $tmpUser->name();
                $users[$count]['id'] = $tmpUser->id;
                $count++;
            }
        }
        return response()->json(['users' => $users]);
    }
    // public function searchUsers(Request $request)
    // {

    // }

    public function react(Post $post) {
        // $posts->first()->likes()->attach('170E0F5',['initiated_by' => Auth::user()->id]);
        $bool = $post->likes->contains(function ($value, $key) {
            return $value->pivot->initiated_by == Auth::user()->id;
        });
        if($bool)
        {
            return response()->json([
                'status' => 'Error',
                'message' => 'Couldn\'t like the post']);
        }
        else
        {
            $bool = $post->likes()->attach('170E0F5',['initiated_by' => Auth::user()->id]);
            return response()->json([
                'status' => 'Successful',
                'message' => 'Successfully liked the post']);
        }
    }

    public function unReact(Post $post) {
        $bool = $post->likes->contains(function ($value, $key) {
            return $value->pivot->initiated_by == Auth::user()->id;
        });
        if($bool)
        {
            // $smth = $post->load(['likes' => function($query ) {
            //     $query->where('initiated_by',Auth::user()->id)->first();
            // }]);
            // dd($smth->likes->first()->pivot->initiated_by);
            $bool = $post->specificLike()->detach(Auth::user()->id);
            // $bool = $post->likes()->detach('170E0F5',['initiated_by' => Auth::user()->id]);
            return response()->json([
                'status' => 'Successful',
                'message' => 'Successfully unliked the post']);
        }
        else
            return response()->json([
                'status' => 'Error',
                'message' => 'Couldn\'t unlike the post']);

    }
}
