<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    public $translatable = ['title','desc'];
    public $casts = ['title' => 'array','desc' => 'array'];


}
