<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{


    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function mixture()
    {
        return $this->belongsTo('App\Mixture');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function replays()
    {
        return $this->hasMany('App\Replay')->where('replay_id', null);
    }

    public function requestDuration($id)
    {

        return $this->whereHas('replays', function ($query) use ($id) {
                $query->where('replay_id' , $id)->where('replaykind_id',2)->where('duration', '!=', null)->where('is_confirmed',0);
            })->count();
    }


    public function requestConfirm()
    {
        return $this->hasMany('App\Replay')->where('replaykind_id',3)->latest()->first();
    }


    public function getModel() {

        if ($this->service) {
            return $this->service;
        }elseif ($this->project) {
            return $this->project;
        }elseif ($this->mixture) {
            return $this->mixture;
        }
    }


    public function getModelUser() {

        if ($this->service) {
            return $this->service->user;
        }elseif ($this->project) {
            return $this->offer->user;
        }elseif ($this->mixture) {
            return $this->mixture->team->user;
        }
    }

    public function UserhaveAccess($id) {

        if($this->getModelUser()->id == $id || $this->user->id == $id ) {
            return $this->getModelUser()->id;
        }

        return false;
    }


    public function getFees() {
        return round((($this->payment->amount)*7)/100);
    }

    public function getFeesByRiyal() {
        if ($this->payment->type = 'paytabs') {
            return round((($this->payment->amount*3.7504381353)*7)/100);
        }
        
        return round((($this->payment->amount)*7)/100);
    }

    public function getTotal() {
        return round($this->payment->amount);
    }

    public function getTotalByRiyal() {
        if ($this->payment->currency == 'USD') {
            return round($this->payment->amount*3.7504381353);
        }
        return round($this->payment->amount);
    }



    // public function status() {

    //     $now = Carbon::now();

    //     $end_date = Carbon::parse($this->end_date);

    //     $lengthOfAd = $now->diffInDays($end_date, false);

    //     $status ='منتهي';

    //     if ($lengthOfAd > 6 && $end_date > $now ) {
    //         $status ='عادي';
    //     }elseif ($lengthOfAd > 3 && $end_date > $now) {
    //         $status ='متوسط';
    //     }elseif ($lengthOfAd > 0 && $end_date > $now) {
    //         $status ='عاجل لم يتبقي الا وقت وجيز تواصل مع العميل';
    //     }elseif ($lengthOfAd == 0 && $end_date > $now) {
    //         $status ='عاجل لم يتبقي الا يوم واحد تواصل مع العميل';
    //     }elseif ($lengthOfAd < 0  && $end_date > $now) {
    //         $status ='منتهي';
    //     }

    //     return $status ;
    // }

}
