<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{

    public function surveyquestions()
    {
        return $this->hasMany('App\Surveyquestion');
    }

}
