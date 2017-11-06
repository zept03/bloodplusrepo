<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonateRequest extends Model
{
	public $incrementing = false;

	protected $casts = 
    [
        'updates' => 'array'
    ];
	protected $dates = [
        'created_at',
        'updated_at',
        'appointment_time'
    ];

	protected $fillable = [
		'id','initiated_by','appointment_time','institution_id','status','updates','reason'
	];

	public function user() {
		return $this->belongsTo("App\User","initiated_by");
	}

	public function bloodrequest() {
		return $this->hasOne("App\BloodRequestDonor","donate_request_id","id");
	}
	public function institute() {
    	return $this->belongsTo('App\Institution','institution_id');
    }
}
