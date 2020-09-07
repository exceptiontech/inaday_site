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
    public function applykind()
    {
        return $this->belongsTo('App\Applykind');
    }
    public function averagekind()
    {
        return $this->belongsTo('App\Averagekind');
    }

    public function costkind()
    {
        return $this->belongsTo('App\Costkind');
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
