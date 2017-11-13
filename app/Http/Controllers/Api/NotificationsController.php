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


                $pic = $tmpTmpData['user']['picture'];
                $path = str_replace('localhost','172.17.2.90',$pic);
                $tmpTmpData['user']['picture'] = $path;

                $data[] = $tmpTmpData;
            }
    	return response()->json($data);
    }
}
