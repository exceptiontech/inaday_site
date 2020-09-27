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

    public function replaykind()
    {
        return $this->belongsTo('App\Replaykind');
    }

    public function parent()
    {
        return $this->belongsTo('App\Replay','replay_id');
    }

    public function replays()
    {
        return $this->hasMany('App\Replay');
    }

    public function requestDuration($id)
    {
        return $this->where('id',$id)->where('replaykind_id',2)->where('duration', '!=', null)->where('is_confirmed',0)->first();
    }

}
