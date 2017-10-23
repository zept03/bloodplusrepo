<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    //
	use AuthenticatesUsers;

	protected $redirectTo = '/admin/';

	public function username() {
		return 'name';
	}

	public function show()
    {
    	return view('admin.login');
    }

    protected function guard()
    {
      return Auth::guard('web_admin');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/admin/');
    }

    public function resend(Request $request)
    {
        $user = Auth::user();
        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);
        dd($email);
    }
}
