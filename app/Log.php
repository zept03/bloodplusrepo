<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	public $incrementing = false;

	protected $dates = [
	'created_at'
	];
    protected $fillable =[
    	'message','id','reference_type','reference_id','initiated_id','initiated_type'
    ];

    public function reference()
    {
        return $this->morphTo();
    }

    public function user()
    {
        //morphto ni
        return $this->belongsTo('App\User','initiated_id','id');
    }
}
