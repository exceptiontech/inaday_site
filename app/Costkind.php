<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;


class Costkind extends Model
{
    use HasRoles;

    protected $table = 'costkinds';

    public $casts = ['title' => 'json'];

    protected $fillable = ['title','slug'];
}
