<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Log;
use App\User;
use App\Institution;
use Carbon\Carbon;
use App\BloodRequest;
use App\BloodRequestDetail;

class AuthenticationController extends Controller
{
    //login

    public function register(Request $request)
    {       
        $log = json_encode($request->input());

        $validator = $this->validator($request->all());
    	if($validator->fails()) {
            $message = $validator->messages();
            return response()->json($message);
        }
        // $user='abcdefg';
        $user = $this->create($request->all());
        if($user->gender == 'Male;')
        {
            $user->update([
                'picture' => asset('storage/avatars/profile/man.png')
                ]);
        }
        else
        {
            $user->update([
                'picture' => asset('storage/avatars/profile/woman.png')
                ]);
        }   

    	// Auth::guard('web')->attempt($user);
        if($user)
        {
        Log::create([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just joined BloodPlus',
            'reference_type' => 'User',
            'reference_id' => $user->id
        ]);
        //follow red cross.
        $user->followedInstitutions()->attach('51B64E1');

    	$message = array('user' => $user, 'status' => 200, 'message' => 'Successfully Registered');
        }   
        else
        $message = array('status' => 200, 'message' => 'Invalid Error');

        return response()->json($message);
    }
    public function login(Request $request)
    {
        $log = json_encode($request->input());
    	$email = $request->input('email');
    	$password = $request->input('password');
    	if(Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user()->load('notifications');
            $message = array('user' => Auth::user(), 'status' => 200, 'message' => 'Successful Login');

            return response()->json($message);
        }
        else
        	return response()->json(['error'=>'Invalid Credentials']);
    }
    //campaigns
    protected function validator(array $data)
    {
    	return Validator::make($data, [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'dob' => 'required|date',
            'bloodType' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'nullable|numeric',
            'password' => 'required|string|min:6'
        ]);
    }
    protected function create(array $data)
   	{
   		$address = 
            array('place' => ucwords($data['exactcity']),
                'longitude' => $data['cityLng'], 
                'latitude' => $data['cityLat']);
        // dd($address);

         return User::create([ 
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'fname' => ucwords($data['fname']),
            'lname' => ucwords($data['lname']),
            'mi' => ucwords($data['mi']),
            'gender' => $data['gender'],
            'bloodType' => $data['bloodType'],
            'email' => $data['email'],
            'contactinfo' => $data['contact'],
            'dob' => new Carbon($data['dob']),
            'status' => 'active',
            'password' => bcrypt($data['password']),
            'api_token' => base64_encode($data['email'].'kixgwapo'),
            'email_token' => base64_encode($data['email']),
            'address' => $address,
            'verified' => 1
        ]);
   	}

}
