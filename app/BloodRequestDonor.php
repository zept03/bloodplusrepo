<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodRequestDonor extends Model
{
    public $incrementing = false;
    protected $primaryKey = ['blood_request_id','donate_request_id'];

    protected $fillable = ['blood_request_id','donate_request_id','status'];


    public function request()
    {
    	return $this->belongsTo('App\BloodRequest','blood_request_id','id');
    }
}
