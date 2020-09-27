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
        return $this->belongsToMany('App\Skill')->where('is_active',1);
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function services()
    {
        return $this->belongsToMany('App\Service')->withPivot('duration', 'cost');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

}
