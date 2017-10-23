<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class donorstemp extends Model
{

	protected $dates = [
        'created_at',
        'updated_at',
        'dob'
    ];

    protected $table = "donorstemp";

    protected $fillable = [
    	'name','status','dob','blood_type','contactinfo','gender','frequency','address'
    ];
}
