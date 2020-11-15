<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill')->where('is_active',1);
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }


    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function ModelLogs()
    {
        return $this->hasMany('App\ModelLog','model_id')->where('model_type','service');
    }


}
