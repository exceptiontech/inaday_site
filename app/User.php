<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

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
        return $this->hasMany('App\Service')->where('deleted_at', '=', null);
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

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function team()
    {
        return $this->hasOne('App\Team');
    }

    public function teams()
    {
        // 2 mean is refused invitation
        // 3 mean cancel invitation
        return $this->belongsToMany('App\Team')->where('team_user.is_approved','!=',2)->where('team_user.is_approved','!=',3)->withPivot('is_approved');
    }

    public function hasTeamInvitation($id)
    {
        $result = $this->whereHas('teams', function ($query) use ($id) {
                $query->where('team_id' , $id);
            })->get();

        if (count($result) > 0) {
            return true;
        }
        return false;
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



}
