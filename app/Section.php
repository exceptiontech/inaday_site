<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //use Translatable;
    protected $table = 'sections';

    public $casts = ['title' => 'array','desc' => 'array'];


    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
