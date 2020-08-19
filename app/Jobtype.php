<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Jobtype extends Model
{

	//use HasRoles;
    protected $table = 'jobtypes';

    protected $fillable = ['title','slug'];
    

    public $casts = ['title' => 'json'];


    public function getTitle()
    {
        $json = json_decode($this->title,true);
        $title = $json[App::getLocale()];
        return $title;

    }



}
