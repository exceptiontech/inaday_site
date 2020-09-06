<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userdetail extends Model
{

    public function jobtype()
    {
        return $this->belongsTo('App\Jobtype');
    }
    public function level()
    {
        return $this->belongsTo('App\Level');
    }
    public function prefer()
    {
        return $this->belongsTo('App\Prefer');
    }
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    public function city()
    {
       return $this->belongsTo('App\City');
    }
}
