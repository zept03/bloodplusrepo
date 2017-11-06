<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class God extends Model
{

    public $incrementing = false;

   	protected $fillable = [
   		'id','user_id','status'
   	];
}
