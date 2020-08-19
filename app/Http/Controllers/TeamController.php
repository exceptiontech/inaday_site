<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;


use App\Team;
use Illuminate\Http\Request;
use App\Image;
use App\Section;
use App\Skill;
use App\Applykind;
use App\Log;
use App\User;
use Auth;
use Socialite;
use URL;
use Redirect;
use Session;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        return view('front.teams.create');
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
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048'
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

        return view('front.teams.success');
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
        return view('front.teams.edit',compact('team'));
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

        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.success'));        
        return redirect::to('/account/profile');
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


    public function listServicesProvider(Request $request , User $users)
    {

        $users = $users->newQuery();


        //check roles
        $role = 'services_provider';
        $users->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            });


        //check exists team member
        // $team = Auth::user()->team->id;
        // $users->whereHas('teams', function ($query) use ($team) {
        //         $query->where('team_id', '==' , $team);
        //     });

        // not team owner
        //$users->where('id','!=',Auth::user()->id);

        if ($request->skill_id) {
            $skill_id = $request->skill_id;

            $users->whereHas('skills', function ($query) use ($skill_id) {
                $query->where('skill_id', $skill_id);
            });
        }

        if ($request->name) {

            $name = $request->name;
            $users->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');

        }


        if ($users) {

            $skills = Skill::where('is_active',1)->get();
            return view('front.teams.list')->withUsers($users->latest()->paginate(15))->withSkills($skills);
        }
    }

    public function addUserToTeam(Request $request)
    {
        $id = $request->id;

        if (Auth::user()->team->hasUser($id)) {
            Session::flash('status', __('file.danger'));
            Session::flash('message', __('file.user_already_added_to_team'));
            return redirect::back();
        }

        $team = Auth::user()->team;
        $team->users()->attach([$id=> ['is_approved'=>'0','note'=>__('file.invitation_sent')]]);

        Session::flash('status', __('file.success'));
        Session::flash('message', __('file.add_user_to_team'));
        return redirect::back();
    }

    public function refusedRequest(Request $request)
    {
        $id = $request->id;

        $team = Team::findorfail($id);
        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'2','note'=>__('file.invitation_refused')]);

        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.invitation_refused'));
        return redirect::back();

    }

    public function acceptRequest(Request $request)
    {
        $id = $request->id;

        $team = Team::findorfail($id);
        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'1','note'=>__('file.invitation_accept')]);

        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.invitation_accept'));
        return redirect::back();

    }

    public function cancelRequest(Request $request)
    {
        $id = $request->id;

        $team = Team::findorfail($id);
        $team->users()->updateExistingPivot(Auth::user(), ['is_approved'=>'3','note'=>__('file.invitation_cancel')]);

        Session::flash('status', __('file.info'));
        Session::flash('message', __('file.invitation_cancel'));
        return redirect::back();

    }


}
