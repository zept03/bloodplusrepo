<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BloodBag;
use App\BloodCategory;
use App\BloodType;
use App\BloodRequest;
use App\BloodInventory;
use App\ScreenedBlood;
use Carbon\Carbon;

class AdminInventoryController extends Controller
{
    
    public function index()
    {
    	$bloodTypes = BloodCategory::with([
          'bloodType' => function($query) 
          {
            $query->orderBy('category');
          },'bloodType.inventory' => function ($query)
          {
            $query->where('status','Available');
          }
        ])->orderBy('name')->get();
      // $bloodTypes = BloodType::find('AD7B725');
      // dd($bloodTypes->bloodType);

    	return view('admin.inventory',compact('bloodTypes'));
    }

    public function getBloodBagStatus(BloodRequest $request) {
        //
        // return response()->json($request);
        $qtyInv = $request->details->bloodType->load(['inventory' => function ($query) 
          {
            $query->where('status','Available');
          }]);
        $count = count($qtyInv->inventory);
        // dd($count);
        // $string = null;
      	if($count >= $request->details->units)
      	{
      		$string[] = "Blood Inventory capable for this request(count is: ".$count.").";
      		$string[] = "Recommended: Accept and finish blood request";
      	}
      	else
      	{
      		$string[] = "Blood Inventory not capable for this request(count is: ".$count.").";
      		$string[] = "Recommended: notify to eligible donors.";

      	}
      	return response()->json(['updates' => $string, 'count' => $count]);
    }

    public function showBloodbags(Request $request)
    {
        $pendingScreenedBloods = ScreenedBlood::where('status','Pending')->get();
      // dd($pendingScreenedBloods->first()->donation);
        return view('admin.screenedbloodbags',compact('pendingScreenedBloods'));
    }

    public function showStatustoStagedView(Request $request)
    {
      $single = false;
      return view('admin.settostagedbloodbags');
    }
     public function setStatusToStaged(Request $request, ScreenedBlood $bloodbag)
    {
      $name = $bloodbag->donation->user->bloodType;
      dd($name);
      foreach($request->input('component') as $component)
      {
        $bloodBag = BloodType::whereHas('bloodCategory', function ($query) use ($name)
            {
                $query->where('name',$name);
        })->where('category',$component)->first();
      }
      dd($request->input('component'));
        //kwa.on ang screenedbloods given the set of ids
        //kwa.on ang mga unsa siya i-component
        //if S ang screeenedblood whole blood njd dayon na.

    }
    public function showSingleStatustoStagedView(Request $request, ScreenedBlood $bloodbag)
    {
      // dd($bloodbag);
      $single = true;
      return view('admin.settostagedbloodbags',compact('bloodbag','single'));
    }
    public function setSingleStatusToStaged(Request $request, ScreenedBlood $bloodbag)
    {
      // dd($request->input());
      $name = $bloodbag->donation->user->bloodType;
      foreach($request->input('component') as $component)
      {
        $bloodType = BloodType::whereHas('bloodCategory', function ($query) use ($name)
            {
                $query->where('name',$name);
        })->where('category',$component)->first();
        // dd($bloodType);
        $bloodinventory = BloodInventory::create([
          'id' => strtoupper(substr(sha1(mt_rand() . microtime()), mt_rand(0,35), 7)),
          'screened_blood_id' => $bloodbag->id,
          'blood_type_id' => $bloodType->id,
          'expiry_date' => Carbon::now()->toDateTimeString(),
          'status' => 'Pending']);

        // dd($bloodBag->bloodCategory->name);
      }
      $bloodbag->update(['status' => 'Staged']);
      // dd($request->input('component'));
      return redirect('/admin/bloodbags')->with('status','Successfully started screening the blood bag');  

    }

    public function showStagedBloodbags(Request $request)
    {
      $bloodBags = ScreenedBlood::where('status','Staged')->get();
      return view('admin.stagedbloodbags',compact('bloodBags'));
    }

    public function showCompleteScreenedBlood(Request $request)
    {
      $single = false;
      $screenedBloodBags = Screenedblood::whereIn('id',$request->input('ids')->get());
      return view('admin.showcompletebloodscreen',compact('screenedBloodBags','single'));
    }   

    public function completeScreenedBlood(Request $request)
    {
      dd($request->input());
      //kwaon ang mga screenedbloods given the set of ids
      // change to reactive or non reactive 
      // if reactive give the diagnose.
    }

    public function showSingleCompleteScreenedBlood(Request $request, ScreenedBlood $staged)
    {
      $single = true;
      $screenedBloodBags = $staged;
      return view('admin.showcompletebloodscreen',compact('screenedBloodBags','single'));
    
    }
    public function completeSingleScreenedBlood(Request $request, ScreenedBlood $staged)
    {
      // dd($staged);

      if($request->input('reactive') == 'true')
      {
        // dd($request->input('diagnose'));
        $staged->update([
          'status' => 'Done',
          'reactive' => 'true',
          'diagnose' => $request->input('diagnose')]);
        $staged->components()->update(['status' => 'Unavailable']);
      }
      else
      {
        // dd('false');
        $staged->update([
          'status' => 'Done',
          'reactive' => 'false'
          ]);
        $staged->components()->update(['status' => 'Available']);

      }
      return redirect('/admin/bloodbags/stagedbloodbag')->with('status','Successfully screened the blood bag and added to inventory.');  
      // change to reactive or non reactive

      // if reactive give the diagnose.
    }

}
