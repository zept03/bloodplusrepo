<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
	public $incrementing = false;

	protected $dates = [
	'date_start',
	'date_end'
	];
	protected $casts = [
	'address' => 'array'
	];
	protected $fillable = [
	'id','name','address','description','date_start','date_end','status','picture','initiated_by'
	];
	    
	public function initiated()
	{
		return $this->belongsTo('App\InstitutionAdmin','initiated_by');
	}

	public function attendance()
	{
		return $this->hasMany('App\Attendance','campaign_id','id');
	}
}
