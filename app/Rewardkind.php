<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Rewardkind extends Model
{
    use HasRoles;

    protected $table = 'rewardkinds';

    public $casts = ['title' => 'json'];

    protected $fillable = ['title','slug'];
}
