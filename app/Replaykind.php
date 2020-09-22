<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replaykind extends Model
{
    protected $table = 'replaykinds';

    public $casts = ['title' => 'array'];
}
