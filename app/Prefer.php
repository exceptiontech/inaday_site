<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Prefer extends Model
{
    use HasRoles;

    protected $table = 'prefers';

    public $casts = ['title' => 'json'];

    protected $fillable = ['title','slug'];
}
