<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelLog extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // public function service()
    // {
    //     return $this->belongsTo('App\service','model_id');
    // }

    // public function user()
    // {
    //     return $this->belongsTo('App\User');
    // }

    // public function user()
    // {
    //     return $this->belongsTo('App\User');
    // }


}
