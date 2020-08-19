<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function skills()
    {
        return $this->belongsToMany('App\Skill');
    }
}
