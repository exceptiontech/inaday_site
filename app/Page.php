<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use App;

class Page extends Model
{
    use HasRoles;

    protected $table = 'pages';

    public $casts = ['title' => 'array','desc' => 'array'];

    public function getTitle()
    {
        $json = json_decode($this->title,true);
        $title = $json[App::getLocale()];
        return $title;

    }

    public function getDesc()
    {
        $json = json_decode($this->desc,true);
        $title = $json[App::getLocale()];
        return $title;
    }

}
