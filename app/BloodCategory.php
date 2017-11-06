<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodCategory extends Model
{
    public $incrementing = false;
	
	protected $table = 'blood_category';
    protected $fillable = [
        'id','name','status'
    ];

    public function bloodType()
    {
    	return $this->hasMany('App\BloodType','blood_category_id','id');
    }
}
