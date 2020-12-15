<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Redirect;
use Input;
use Carbon\Carbon;
use DB;
use Auth;
use Config;
use App;

use App\Mixture;
use App\Team;
use App\Section;
use App\User;
use App\Skill;
use App\Log;
use App\ModelLog;

use App\Notifications\MixtureApproved;
use App\Notifications\MixtureRefused;


class MixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mixtures = Mixture::all();

        return view('admin.mixtures.index')->withMixtures($mixtures);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $mixture = Mixture::find($id);

        $skills = Skill::where('is_active',1)->get();
        $sections= Section::all();

        $team = Team::find($mixture->team_id);


        return view('admin.mixtures.edit')->withMixture($mixture)->withSections($sections)->withSkills($skills)->withTeam($team);
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
        function convert($string) {
            $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
            $num = range(9, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }

        $validator = Validator::make($request->all(), [
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'section_id' => 'required|integer',
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
        $mixture->is_active=$request->is_active;
        $mixture->is_approved=$request->is_approved;
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

        $mixture->team->user->notify(new \App\Notifications\Database\MixtureApproved($mixture));

        if ($mixture->is_approved) {
            $mixture->team->user->notify(new MixtureApproved($mixture));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/mixtures');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $mixture = Mixture::find($id);

        if ($mixture) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'mixture';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $mixture->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/mixtures');
    }



    public function approve($id , Request $request)
    {


        $mixture= Mixture::find($id);        
        $mixture->is_approved= 1;
        $mixture->save();

        if ($mixture->is_approved == 1) {
            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'approve';
            $model_log->model_type   = 'mixture';
            $model_log->model_id     = $mixture->id;
            $model_log->desc         = __('admin.approve_mixture');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();
        }

        $mixture->team->user->notify(new \App\Notifications\Database\MixtureApproved($mixture));

        if ($mixture->is_approved) {
            $mixture->team->user->notify(new MixtureApproved($mixture));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.approve_success'));

        return  redirect::back();

    }

    public function refuse(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'desc'      =>'required|min:3',
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $mixture= Mixture::find($request->model_id);        
        $mixture->is_approved= 0;
        $mixture->save();

        if ($mixture->is_approved == 0) {
            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'refuse';
            $model_log->model_type   = 'mixture';
            $model_log->model_id     = $mixture->id;
            $model_log->desc         = $request->desc;
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();
        }

        $mixture->team->user->notify(new \App\Notifications\Database\MixtureRefused($mixture));

        $mixture->team->user->notify(new MixtureRefused($mixture));

        Session::flash('status', __('admin.info'));
        Session::flash('message', __('admin.refuse_success'));

        return  redirect::back();

    }
}
