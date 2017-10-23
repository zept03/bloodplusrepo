<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $incrementing = false;

    protected $fillable = ['id','message','initiated_id','initiated_type','reference_type','reference_id','picture'];


    public function initiated()
    {
    	return $this->morphTo();
    }

    public function reference()
    {
        return $this->morphTo();
    } 

    public function likes()
    {
    return $this->belongsToMany('App\Reaction','reactions_post','post_id','reaction_id')->withPivot('initiated_by')->withTimestamps()->where('reactions.name','Like')->using('App\ReactionPost');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment','post_id','id');
    }

    public function specificLike()
    {
        return $this->belongsToMany('App\User','reactions_post','post_id','initiated_by')->withPivot('reaction_id')->withTimeStamps()->using('App\ReactionPost');
    }
}
