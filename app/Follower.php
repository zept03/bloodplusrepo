<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    
    public $incrementing = false;
    protected $primaryKey = ['user_id','follower_id'];
    
    protected $fillable = ['user_id','follower_id'];
}
