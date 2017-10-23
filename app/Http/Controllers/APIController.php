<?php

namespace App\Http\Controllers;


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

class APIController extends Controller
{
    //login

    public function register(Request $request)
    {       
        $log = json_encode($request->input());
        Log::create(['action' => 'Someone just tried to register. Details:'.
            $log]);
        $validator = $this->validator($request->all());
    	if($validator->fails()) {
            $message = $validator->messages();
            return response()->json($message);
        }
        // $user='abcdefg';
        $user = $this->create($request->all());
    	// Auth::guard('web')->attempt($user);
        if($user)
    	$message = array('user' => $user, 'status' => 200, 'message' => 'Successfully Registered');
        else
        $message = array('status' => 200, 'message' => 'Invalid Error');

        return response()->json($message);
    }
    public function login(Request $request)
    {
        $log = json_encode($request->input());
        Log::create(['action' => 'Someone just tried to login. Details:'.
            $log]);
    	$email = $request->input('email');
    	$password = $request->input('password');
    	if(Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
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
            'mi' => 'required|string|max:255',
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
        if($data['gender'] == 'Male')
        $picture = asset('storage/avatars/profile/man.png');
        else
        $picture = asset('storage/avatars/profile/woman.png');

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
            'picture' => $picture,
            'api_token' => base64_encode($data['email'].'kixgwapo'),
            'email_token' => base64_encode($data['email']),
            'address' => $address
        ]);
        
   		return User::create([
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
            'verified' => 1
        ]);
   	}

    protected function getInstitutions()
    {
        $institutions = Institution::all();
        $message = array('institutions' => $institutions,'message' => '200','status' => 'Successful retrieval of institutions');
        return response()->json($message);
    }

    public function createBloodRequest(Request $request)
    {
        if(!BloodRequest::where('initiated_by',Auth::guard('api')->user()->id)->where('status','Pending')->orWhere('status','Ongoing')->first())
        {
        $validator = Validator::make($request->all(), [
            'pname' => 'required|string|max:255',
            'institution_id' => 'required|string',
            'diagnose' => 'required|string|max:255',
            'units' => 'required|integer|min:0',
            'bloodType' => 'required',
            'bloodCategory' => 'required'
            ]);
        if($validator->fails()) {
            $message = $validator->messages();
            return response()->json($message);
        }
        $bloodRequest = BloodRequest::create([
            'id' => $str = strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'patient_name' => ucwords($request->input('pname')),
            'institution_id' => $request->input('institution_id'),
            'diagnose' => $request->input('diagnose'),
            'status' => 'Pending',
            'initiated_by' => Auth::user()->id
            ]);
        // dd($bloodRequest->id);
        $bloodRequest->details()->create([
            'units' => $request->input('units'),
            'blood_type' => $request->input('bloodType'),
            'blood_category' => $request->input('bloodCategory'),
            'status' => 'Pending'
            ]);
        return response()->json(array("bloodRequest"=>$bloodRequest,"message" => 'Successfully created blood request'));
        }
        else
        {
            return response()->json(array("message" => 'You already have an ongoing blood request'));
        }     
    }

    public function getBloodRequest(Request $request)
    {
        
    }
}
