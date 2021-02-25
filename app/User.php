<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use App\Booking;
use App\Message;
use App\Mixture;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;


    // /**
    //  * Send the email verification notification.
    //  *
    //  * @return void
    //  */
    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new VerifyEmail); // my notification
    // }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','first_name','last_name','mobile', 'email', 'password','user_type','email_verified_at','active_code','is_active','notification_preference'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function isActive()
    {

        $id = $this->id;

        if ($this->where('id',$id)->where('is_active', '1')->first()) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        if (!count($this->roles)) {
            return false;
        }

        if ($this->roles->first()->name == "Admin" ) {
            return true;
        }
        return false;
    }

    public function isEntrepreneur()
    {
        if (!count($this->roles)) {
            return false;
        }

        if ($this->roles->first()->name == "entrepreneur" ) {
            return true;
        }
        return false;
    }

    public function isServicesProvider()
    {

        if (!count($this->roles)) {
            return false;
        }
        if ($this->roles->first()->name == "services_provider" ) {
            return true;
        }
        return false;
    }

    public function isServicesProviderNotCompleted()
    {
        if (count($this->userdetail) > 0 ) {
            return true;
        }
        return false;
    }

    public function skills()
    {
        return $this->belongsToMany('App\Skill')->where('is_active',1);
    }

    public function DefaultSkill()
    {

        return $this->skills()->where('skill_user.is_default','=','1')->first();
    }

    public function userdetails()
    {
        return $this->hasMany('App\Userdetail');
    }

    public function userdetail()
    {
        return $this->hasMany('App\Userdetail');
    }

    public function userdetailComplete()
    {
        return $this->hasMany('App\Userdetail')->where('position', '!=', null)->where('country_id', '!=', null)->where('city_id', '!=', null);
    }

    public function services()
    {
        return $this->hasMany('App\Service')->where('deleted_at', '=', null);
    }

    public function confirmServices()
    {
        return $this->hasMany('App\Service')->where('is_approved', 1);
    }

    public function interviews()
    {
        return $this->hasMany('App\Interview');
    }

    public function PassedInterview()
    {
        return $this->hasOne('App\Interview')->where('is_passed',1)->first();
    }

    public function projects()
    {
        return $this->hasMany('App\Project')->where('deleted_at', '=', null);
    }



   public function ServiceOrders()
    {
        $id = $this->id;

        return Booking::whereHas('service', function ($query) use ($id) {
                $query->where('user_id' , $id);
            })->latest()->get();
    }

    public function MixtureOrders()
    {
        $id = $this->id;

        return Booking::whereHas('mixture', function ($query) use ($id) {
            $query->whereHas('team', function ($query) use ($id) {
                $query->where('user_id' , $id);
            });
            })->get();
    }

    public function ProjectOrders()
    {
        $id = $this->id;

        return Booking::whereHas('offer', function ($query) use ($id) {
                    $query->where('user_id' , $id);
            })->get();
    }


    public function EntrepreneurServiceOrders()
    {
        $id = $this->id;

        return Booking::whereHas('service')->where('user_id' , $id)->latest()->get();
    }

    public function EntrepreneurMixtureOrders()
    {
        $id = $this->id;

        return Booking::whereHas('mixture')->where('user_id' , $id)->latest()->get();
    }

    public function EntrepreneurProjectOrders()
    {
        $id = $this->id;

        return Booking::whereHas('offer')->where('user_id' , $id)->latest()->get();
    }



    public function ServiceProviderTotalProfit()
    {
        $total_services = Payment::whereHas('booking', function ($query) use ($id) {
                $query->whereHas('service', function ($query) use ($id) {
                    $query->where('user_id' , $id);
                });
            })->get();


        return $total_services;
    }


    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function service_bookings()
    {
        return $this->hasMany('App\Booking','provider_id');
    }



    public function myteams()
    {
        return $this->hasMany('App\Team')->where('deleted_at', '=', null);
    }

    public function hasTeam($id)
    {
        return $this->whereHas('teams', function ($query) use ($id) {
                $query->where('team_id' , $id);
            })->first();

    }

    public function hasOwnTeam($id)
    {
        return $this->hasMany('App\Team')->where('id', $id)->first();

    }

    public function teams()
    {
        // 2 mean is refused invitation
        // 3 mean cancel invitation
        return $this->belongsToMany('App\Team')->where('deleted_at', '=', null)->where('team_user.is_approved','!=',2)->where('team_user.is_approved','!=',3)->withPivot('is_approved');
    }

    public function allteams()
    {
        // 2 mean is refused invitation
        // 3 mean cancel invitation
        return $this->belongsToMany('App\Team')->where('deleted_at', '=', null)->withPivot('is_approved');
    }

    public function hasTeamInvitation($teamID,$userID)
    {
        $user = User::findorfail($userID);

        return $this->whereHas('teams', function ($query) use ($teamID) {
                $query->where('team_id' , $teamID);
            })->first();

    }

    public function portfolios()
    {
        return $this->hasMany('App\Portfolio')->where('deleted_at', '=', null);
    }

    public function experiences()
    {
        return $this->hasMany('App\Experience')->where('deleted_at', '=', null);
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function ServicehasFavorite($id)
    {
        $result = $this->whereHas('favorites', function ($query) use ($id) {
                $query->where('service_id' , $id)->where('user_id' , $this->id);
            })->get();

        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    public function ProjecthasFavorite($id)
    {
        $result = $this->whereHas('favorites', function ($query) use ($id) {
                $query->where('project_id' , $id)->where('user_id' , $this->id);;
            })->get();

        if (count($result) > 0) {
            return true;
        }
        return false;
    }


    public function MyMixtures()
    {
        $id = $this->id;

        return Mixture::whereHas('team', function ($query) use ($id) {
                    $query->where('user_id' , $id);
                })->get();

    }



    public function MixturehasFavorite($id)
    {
        $result = $this->whereHas('favorites', function ($query) use ($id) {
                $query->where('mixture_id' , $id)->where('user_id' , $this->id);
            })->get();

        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    public function usersettings()
    {
        return $this->hasOne('App\Usersettings');
    }



    public function BookedProjects()
    {

        return $this->bookings->where('project_id','!=', '');
    }

    public function BookedServices()
    {

        return $this->bookings->where('service_id','!=', '');

    }

    public function BookedMixtures()
    {
        return $this->bookings->where('mixture_id','!=', '');

    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function totalProfit()
    {
        return $this->transactions->where('type','plus')->sum('mount');
    }

    public function pendingProfit()
    {
        return $this->transactions->where('type','plus')->where('is_confirmed',0)->sum('mount');
    }

    public function requestedProfit() {
        $this->transactions->where('booking_id',null)->where('type','minus')->where('is_confirmed',0)->sum('mount');
    }

    public function confirmedProfit()
    {
        return $this->transactions->where('type','plus')->where('is_confirmed',1)->sum('mount') - $this->transactions->where('type','minus')->sum('mount') ;
    }

    public function messages()
    {
        return $this->hasMany('App\Message','from')->orderBy('created_at');
    }



    public function unread()
    {
        $id = $this->id;

        return $this->hasMany('App\Message','from')->where('to',$id)->where('is_read',0)->orderBy('created_at');
    }

    // public function last_messages()
    // {

    //     $id = $this->id;

    //     //$item = Message::where('from', $id)->latest()->first();
    //     //$item = $this->hasMany('App\Message','to')->latest()->first();
    //     $item = $this->where('from', $id)->where('to',$receiver)->get()->last();

    //     if ($item) {
    //         if ($item['file']) {
    //             if(pathinfo($item['file'], PATHINFO_EXTENSION)  == 'png' || pathinfo($item['file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($item['file'], PATHINFO_EXTENSION) == 'jpeg') {
    //                 return 'صورة';

    //             }elseif (pathinfo($item['file'], PATHINFO_EXTENSION)  == 'mp3') {
    //                 return 'ملف صوتي';
    //             }else {
    //                 return 'ملف ';

    //             }
    //         }else {
    //             return $item['message'];
    //         }
    //     }

    //     //return $this->hasMany('App\Message','to')->latest()->first();
    // }



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



    public function SendSMS()
    {
        
        if (!$this->isActive()) {

            if ($this->mobile) {

                $user = User::findorfail($this->id);
                $user->active_code = rand(10000,99999);
                $user->save();

                $str = $user->mobile;
                $number = '966'.substr($str, 1);


                $url = "https://www.msegat.com/gw/sendsms.php";
                $params = json_encode([
                    "userName" => "inaday",
                    "userSender" => "INADAY",
                    "apiKey" => "7731c731642e783f2e6043091cd6d8a8",
                    "msg" => "رمز التفعيل : ".$user->active_code,
                    "numbers" => $number
                ]);
                $headers = array('Content-Type:application/json');

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $curl_response = curl_exec($ch);

                if ($curl_response === false) {
                    $info = curl_getinfo($ch);
                    curl_close($ch);
                    die('error occured during curl exec. Additioanl info: ' . var_export($info));
                }

                curl_close($ch);
            }
        }
    }

}
