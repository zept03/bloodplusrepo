<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodBag extends Model
{
	public $incrementing = false;

	protected $table = 'blood_bag';

    protected $fillable = [
        'id','bloodtype_id','category','qty','e_qty'
    ];

    public function bloodType()
    {
    	return $this->belongsTo('App\BloodType','bloodtype_id','id');
    }
}