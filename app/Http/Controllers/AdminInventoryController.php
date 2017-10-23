<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BloodBag;
use App\BloodType;
use App\BloodRequest;
class AdminInventoryController extends Controller
{
    
    public function index()
    {
    	$bloodTypes = BloodType::with('bloodBags')->orderBy('name')->get();
    	return view('admin.inventory',compact('bloodTypes'));
    }

    public function getBloodBagStatus(BloodRequest $request) {
        //
        $qtyInv =$request->details->bloodBag->qty;
        // $string = null;
      	if($qtyInv > $request->details->units)
      	{
      		$string[] = "Blood Inventory capable for this request";
      		$string[] = "Recommended: Accept and finish blood request";

      	}
      	else
      	{
      		$string[] = "Blood Inventory not capable for this request.";
      		$string[] = "Recommended: notify to eligible donors."; 
      	}
      	return response()->json($string);
    }
}
