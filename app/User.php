<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Booking;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','first_name','last_name','mobile', 'email', 'password','user_type'
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
        if ($this->roles->first()->name == "Admin" ) {
            return true;
        }
        return false;
    }

    public function isEntrepreneur()
    {
        if ($this->roles->first()->name == "entrepreneur" ) {
            return true;
        }
        return false;
    }

    public function isServicesProvider()
    {
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
        return $this->hasMany('App\Userdetail')->where('position', '!=', null)->orWhere('country_id', '!=', null)->orWhere('city_id', '!=', null);
    }

    public function services()
    {
        return $this->hasMany('App\Service')->where('is_approved',1)->where('deleted_at', '=', null);
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
        return $this->hasMany('App\Project')->where('is_approved',1)->where('deleted_at', '=', null);
    }



    public function ServiceOrders()
    {
        $id = $this->id;

        return Booking::whereHas('service', function ($query) use ($id) {
                $query->where('user_id' , $id);
            })->get();
    }

    public function MixtureOrders()
    {
        $id = $this->id;

        return Booking::whereHas('mixture', function ($query) use ($id) {
                $query->where('user_id' , $id);
            })->get();
    }

    public function ProjectOrders()
    {
        $id = $this->id;

        return Booking::whereHas('offer', function ($query) use ($id) {
                    $query->where('user_id' , $id);
            })->get();
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
        return $this->belongsToMany('App\Team')->where('team_user.is_approved','!=',2)->where('team_user.is_approved','!=',3)->withPivot('is_approved');
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
                $query->where('service_id' , $id);
            })->get();

        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    public function ProjecthasFavorite($id)
    {
        $result = $this->whereHas('favorites', function ($query) use ($id) {
                $query->where('project_id' , $id);
            })->get();

        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    public function MixturehasFavorite($id)
    {
        $result = $this->whereHas('favorites', function ($query) use ($id) {
                $query->where('mixture_id' , $id);
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
        return $this->hasMany('App\Message','from');
    }

    public function last_messages()
    {
        return $this->hasMany('App\Message','from')->latest()->first();
    }


}
