<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mixture;
use App\Service;
use App\Skill;
use App\File;
use App\Section;
use App\Team;
use App\Log;
use App\ModelLog;

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


            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }

        $id = Auth::user()->id;
        $mixtures = Mixture::whereHas('team', function ($query) use ($id) {
                $query->where('user_id' , $id);
            })->with('skills','section','users','services','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $mixtures;

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

        function convert($string) {
            $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
            $num = range(9, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }

        $validator = Validator::make($request->all(), [
            'title'     =>'required|min:3|max:100|string',
            'desc'      =>'required|min:3|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8048',
            'team_id' => 'required|integer',
            'section_id' => 'required|integer',
            'users.*' => 'required|integer',
            'skills.*' => 'required|integer',
            'services' => 'required|array',
        ]);


        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
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



            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'create';
            $model_log->model_type   = 'mixture';
            $model_log->model_id     = $mixture->id;
            $model_log->desc         = __('file.create_mixture');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();


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

        Auth::user()->notify(new \App\Notifications\Database\MixtureCreated($mixture));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new MixtureCreated($mixture));
        }


        $id = Auth::user()->id;
        $mixtures = Mixture::whereHas('team', function ($query) use ($id) {
                $query->where('user_id' , $id);
            })->with('skills','section','users','services','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $mixtures;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

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
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }elseif(!Auth::user()->hasTeam($mixture->team->id)) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
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
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
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


            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'update';
            $model_log->model_type   = 'mixture';
            $model_log->model_id     = $mixture->id;
            $model_log->desc         = __('file.update_mixture');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();

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
        
        Auth::user()->notify(new \App\Notifications\Database\MixtureUpdated($mixture));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new MixtureUpdated($mixture));
        }


        $id = Auth::user()->id;
        $mixtures = Mixture::whereHas('team', function ($query) use ($id) {
                $query->where('user_id' , $id);
            })->with('skills','section','users','services','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $mixtures;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);
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

        if (!$mixture) {
            $arr = array("status" => 401, "errorMsg" => 'notfound', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }elseif(!Auth::user()->hasTeam($mixture->team->id)) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $mixture->deleted_at = now();
            $mixture->save();
        }
        
        Auth::user()->notify(new \App\Notifications\Database\MixtureDeleted($mixture));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new MixtureDeleted($mixture));
        }


        $id = Auth::user()->id;
        $mixtures = Mixture::whereHas('team', function ($query) use ($id) {
                $query->where('user_id' , $id);
            })->with('skills','section','users','services','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $mixtures;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }


}
