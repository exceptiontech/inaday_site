<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function skill()
    {
        return $this->belongsTo('App\Skill');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

}
