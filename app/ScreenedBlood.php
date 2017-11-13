<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScreenedBlood extends Model
{
	protected $table = 'screened_bloods';
	public $incrementing = false;
 	

   	protected $fillable = [
   	 'id','donate_id','serial_number','bag_type','bag_component','reactive','status','diagnose'
   	 ];

   	public function donation() {
   		return $this->belongsTo('App\DonateRequest','donate_id','id');
   	}

   	public function components() {
   		return $this->hasMany('App\BloodInventory','screened_blood_id','id');
   	}

      public function componentsToString()
      {
         $components = $this->components;
         $string = "";
         foreach($components as $component)
         {
            $bloodType = $component->bloodType;
            $string = $string.$bloodType->category.', ';
         }
         return $string;
      }
}

