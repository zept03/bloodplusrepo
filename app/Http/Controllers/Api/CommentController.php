<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use App\Post;
use Auth;
class CommentController extends Controller
{
    

    public function createComment(Request $request, Post $post)
    {
    	$comment = Comment::create([
    		'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
    		'message' => $request->input('message'),
    		'post_id' => $post->id,
    		'initiated_id' => Auth::user()->id
    		]);
    	if($comment)
    	{
    		return response()->json([
    			'comment' => $comment->id,
    			'status' => 'Successfully',
    			'message' => 'Successfully made a comment'
    			]);
    	}
    	else
    	{
    		return response()->json([
    			'comment' => null,
    			'status' => 'Error',
    			'message' => 'Couldn\'t make a comment'
    			]);
    	}
    }

    public function getComments(Post $post)
    {
    	$post->load(['comments' => function ($query) {
            $query->orderBy('created_at','desc');
        }]);   
        // dd($post->comments);
    	$comments = null;

    	if(count($post->comments) != 0)
    	{
    		$comments = array();
    		$counter = 0;
    	foreach($post->comments as $comment)
    	{
    		$comments[$counter]['message'] = $comment->message;
            $comments[$counter]['initiated']['id'] = $comment->initiated->id;
    		$comments[$counter]['initiated']['name'] = $comment->initiated->name();
    		$comments[$counter]['initiated']['picture'] = $comment->initiated->picture();
    		$comments[$counter]['created_at'] = $comment->created_at;
    		$counter++;
    	}
    		return response()->json(['comments' => $comments,
    			'status'=> 'Successful',
    			'message' => 'Successfully retrieved comments']);
    	}
    	else
    		return response()->json(['comments' => null,
    			'status' => 'Successful',
    			'message' => 'No available comments']);
    }

    public function editComment(Comment $comment)
    {

    }
}
