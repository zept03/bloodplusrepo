<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inquiry;
use App\Mail\SendInquiry;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function request()
    {
        
    	return view('request');
    }
    public function campaign()
    {
    	return view('campaign');
    }
    public function inventory()
    {
    	return view('inventory');
    }

    public function sendInquiry(Request $request)
    {
        // dd($request->input());
        $params = array();
        parse_str($request->input('data'), $params);
    	$name = $params['name'];
        $email = $params['email'];
        $subject = $params['subject'];
        $message = $params['message'];
    	try{
        if ($subject == "")
            $subject = null;
        if ($name == "")
            $name = null;
        if ($email == "")
            $email = null;

    	$inquiry = Inquiry::create(['name' => $name,
    		'email' => $email,
    		'subject' => $subject,
    		'message' => $message
    		]);
    	if($inquiry)
    	{
    		$message = array('status' => 200, 'message' => 'Successful');
            Mail::to('bloodplusph@gmail.com')->send(new SendInquiry($inquiry));
    	}
    	}catch(Exception $e)
    	{
    		$message = array('inquiry' => $e->getMessage(), 'status' => 200, 'message' => 'Invalid Error');
    		return response()->json($message);
    	}
    }
}
