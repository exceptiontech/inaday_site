<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {

        return $this->belongsToMany('App\User')->withPivot('is_approved');
    }

    public function hasUser($id){

        if ($this->users()->where('team_user.user_id',$id)->first()) {
            return true;
        }
        return false;

    }

    public function projects()
    {
    	//status_id 3 mean project completed 
        return $this->hasMany('App\Project')->where('status_id',3);
    }

}
