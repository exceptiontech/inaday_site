<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use App;


class Question extends Model
{
    use HasRoles;

    protected $table = 'questions';

    public $casts = ['title' => 'array','desc' => 'array'];

    public function skill()
    {
        return $this->belongsTo('App\Skill');
    }

    public function qtype()
    {
        return $this->belongsTo('App\Qtype');
    }

    public function qoptions()
    {
        return $this->hasMany('App\Qoption');
    }


}
