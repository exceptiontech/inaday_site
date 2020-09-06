<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use App\Experience;
use Illuminate\Http\Request;

use App\Log;
use Auth;
use Redirect;
use Session;

use App\Notifications\ExperienceCreated;
use App\Notifications\ExperienceUpdated;
use App\Notifications\ExperienceDeleted;

class ExperienceController extends Controller
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

        return view('front.profile.experiences.index');
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
        $this->validate($request,[
            'position' => 'required',
            'company' => 'required',
            'desc' => 'required',
            'start_date' => 'required',
        ]);

        $experience = new Experience();
        $experience->user_id=Auth::id();
        $experience->position=$request->position;
        $experience->desc=$request->desc;
        $experience->start_date=$request->start_date;
        $experience->end_date=$request->end_date;
        $experience->save();

        if ($experience) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'experience';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Auth::user()->notify(new ExperienceCreated($experience));

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect('/account/profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        elseif(is_null(Experience::where('user_id',Auth::id())->first()) == 1)
        {
            return view('front.errors.denied');
        }
        $this->validate($request,[
            'position'     =>'required|max:500',
            'company'      =>'required|max:500',
            'desc'      =>'required',
            'start_date'      =>'required|max:10',
        ]);


        $experience= Experience::find($id);
        $experience->user_id=Auth::id();
        $experience->position=$request->position;
        $experience->desc=$request->desc;
        $experience->start_date=$request->start_date;
        $experience->end_date=$request->end_date;
        $experience->save();

        if ($service) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'experience';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();


        }

        Auth::user()->notify(new ExperienceUpdated($service));

        Session::flash('status', __('admin.info'));
        Session::flash('message', __('admin.edit_success'));
        return redirect('/account/profile');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $experience= Experience::find($id);
            $experience->deleted_at = now();
            $experience->save();
        }
        
        Auth::user()->notify(new ExperienceDeleted($experience));


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));
        return redirect('/account/profile');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        //
    }
}
