<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
	public $incrementing = false;

	protected $fillable = [
	'id','user_id','campaign_id','status','remarks'
	];

	public function user() {
		return $this->belongsTo('App\User','user_id');
	}

	public function campaign() {
		return $this->belongsTo('App\Campaign','campaign_id');
	}
}
