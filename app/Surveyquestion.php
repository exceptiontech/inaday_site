<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surveyquestion extends Model
{
    public function Surveyanswers()
    {
        return $this->hasMany('App\Surveyanswer');
    }
}
