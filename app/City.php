<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //use Translatable;
    protected $table = 'cities';

    public $translatable = ['title'];
    public $casts = ['title' => 'array'];


    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function zones()
    {
        return $this->belongsToMany('App\Zone');
    }

}
