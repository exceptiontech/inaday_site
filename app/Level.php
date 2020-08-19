<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Level extends Model
{
    use HasRoles;

    protected $table = 'levels';

    public $casts = ['title' => 'json'];

    protected $fillable = ['title','slug'];
}
