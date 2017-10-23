<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;
use App\Mail\EmailVerification;
use Carbon\Carbon;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function register(Request $request)
    {
        // dd($request);
        Log::create(['id'=>strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7))
            , 'message' => 'Someone is registering']);
        $this->validator($request->all())->validate();
        // dd('niagi dri');
        event(new Registered($user = $this->create($request->all())));
        // dd($user);
        $email = new EmailVerification($user);

        //send mail to queue
        // $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
        // dispatch(new SendVerificationEmail($user));
        Log::create([
            'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
            'message' => 'You just joined BloodPlus',
            'reference_type' => 'App\User',
            'reference_id' => $user->id,
            'initiated_id' => $user->id,
            ]);
        return redirect('/login')->with(['status' => 'We have sent you a verification through your email. Please click the link provided in your email to activate your account.']);
    }
    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->verified = 1;
        if($user->save())
        {
        return redirect('/login')->with(['status' => 'Account verified. Login now!']);
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mi' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'bloodType' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' => 'nullable|numeric',
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // dd($data);
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
        // dd($data);

    }
}
