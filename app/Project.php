<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function booking()
    {
        return $this->hasOne('App\Booking');
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill');
    }

    public function section()
    {
        return $this->belongsTo('App\Section');
    }
    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function ConfirmOffer()
    {
        return $this->belongsTo('App\Offer')->where('is_confirmed',1);
    }

    public function phase(){
        return $this->hasOne('App\Phase');
    }

}
