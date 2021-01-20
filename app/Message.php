<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from', 'to', 'message', 'is_read'];


    public function unread($id,$receiver)
    {
        return $this->where('from', $id)->Where('to',$receiver)->where('is_read',0)->count();
    }

    public function sender()
    {
        return $this->belongsTo('App\User','from');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User','to');
    }



    public function last_messages($id,$receiver)
    {

        $item = $this->where('from', $id)->where('to',$receiver)->get()->last();
        //$item = $this->hasMany('App\Message','to')->latest()->first();

        if ($item) {
            if ($item['file']) {
                if(pathinfo($item['file'], PATHINFO_EXTENSION)  == 'png' || pathinfo($item['file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($item['file'], PATHINFO_EXTENSION) == 'jpeg') {
                    return 'صورة';

                }elseif (pathinfo($item['file'], PATHINFO_EXTENSION)  == 'mp3') {
                    return 'ملف صوتي';
                }else {
                    return 'ملف ';

                }
            }else {
                return $item['message'];
            }
        }

        //return $this->hasMany('App\Message','to')->latest()->first();
    }

    
}
