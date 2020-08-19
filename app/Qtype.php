<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use App;

class Qtype extends Model
{
    use HasRoles;

    protected $table = 'qtypes';

    public $casts = ['title' => 'array','desc' => 'array'];
}
