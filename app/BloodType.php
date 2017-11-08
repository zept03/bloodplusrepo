<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
	public $incrementing = false;

	protected $table = 'blood_type';

    protected $fillable = [
        'id','blood_category_id','category','qty','e_qty'
    ];

    public function bloodCategory()
    {
    	return $this->belongsTo('App\BloodCategory','blood_category_id','id');
    }

    public function inventory()
    {
    	return $this->hasMany('App\BloodInventory','blood_type_id','id');
    }

    public function nonReactive()
    {
        $inventory = $this->inventory;
        $filtered = $inventory->filter(function ($value, $key) {
        return $value->status == 'Available';
        });
        return $filtered;
    }

}