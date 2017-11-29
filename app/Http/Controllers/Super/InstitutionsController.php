<?php

namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Institution;

class InstitutionsController extends Controller
{
    //create institution (god mode)
    public function getInstitutions(Request $request)
    {
    	$institutions = Institution::all();
    	// dd($institutions);
    	return view('bpadmin.institutions');
    }

  	
}
