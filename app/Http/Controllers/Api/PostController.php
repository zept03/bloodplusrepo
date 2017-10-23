<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Auth;
use App\DonateRequest;
use Carbon\Carbon;
use App\BloodRequest;

class PostController extends Controller
{
    
    public function getAllPost()
    {
    	$tmpPosts = Post::with(['initiated','reference'])->orderBy('created_at','desc')->get();
    	$posts = array();
    	$counter = 0;
        //pinnedpost
        //if eligible siya mudonate sa ongoing nga request and pareho silag blood type.
        //return pinned post
        //else 
        //pinned post is null

    	foreach($tmpPosts as $tmpPost) 
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
                    'pictureSaRedCross' => $tmpPinnedPost->institute->picture()],
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
            // eligible to donate
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
