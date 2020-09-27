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

        return $this->belongsToMany('App\User')->withPivot('is_approved')->where('is_approved',1);
    }

    public function pendingUsers()
    {

        return $this->belongsToMany('App\User')->withPivot('is_approved');
    }

    public function hasUser($id){

        if ($this->pendingUsers()->where('team_user.user_id',$id)->where('team_user.is_approved','!=',3)->where('team_user.is_approved','!=',2)->first()) {
            return true;
        }
        return false;

    }

    public function projects()
    {
    	//status_id 3 mean project completed 
        return $this->hasMany('App\Project')->where('status_id',3);
    }

    public function mixtures()
    {
        return $this->hasMany('App\Mixture')->where('is_approved',1)->where('deleted_at', '=', null);
    }



}
