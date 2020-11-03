<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App;

class Faq extends Model
{
    use HasRoles;

    protected $table = 'faqs';
    public $translatable = ['question','answer'];
    public $casts = ['question' => 'array','answer' => 'array'];
    protected $fillable = ['question','answer','slug','user_id','is_active','order'];

    public function department() {
        return $this->belongsTo('App\Department');
    }

}
