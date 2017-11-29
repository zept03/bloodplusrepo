<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Auth;
use App\DonateRequest;
use Carbon\Carbon;
use App\BloodRequest;
use App\Log;

class PostController extends Controller
{
    
    public function getAllPost()
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
    	$posts = array();
    	$counter = 0;
        //pinnedpost
        //if eligible siya mudonate sa ongoing nga request and pareho silag blood type.
        //return pinned post
        //else 
        //pinned post is null
        $sortedTmpPosts = $tmpPosts->sortByDesc('created_at');
    	foreach($sortedTmpPosts as $tmpPost) 
    	{
    		$posts[$counter]['id'] = $tmpPost->id;
    		$posts[$counter]['message'] = $tmpPost->message;
    		$posts[$counter]['picture'] = $tmpPost->picture;
    		$posts[$counter]['created_at'] = $tmpPost->created_at;
            $posts[$counter]['class'] = substr($tmpPost->reference_type,4);
            $posts[$counter]['class_id'] = $tmpPost->reference_id;
    		$initiated = $tmpPost->initiated;
            $posts[$counter]['initiated']['id'] = $initiated->id;
    		$posts[$counter]['initiated']['name'] =  $initiated->name();
    		$posts[$counter]['initiated']['picture'] = $initiated->picture();
    		$posts[$counter]['reference']['id'] = $tmpPost->reference->id;
    		$posts[$counter]['reference']['type'] = $tmpPost->reference_type;
            $posts[$counter]['likes'] = count($tmpPost->likes);
            $posts[$counter]['comments'] = count($tmpPost->comments);
            $posts[$counter]['liked'] = false;
            foreach($tmpPost->likes as $tmpLike)
            {
                if($tmpLike->pivot->initiated_by == Auth::user()->id)
                {
                    $posts[$counter]['liked'] = true;
                    break;
                }
            }
    		$counter++;
    			
    	}
        
        $pinnedPost = null;
        $onGoingDonation = DonateRequest::where('initiated_by',Auth::user()->id)->whereIn('status',['Pending','Ongoing'])->get();
        
        if(count($onGoingDonation) == 1)
        {
            return response()->json(array(
            'pinnedPost' => $pinnedPost,
            'posts' => $posts,
            'status' => 'Successful',
            'message' => 'Retrieved all posts'
            ));   
        }

        // Log::create([
        //     'id' => '12345',
        //     'message' => json_encode($posts)
        //     ]);
        $tmpPinnedPost = BloodRequest::with('details','post','institute')->whereHas('details',function ($query) {
                $query->where('blood_type',Auth::user()->bloodType);
                })->where('status','Ongoing')->first();
        // $post = $pinnedPost->post->first();
        if($tmpPinnedPost)
        {
            if($tmpPinnedPost->initiated_by == Auth::user()->id)
            {
                $pinnedPost = null;
                return response()->json(array(
                'pinnedPost' => $pinnedPost,
                'posts' => $posts,
                'status' => 'Successful',
                'message' => 'Retrieved all posts'
                )); 
            }
        }
        else
        {
            return response()->json(array(
            'pinnedPost' => null,
            'posts' => $posts,
            'status' => 'Successful',
            'message' => 'Retrieved all posts'
            ));
        }
        
        $lastRequest = DonateRequest::where('status','Done')->where('initiated_by',Auth::user()->id)->orderBy('created_at','desc')->first();
        // dd($lastRequest->user->id);
        if($lastRequest)
        {
            
        if($lastRequest->appointment_time)
            $date = $lastRequest->appointment_time;
        else
            $date = $lastRequest->created_at;

        $now = Carbon::now();
        if(!($date->addDays(90) >= $now))
            {
                //eligible to donate   
                // dd('eligible sud sa if');
                return response()->json(array(
                'pinnedPost' => [
                    'post' => $tmpPinnedPost,
                    'pictureSaRedCross' => $tmpPinnedPost->institute->picture()
                    ],
                'posts' => $posts,
                'status' => 'Successful',
                'message' => 'Retrieved all posts'
                ));
            }
        else
            {
                //not eligible to donate
                // dd('not eligible');
                $pinnedPost = null;
                return response()->json(array(
                'pinnedPost' => $pinnedPost,
                'posts' => $posts,
                'status' => 'Successful',
                'message' => 'Retrieved all posts'
                ));
                
            }
        }
        else
        {
            return response()->json(array(
            'pinnedPost' => [
                    'post' => $tmpPinnedPost,
                    'pictureSaRedCross' => $tmpPinnedPost->institute->picture()
                    ],
            'posts' => $posts,
            'status' => 'Successful',
            'message' => 'Retrieved all posts'
            ));
        }
    }              
}
