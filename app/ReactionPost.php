<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ReactionPost extends Pivot
{
    protected $table = 'reactions_post';

    protected $fillable = ['post_id','reaction_id','initiated_by'];
    
    public function user()
    {
    	return $this->belongsTo('App\User','initiated_by','id');
    }

}
