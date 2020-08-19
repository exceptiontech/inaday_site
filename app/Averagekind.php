<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;


class Averagekind extends Model
{
    use HasRoles;

    protected $table = 'averagekinds';

    public $casts = ['title' => 'json'];

    protected $fillable = ['title','slug'];
}
