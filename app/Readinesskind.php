<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Readinesskind extends Model
{
    use HasRoles;

    protected $table = 'readinesskinds';

    public $casts = ['title' => 'json'];

    protected $fillable = ['title','slug'];
}
