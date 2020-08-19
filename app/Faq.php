<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Faq extends Model
{
    use HasRoles;

    protected $table = 'faqs';

    public $casts = ['title' => 'json','answer' => 'json'];


    protected $fillable = ['title','answer','slug','user_id','is_active','order'];


    public function getQuestion()
    {
        $json = json_decode($this->question,true);
        $title = $json[App::getLocale()];
        return $title;

    }

    public function getAnswer()
    {
        $json = json_decode($this->answer,true);
        $title = $json[App::getLocale()];
        return $title;

    }

}
