<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    //use Translatable;
    protected $table = 'stages';

    public $casts = ['title' => 'array'];


    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
