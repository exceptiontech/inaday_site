<?php

namespace App\Http\Controllers\API\Account;

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
use Validator;

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
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $id = Auth::user()->id;

        $teams = Team::whereHas('allusers', function ($query) use ($id) {
                $query->where('team_user.user_id' , $id);
            })->with('mixtures','user','user.userdetails','users','users.userdetails')->paginate(10);


        $data['status'] = true;
        $data['data'] = $teams;


        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $validator = Validator::make($request->all(), [
            'title'     =>'required|min:3|max:100|string',
            'desc'      =>'required|min:3|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

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

        $id = Auth::user()->id;
        $myteams = Team::where('user_id' , $id)->with('mixtures','user','user.userdetails','users','users.userdetails')->paginate(10);

        $data['status'] = true;
        $data['data'] = $myteams;


        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);
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
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }
        elseif(is_null(Team::where('user_id',Auth::id())->first()) == 1)
        {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
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

        $id = Auth::user()->id;
        $myteams = Team::where('user_id' , $id)->with('mixtures','user','user.userdetails','users','users.userdetails')->paginate(10);

        $data['status'] = true;
        $data['data'] = $myteams;


        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

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

        $id = Auth::user()->id;
        $myteams = Team::where('user_id' , $id)->with('mixtures','user','user.userdetails','users','users.userdetails')->paginate(10);

        $data['status'] = true;
        $data['data'] = $myteams;


        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

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


        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $id = Auth::user()->id;
        $myteams = Team::where('user_id' , $id)->with('mixtures','user','user.userdetails','users','users.userdetails')->paginate(10);

        $data['status'] = true;
        $data['data'] = $myteams;


        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }


    public function listServicesProvider(Request $request , $team_id ,User $users)
    {



        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

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


            $users = $users->with('skills','userdetails','allteams')->latest()->paginate(15);

            $data['status'] = true;
            $data['data']['users'] = $users;
            $data['data']['skills'] = $skills;
            $data['data']['targetskills'] = $targetskills;
            $data['data']['team_id'] = $team_id;
            $data['data']['team'] = $team;


            $arr = array("status" => 200,"data" => $data);
            return \Response::json(['data'=> $arr]);

            //return view('front.profile.teams.list')->withUsers($users->latest()->paginate(15))->withSkills($skills)->withTargetskills($targetskills)->withTeamid($team_id)->withTeam($team);
        }
    }

    public function addUserToTeam(Request $request)
    {
        

        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $id = $request->id;
        $teamid = $request->teamid;

        $user = User::find($id);
        $team = Team::find($teamid);

        if (!$user ||  !$team ) {
            $arr = array("status" => 402, "errorMsg" => 'one of the parameters is wrong', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        if ($team->hasUser($id)) {
            $arr = array("status" => 401, "errorMsg" => 'user already in your team', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        if ($team->hasUserGlobal($id)) {
            $arr = array("status" => 401, "errorMsg" => 'you can not add this user because he was refured your invitation before', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
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

        //$data['status'] = true;
        $arr = array("status" => true, "success" => 'already sent', "data" => array(),"appearForUser" => true);

        return \Response::json(['data'=> $arr]);
    }


    public function DeleteUser(Request $request)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $id = $request->id;
        $teamid = $request->teamid;

        $user = User::find($id);
        $team = Team::find($teamid);

        if (!$user ||  !$team ) {
            $arr = array("status" => 402, "errorMsg" => 'one of the parameters is wrong', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        $team->users()->detach($id);

        $team->user->notify(new \App\Notifications\Database\TeamRefusedRequest($team));

        if ($team->user->usersettings && $team->user->usersettings->team_notifications)
        {
            $team->user->notify(new TeamRefusedRequest($team));
        } 

    
        $arr = array("status" => true, "success" => 'deleted successfully', "data" => array(),"appearForUser" => true);

        return \Response::json(['data'=> $arr]);

    }

    public function refusedRequest(Request $request)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        $id = $request->id;
        $teamid = $request->teamid;

        $team = Team::find($teamid);

        if ( !$team ) {
            $arr = array("status" => 402, "errorMsg" => 'one of the parameters is wrong', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'2','note'=>__('file.invitation_refused')]);


        $team->user->notify(new \App\Notifications\Database\TeamRefusedRequest($team));

        if ($team->user->usersettings && $team->user->usersettings->team_notifications)
        {
            $team->user->notify(new TeamRefusedRequest($team));
        } 

    
        $arr = array("status" => true, "success" => 'refused successfully', "data" => array(),"appearForUser" => true);

        return \Response::json(['data'=> $arr]);

    }

    public function acceptRequest(Request $request)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        $id = $request->id;
        $teamid = $request->teamid;

        $team = Team::find($teamid);

        if ( !$team ) {
            $arr = array("status" => 402, "errorMsg" => 'one of the parameters is wrong', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'1','note'=>__('file.invitation_accept')]);

        

        $team->user->notify(new \App\Notifications\Database\TeamAcceptRequest($team));

        if (Auth::user()->usersettings && Auth::user()->usersettings->team_notifications)
        {
            $team->user->notify(new TeamAcceptRequest($team));
        } 

        $arr = array("status" => true, "success" => 'accpeted successfully', "data" => array(),"appearForUser" => true);

        return \Response::json(['data'=> $arr]);

    }

    public function cancelRequest(Request $request)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        $id = $request->id;
        $teamid = $request->teamid;

        $team = Team::find($teamid);

        if ( !$team ) {
            $arr = array("status" => 402, "errorMsg" => 'one of the parameters is wrong', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'3','note'=>__('file.invitation_cancel')]);

        $team->user->notify(new \App\Notifications\Database\TeamCancelRequest($team));

        if ($team->user->usersettings && $team->user->usersettings->team_notifications)
        {
            $team->user->notify(new TeamCancelRequest($team));
        } 

        $arr = array("status" => true, "success" => 'canceled successfully', "data" => array(),"appearForUser" => true);

        return \Response::json(['data'=> $arr]);

    }


}
