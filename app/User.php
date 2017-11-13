<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    public $incrementing = false;
    
    protected $casts = [
    'address' => 'array'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'dob'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','fname','lname','mi', 'email', 'password','status','gender','bloodType','dob',    'contactinfo','email_token','api_token','verified','banner','picture','address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email_token','verified'
    ];

    public function requests() {
        return $this->hasMany('App\BloodRequest','initiated_by','id');
    }
    public function donations() {
        return $this->hasMany('App\DonateRequest','initiated_by','id');
    }
    public function name() {
        return $this->fname.' '.$this->lname;
    }
    public function logs() {
        return $this->hasMany('App\Log','initiated_id','id');
    }
    public function attendances() {
        return $this->hasMany('App\Attendance','user_id','id');
    }
    public function posts() {
        return $this->morphMany('App\Post','initiated');
    }
    public function picture()
    {
        return $this->picture;
    }
    public function banner()
    {
        return $this->banner;
    }
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.'.$this->id;
    }
    public function followers()
    {
    return $this->morphToMany('App\User', 'follower','followers')->wherePivot('status', 1)->withTimestamps();
    }
    public function followedUsers()
    {
    return $this->morphedByMany('App\User', 'follower','followers')->wherePivot('status', 1)->withTimestamps();
    }
    public function followedInstitutions()
    {
    return $this->morphedByMany('App\Institution', 'follower','followers')->wherePivot('status', 1)->withTimestamps();
    }
    public function super()
    {
        return $this->hasOne('App\God', 'user_id','id');
    }
}
