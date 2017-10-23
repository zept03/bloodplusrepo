<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
    public $incrementing = false;
	
	protected $table = 'blood_type';
    protected $fillable = [
        'id','blood_type','status'
    ];

    public function bloodBags()
    {
    	return $this->hasMany('App\BloodBag','bloodtype_id','id');
    }
}
