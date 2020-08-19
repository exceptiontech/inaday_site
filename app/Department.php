<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Department extends Model
{
    use HasRoles;

    protected $table = 'departments';

    public $translatable = ['title','desc'];
    public $casts = ['title' => 'json','desc' => 'json'];


    protected $fillable = ['title','desc','slug','type','image','parent_id','is_active'];

    public function parent() {
        return $this->belongsTo('App\Department', 'parent_id', 'id');
    }

    public function departments() {
        return $this->hasMany('App\Department', 'parent_id', 'id');
    }

    public function articles() {
        return $this->hasMany('App\Article');
    }

    public function faqs() {
        return $this->hasMany('App\Faq');
    }

    public function sponsors() {
        return $this->hasMany('App\Sponsor');
    }

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
