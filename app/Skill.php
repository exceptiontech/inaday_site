<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Skill extends Model
{
    use HasRoles;

    protected $table = 'skills';

    public $casts = ['title' => 'array'];

    protected $fillable = ['title','slug'];

    
}
