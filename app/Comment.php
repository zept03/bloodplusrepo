<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	public $incrementing = false;
    
    protected $fillable = [
    'id','message','post_id','initiated_id'
    ];

    public function post()
    {
    	return $this->belongsTo('App\Post','post_id','id');
    }

    public function initiated()
    {
    	return $this->belongsTo('App\User','initiated_id','id');
    }
}
