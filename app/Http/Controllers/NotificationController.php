<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    

    public function getNotification(Request $request,$notification)
    {
    	$class = substr($request->input('class'),4);
    	// dd($class);
    	if(Auth::user())
    	{
	    	if($class == 'BloodRequest')
	    		return redirect('/request/'.$notification);
	    	else if($class == 'DonateRequest')
	    		return redirect('/donate/'.$notification);
	    	else if($class == 'Campaign')
	    		return redirect('/campaign/'.$notification);
	    	else if($class == 'User')
	    		return redirect('/user/'.$notification);
	    }
    	else if(Auth::guard('web_admin')->user())
    	{
    		// dd('niagi dri');
    		if($class == 'BloodRequest')
    			return redirect('/admin/request');
    		else if($class == 'DonateRequest')
    			return redirect('/admin/donate');
    		else if($class == 'Campaign')
	    		return redirect('/admin/campaign/'.$notification);
	    	else if($class == 'User')
	    		return redirect('/user/'.$notification);	
    	}
    	else
    		return redirect('/login');
    }
}
