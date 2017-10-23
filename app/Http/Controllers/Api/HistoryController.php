<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Log;
use Auth;

class HistoryController extends Controller
{
    public function getHistory()
    {
    	$logs = Log::where('initiated_id',Auth::user()->id)->orderBy('created_at','desc')->get();
    	if($logs)
    	{
    		return response()->json([
    			'logs' => $logs,
    			'status' => 'Successful',
    			'message' => 'Successfully retrieved history']);
    	}
    	else if(count($logs) == 0)
    	{
    		return response()->json([
    			'logs' => null,
    			'status' => 'Successful',
    			'message' => 'User has no logs']);
    	}
    	else
    	{
    		return response()->json([
    			'logs' => null,
    			'status' => 'Error',
    			'message' => 'Couldn\'t receive user\'s history']);
    	}
    }
}
