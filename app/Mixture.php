<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mixture extends Model
{
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function services()
    {
        return $this->belongsToMany('App\Service')->where('deleted_at', '=', null)->withPivot('duration', 'cost');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function ModelLogs()
    {
        return $this->hasMany('App\ModelLog','model_id')->where('model_type','mixture');
    }


}
