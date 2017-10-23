<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Auth;
use App\InstitutionAdmin;

class RegisterController extends Controller
{
	protected $redirectPath = '/admin/';


    public function show() {
    	return view('admin.register');
    }

    public function register(Request $request) {

    	$this->validator($request->all())->validate();

    	$admin = $this->create($request->all());


    	Auth::guard('web_admin')->login($admin);

    	return redirect($this->redirectPath);
    }

    protected function guard()
   {
       return Auth::guard('web_admin');
   }

   protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:institution_admins',
            'password' => 'required|min:6|confirmed',
        ]);
    }


   protected function create(array $data) {

   		return InstitutionAdmin::create([
   			  'institution_id' => 1,
   			  'name' => $data['name'],
          'password' => bcrypt($data['password']),
          'status' => 'active'
   			]);

   }
}
