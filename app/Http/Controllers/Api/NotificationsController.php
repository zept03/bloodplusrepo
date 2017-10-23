<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
class NotificationsController extends Controller
{
    public function getNotifications()
    {
    	$tmpData = Auth::user()->notifications;
    	$data = null;
            foreach($tmpData as $tmp)
            {
                $data[] = $tmp->data;
            }
    	return response()->json($data);
    }
}
