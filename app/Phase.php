<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    public $casts = ['title' => 'array'];
}
