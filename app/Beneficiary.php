<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Beneficiary extends Model
{

    use HasRoles;

    protected $table = 'beneficiaries';
    public $casts = ['title' => 'array','desc' => 'array','subtitle' => 'array'];


    protected $fillable = ['title','desc','slug','type','image','parent_id','is_active'];

    public function getTitle()
    {
        $json = json_decode($this->title,true);
        $title = $json[App::getLocale()];
        return $title;

    }
    public function getSubTitle()
    {
        $json = json_decode($this->subtitle,true);
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
