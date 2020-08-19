<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Sponsor extends Model
{

    use HasRoles;

    protected $table = 'sponsors';

    public $casts = ['title' => 'json','desc' => 'json'];


    protected $fillable = ['title','desc','slug','order','image','user_id','is_active'];

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
