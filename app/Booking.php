<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function replays()
    {
        return $this->hasMany('App\Replay');
    }



}
