<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Applykind extends Model
{
    use HasRoles;

    protected $table = 'applykinds';

    public $casts = ['title' => 'json'];

    protected $fillable = ['title','slug'];
}
