<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Faq extends Model
{
    use HasRoles;

    protected $table = 'faqs';

    public $casts = ['answer' => 'array','question' => 'array'];


    protected $fillable = ['title','answer','slug','user_id','is_active','order'];




}
