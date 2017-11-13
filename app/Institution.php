<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    public function newlyFollowedInstitutions()
    {

        $lastWeek = new Carbon('last sunday');
        $lastWeekStr = $lastWeek->toDateTimeString();
        $nextWeek = new Carbon('next sunday');
        $nextWeekStr = $lastWeek->toDateTimeString();
        return $this->morphToMany('App\User', 'follower','followers')->wherePivot('status', 1)->wherePivot('created_at','>',$lastWeek)->wherePivot('created_at','<',$nextWeek);
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
