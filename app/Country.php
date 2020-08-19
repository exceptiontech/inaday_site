<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    public $translatable = ['title','desc'];
    public $casts = ['title' => 'array','desc' => 'array'];

}
