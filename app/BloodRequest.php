<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{


    public $incrementing = false;

	protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = 
    [
        'updates' => 'array'
    ];

    protected $fillable = [
        'id','patient_name','diagnose','institution_id','status','initiated_by','updates','reason'
    ];

    public function institute() {
    	return $this->belongsTo('App\Institution','institution_id','id');
    }

    public function user() {
    	return $this->belongsTo('App\User','initiated_by');
    }

    public function details() {
        //daghan ta ni
    	return $this->hasOne('App\BloodRequestDetail','blood_request_id','id');
    }

    public function donors() {
        return $this->hasMany('App\BloodRequestDonor','blood_request_id','id');
    }

    public function post() {
        return $this->morphOne('App\Post','reference');
    }
}
