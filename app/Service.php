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
        return $this->belongsToMany('App\Skill');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
