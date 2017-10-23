<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
	public $incrementing = false;
	
    protected $casts = [
    'address' => 'array'
    ];
    
    protected $fillable = [
        'id', 'institution','address','credentials','status'
    ];

    public function requests() {
    	return $this->hasMany('App\BloodRequest','institution_id','id');
    }

    public function admins() {
    	return $this->hasMany('App\InstitutionAdmin','institution_id','id');
    }
    public function followers() {
        return $this->morphToMany('App\User', 'follower', 'followers')->wherePivot('status', 1)->withTimestamps();
    }
    public function name()
    {
        return $this->institution;
    }
    public function banner()
    {
        return asset('assets/img/slides/bb2.jpg');
    }
    public function picture()
    {
        return asset('assets/img/321.png');
    }
}
