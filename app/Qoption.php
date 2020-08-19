<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use App;

class Qoption extends Model
{
    
    use HasRoles;

    protected $table = 'qoptions';

    public $casts = ['title' => 'array'];


    
}
