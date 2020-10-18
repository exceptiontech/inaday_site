<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;


use App\Team;
use Illuminate\Http\Request;
use App\Image;
use App\Section;
use App\Skill;
use App\Applykind;
use App\Log;
use App\User;
use App\Mixture;
use Auth;
use Socialite;
use URL;
use Redirect;
use Session;

use App\Notifications\TeamCreated;
use App\Notifications\TeamUpdated;
use App\Notifications\TeamDeleted;
use App\Notifications\TeamRequest;
use App\Notifications\TeamRefusedRequest;
use App\Notifications\TeamCancelRequest;
use App\Notifications\TeamAcceptRequest;


class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.profile.teams.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( count(Auth::user()->roles) == 0 || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {
            Session::flash('status', __('admin.info'));
            Session::flash('message', 'لا بد من تحديث الملف الشخصى لتتمكن من اضافة فريق');
            return redirect::to('/account/profile/edit');
        }

        return view('front.profile.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'title'     =>'required|min:3|max:100|string',
            'desc'      =>'required|min:3|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);

        $team= new Team();
        $team->user_id=Auth::id();
        $team->title=$request->title;
        $team->desc=$request->desc;
        $team->save();
 
        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/teams';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $team->image =  $destinationPath.'/'.$fileName;
        }

        $team->save();


        if ($team) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'team';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        Auth::user()->notify(new \App\Notifications\Database\TeamCreated($team));

        if (Auth::user()->usersettings && Auth::user()->usersettings->team_notifications)
        {
            Auth::user()->notify(new TeamCreated($team));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('/user/'.Auth::user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        $team = Team::find($id);
        return view('front.profile.teams.edit',compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        elseif(is_null(Team::where('user_id',Auth::id())->first()) == 1)
        {
            return view('front.errors.denied');
        }

        $team= Team::find($id);
        $team->user_id=Auth::id();
        $team->title=$request->title;
        $team->desc=$request->desc;
        $team->save();
 
        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/teams';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $team->image =  $destinationPath.'/'.$fileName;
        }

        $team->save();

        if ($team) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'team';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }



        Auth::user()->notify(new \App\Notifications\Database\TeamUpdated($team));

        if (Auth::user()->usersettings && Auth::user()->usersettings->team_notifications)
        {
            Auth::user()->notify(new TeamUpdated($team));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('/user/'.Auth::user()->id);

    }


    /**
     * Delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {

        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        elseif(is_null(Team::where('user_id',Auth::id())->first()) == 1)
        {
            return view('front.errors.denied');
        }


        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {

            $team = Team::find($id);

            if (count($team->mixtures) > 0) {
                foreach ($team->mixtures as $key => $mix) {
                    $mixture = mixture::find($mix->id);
                    $mixture->deleted_at = now();
                    $mixture->save();
                }
            }

            $team->deleted_at = now();
            $team->save();
        }

        if ($team) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'team';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Auth::user()->notify(new \App\Notifications\Database\TeamDeleted($team));

        if (Auth::user()->usersettings && Auth::user()->usersettings->team_notifications)
        {
            Auth::user()->notify(new TeamDeleted($team));
        } 

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));
        return redirect::to('/user/'.Auth::user()->id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }

    public function team() {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        return view('front.profile.teams.team');
    }


    public function listServicesProvider(Request $request , $team_id ,User $users)
    {


        $users = $users->newQuery();


        //check roles
        $role = 'services_provider';
        $users->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });

        // Services provider with uncomplete profile
        $users->whereHas('userdetailComplete');


        // Team Owner
        $users->where('id','!=',Auth::user()->id);


        //check exists team member
        // $team = Auth::user()->team->id;
        // $users->whereDoesntHave('teams', function ($query) use ($team) {
        //         $query->where('team_id' , $team);
        //     });



        if ($request->targetskills) {
            $targetskills = $request->targetskills;

            $users->whereHas('skills', function ($query) use ($targetskills) {
                $query->whereIn('skill_id', $targetskills);
            });
        }


        if ($request->name) {

            $name = $request->name;
            $users->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');

        }


        if ($users) {

            if ($request->targetskills) {
                $targetskills = $request->targetskills;
            }else {
                $targetskills =  array();
            }

            $team = Team::find($team_id);

            $skills = Skill::where('is_active',1)->get();
            return view('front.profile.teams.list')->withUsers($users->latest()->paginate(15))->withSkills($skills)->withTargetskills($targetskills)->withTeamid($team_id)->withTeam($team);
        }
    }

    public function addUserToTeam(Request $request)
    {



        $id = $request->id;
        $teamid = $request->team_id;

        $user = User::findorfail($id);
        $team = Team::findorfail($teamid);

        if ($team->hasUser($id)) {
            Session::flash('status', __('file.danger'));
            Session::flash('message', __('file.user_already_added_to_team'));
            return redirect::back();
        }

        //$team = Auth::user()->team;
        //$team->users()->detach();
        $team->users()->attach([$id=> ['is_approved'=>'0','note'=>__('file.invitation_sent')]]);

        $user->notify(new \App\Notifications\Database\TeamRequest($team));
        $team->user->notify(new \App\Notifications\Database\TeamRequest($team));

        if (Auth::user()->usersettings && Auth::user()->usersettings->team_notifications)
        {
            Auth::user()->notify(new TeamRequest($team));
            $team->user->notify(new TeamRequest($team));
        } 

        Session::flash('status', __('file.success'));
        Session::flash('message', __('file.add_user_to_team'));
        return redirect::back();
    }


    public function DeleteUser(Request $request)
    {
        $id = $request->id;
        $teamid = $request->team_id;

        $user = User::findorfail($id);
        $team = Team::findorfail($teamid);

        $team->users()->detach($id);

        $team->user->notify(new \App\Notifications\Database\TeamRefusedRequest($team));

        if ($team->user->usersettings && $team->user->usersettings->team_notifications)
        {
            $team->user->notify(new TeamRefusedRequest($team));
        } 

    
        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.invitation_refused'));
        return redirect::back();

    }

    public function refusedRequest(Request $request)
    {
        $id = $request->id;

        $team = Team::findorfail($id);
        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'2','note'=>__('file.invitation_refused')]);


        $team->user->notify(new \App\Notifications\Database\TeamRefusedRequest($team));

        if ($team->user->usersettings && $team->user->usersettings->team_notifications)
        {
            $team->user->notify(new TeamRefusedRequest($team));
        } 

    
        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.invitation_refused'));
        return redirect::back();

    }

    public function acceptRequest(Request $request)
    {
        $id = $request->id;

        $team = Team::findorfail($id);
        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'1','note'=>__('file.invitation_accept')]);

        

        $team->user->notify(new \App\Notifications\Database\TeamAcceptRequest($team));

        if (Auth::user()->usersettings && Auth::user()->usersettings->team_notifications)
        {
            $team->user->notify(new TeamAcceptRequest($team));
        } 

        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.invitation_accept'));
        return redirect::back();

    }

    public function cancelRequest(Request $request)
    {
        $id = $request->id;

        $team = Team::findorfail($id);
        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'3','note'=>__('file.invitation_cancel')]);

        $team->user->notify(new \App\Notifications\Database\TeamCancelRequest($team));

        if ($team->user->usersettings && $team->user->usersettings->team_notifications)
        {
            $team->user->notify(new TeamCancelRequest($team));
        } 

        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.invitation_cancel'));
        return redirect::back();

    }


}
