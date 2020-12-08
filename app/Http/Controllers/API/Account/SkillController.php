<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;

use App\Skill;
use Illuminate\Http\Request;

use App\Log;
use Auth;
use Redirect;
use Session;

use App\Notifications\SkillCreated;
use App\Notifications\SkillUpdated;
use App\Notifications\SkillDeleted;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        return view('front.profile.skills.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $id)
    {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        $skill = Skill::find($id);

        Auth::user()->skills()->detach($id);

        if ($skill) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'datach';
            $log->model    = 'skill';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        Auth::user()->notify(new \App\Notifications\Database\SkillUpdated($team));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new SkillUpdated($skill));
        }

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));
        return redirect::to('/user/'.Auth::user()->id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
