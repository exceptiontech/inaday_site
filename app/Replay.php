<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

}
