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
                $tmpTmpData = $tmp->data;
                $data[] = $tmpTmpData;
            }
    	return response()->json($data);
    }
}
