<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service;
use App\Skill;
use App\File;
use App\ProjectSkill;
use App\Averagekind;
use App\Section;
use App\Applykind;
use App\Level;
use App\Costkind;
use App\Readinesskind;
use App\Rewardkind;
use App\Stage;
use App\Phase;
use App\Log;
use Auth;
use Redirect;
use Session;
use Validator;

use App\Notifications\ServiceCreated;
use App\Notifications\ServiceUpdated;
use App\Notifications\ServiceDeleted;

class ServiceController extends Controller
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
        $applykinds= Applykind::all();

        return view('front.profile.services.index',compact('skills','sections'));
        //return view('front.profile.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        $skills = Skill::where('is_active',1)->get();
        $sections= Section::all();

        return view('front.profile.services.create',compact('skills','sections'));
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
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'cost'      =>'integer|required',
            'duration'  =>'integer|required',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $service= new Service();

        $file = $request->img;

        if ($file) {
            $destinationPath = 'uploads/services';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $service->img = $destinationPath.'/'.$fileName;
        }

        $service->user_id=Auth::id();
        $service->title=$request->title;
        $service->desc=$request->desc;
        $service->cost=convert($request->cost);
        $service->section_id=(int)$request->section_id;
        $service->duration=convert($request->duration);
        $service->is_active=0;
        $service->save();

        if ($service) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'service';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();

            $skills = $request->skills;

            foreach ($skills as $skill) {


                if (is_numeric($skill) && $skill > 0) {
                    $service->skills()->attach($skill);

                }else {

                    $item = Skill::where('title', 'like', '%' . $skill . '%')->orWhere('slug', 'like', '%' . $skill . '%')->first();


                    if ($item) {
                        $service->skills()->attach($item);
                    }else {

                        $title = array();
                        $title['ar'] = $skill;
                        $new_skill = new Skill;
                        $new_skill->title = $title;
                        $new_skill->slug = $skill;
                        $new_skill->is_active = 0;
                        $new_skill->save();

                        $service->skills()->attach($new_skill);
                    }

                }

            }
        }


        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ServiceCreated($service));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('/user/'.Auth::user()->id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        $service=Service::find($id);
        $skills = Skill::where('is_active',1)->get();
        $sections= Section::all();

        return view('front.profile.services.edit',compact('service','skills','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        elseif(is_null(Service::where('user_id',Auth::id())->first()) == 1)
        {
            return view('front.errors.denied');
        }
        $this->validate($request,[
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'cost'      =>'required|max:10',
            'duration'  =>'required|max:8',
            //'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);
        $service= Service::find($id);

        $file = $request->img;
        
        if ($file) {
            $destinationPath = 'uploads/services';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $service->img = $destinationPath.'/'.$fileName;
        }

        $service->user_id=Auth::id();
        $service->title=$request->title;
        $service->desc=$request->desc;
        $service->cost=$request->cost;
        $service->section_id=(int)$request->section_id;
        $service->duration=(int)$request->duration;
        $service->save();

        if ($service) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'service';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();

            //skills
            $service->skills()->sync($request->skills);

        }

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ServiceUpdated($service));
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

        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $service= Service::find($id);
            $service->deleted_at = now();
            $service->save();
        }
        

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ServiceDeleted($service));
        }

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));
        return redirect::to('/user/'.Auth::user()->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
