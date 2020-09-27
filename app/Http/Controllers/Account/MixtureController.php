<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mixture;
use App\Service;
use App\Skill;
use App\File;
use App\Section;
use App\Team;
use App\Log;

use Auth;
use Redirect;
use Session;
use Validator;

use App\Notifications\MixtureCreated;
use App\Notifications\MixtureUpdated;
use App\Notifications\MixtureDeleted;


class MixtureController extends Controller
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

        $skills = Skill::where('is_active',1)->get();
        $sections= Section::all();

        return view('front.profile.mixtures.index',compact('skills','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $team = Team::find($id);

        if (!$team || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        if (!Auth::user()->hasOwnTeam($team->id)) {
            return view('front.errors.denied');
        }

        if (!Auth::user()->userdetailComplete()) {
            Session::flash('status', __('admin.info'));
            Session::flash('message', 'لا بد من تحديث الملف الشخصى لتتمكن من اضافة خلطة');
            return redirect::to('/account/profile/edit');
        }

        $skills = Skill::where('is_active',1)->get();
        $sections= Section::all();

        return view('front.profile.mixtures.create',compact('skills','sections','team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        function convert($string) {
            $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
            $num = range(9, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }

        $validator = Validator::make($request->all(), [
            'title'     =>'required|min:3|max:100',
            'desc'      =>'required|min:3|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8048',
            'team_id' => 'required|integer',
            'section_id' => 'required|integer',
            'users.*' => 'required|integer',
            'skills.*' => 'required|integer',
            'services' => 'required|array',
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $mixture= new Mixture();

        $file = $request->image;

        if ($file) {
            $destinationPath = 'uploads/mixtures';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $mixture->image = $destinationPath.'/'.$fileName;
        }

        $mixture->title=$request->title;
        $mixture->desc=$request->desc;
        $mixture->section_id=(int)$request->section_id;
        $mixture->team_id=$request->team_id;

        $cost = 0;
        foreach ($request->services as $service) {
            $cost += $service['cost'];
        }
        $mixture->cost=$cost;

        $duration = 0;
        foreach ($request->services as $service) {
            $duration += $service['duration'];
        }
        $mixture->duration=convert($duration);
        $mixture->is_active=1;
        $mixture->is_approved=0;
        $mixture->save();

        if ($mixture) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'mixture';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();


            //skills 
            $skills = $request->skills;
            if ($skills) {
                foreach ($skills as $skill) {
                    $mixture->skills()->attach($skill);
                }
            }

            //users 
            $users = $request->users;
            if ($users) {
                foreach ($users as $user) {
                    $mixture->users()->attach($user);
                }
            }

            //services
            $services = $request->services;
            if ($services) {
                foreach ($services as $service) {
                    $mixture->services()->attach([$service['id']=> ['cost'=> $service['cost'],'duration'=> $service['duration'] ] ]);
                }
            }
        }


        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new MixtureCreated($mixture));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('/user/'.Auth::user()->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mixture  $mixture
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mixture  $mixture
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        $mixture = Mixture::find($id);
        $skills = Skill::where('is_active',1)->get();
        $sections= Section::all();

        return view('front.profile.mixtures.edit',compact('mixture','skills','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mixture  $mixture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        function convert($string) {
            $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
            $num = range(9, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }


        $mixture = Mixture::find($id);

        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }elseif(!Auth::user()->hasTeam($mixture->id)) {
            return view('front.errors.denied');
        }

        $validator = Validator::make($request->all(), [
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
            'section_id' => 'required|integer',
            'users.*' => 'required|integer',
            'skills.*' => 'required|integer',
            'services' => 'required|array',
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $mixture = Mixture::find($id);

        $file = $request->image;

        if ($file) {
            $destinationPath = 'uploads/mixtures';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $mixture->image = $destinationPath.'/'.$fileName;
        }

        $mixture->title=$request->title;
        $mixture->desc=$request->desc;
        $mixture->section_id=(int)$request->section_id;

        $cost = 0;
        foreach ($request->services as $service) {
            $cost += $service['cost'];
        }
        $mixture->cost=$cost;

        $duration = 0;
        foreach ($request->services as $service) {
            $duration += $service['duration'];
        }
        $mixture->duration=convert($duration);
        $mixture->save();

        if ($mixture) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'mixture';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();

            //skills
            $mixture->skills()->sync($request->skills);


            //users 
            $users = $request->users;

            if ($users) {
                $mixture->users()->detach();
                foreach ($users as $user) {
                    $mixture->users()->attach($user);
                }
            }


            //services
            $services = $request->services;
            if ($services) {
                $mixture->services()->detach();
                foreach ($services as $service) {
                    $mixture->services()->attach([$service['id']=> ['cost'=> $service['cost'],'duration'=> $service['duration'] ] ]);
                }
            }

        }

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new MixtureUpdated($mixture));
        }

        Session::flash('status', __('admin.info'));
        Session::flash('message', __('admin.edit_success'));
        return redirect::to('/user/'.Auth::user()->id);
    }


    /**
     * Delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $mixture = Mixture::find($id);

        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }elseif(!Auth::user()->hasTeam($mixture->id)) {
            return view('front.errors.denied');
        }


        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $mixture->deleted_at = now();
            $mixture->save();
        }
        

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new MixtureDeleted($mixture));
        }

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));
        return redirect::to('/user/'.Auth::user()->id);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mixture  $mixture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mixture $mixture)
    {
        //
    }
}
