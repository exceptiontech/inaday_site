<?php

namespace App\Http\Controllers\API\Account;

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
use App\ModelLog;
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


        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $services = Service::where('user_id',Auth::user()->id)->with('user','user.userdetails','skills','section','reviews','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $services;


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
    


        function convert($string) {
            $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
            $num = range(9, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }

        $validator = Validator::make($request->all(), [
            'title'     =>'required|min:3|max:100|string',
            'desc'      =>'required|min:3|max:500',
            'cost'      =>'integer|required',
            'duration'  =>'required|numeric|min:1|max:24',
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:8048',
        ]);




        if ($validator->fails()) {

            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
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

            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'create';
            $model_log->model_type   = 'service';
            $model_log->model_id     = $service->id;
            $model_log->desc         = __('file.create_service');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();


            $skills = $request->skills;

            if ($skills) {
                foreach ($skills as $skill) {
                    $service->skills()->attach($skill);
                }
            }



            $other_skill = $request->other_skill;

            if ($other_skill) {
                $item = Skill::where('title', 'like', '%' . $other_skill . '%')->orWhere('slug', 'like', '%' . $other_skill . '%')->first();


                if ($item) {
                    $service->skills()->attach($item);
                }else {

                    $title = array();
                    $title['ar'] = $other_skill;
                    $new_skill = new Skill;
                    $new_skill->title = $title;
                    $new_skill->slug = $other_skill;
                    $new_skill->is_active = 0;
                    $new_skill->save();

                    $service->skills()->attach($new_skill);
                }
            }

        }

        Auth::user()->notify(new \App\Notifications\Database\ServiceCreated($service));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ServiceCreated($service));
        }

        $services = Service::where('user_id',Auth::user()->id)->with('user','user.userdetails','skills','section','reviews','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $services;


        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);



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
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }
        elseif(is_null(Service::where('user_id',Auth::id())->first()) == 1)
        {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $validator = Validator::make($request->all(), [
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'cost'      =>'required|max:10',
            'duration'  =>'required|max:8',
            //'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);


        if ($validator->fails()) {

            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

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


            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'update';
            $model_log->model_type   = 'service';
            $model_log->model_id     = $service->id;
            $model_log->desc         = __('file.update_service');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();

            //skills
            $service->skills()->sync($request->skills);

        }

        Auth::user()->notify(new \App\Notifications\Database\ServiceUpdated($service));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ServiceUpdated($service));
        }

        $services = Service::where('user_id',Auth::user()->id)->with('user','user.userdetails','skills','section','reviews','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $services;


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

        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $service= Service::find($id);

            if (!$service->is_approved ) {
                $arr = array("status" => 401, "errorMsg" => 'Unapproved yet ', "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }
            
            if ($service->user_id != Auth::id() ) {
                $arr = array("status" => 401, "errorMsg" => 'UnAuthorised ', "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }

            $service->deleted_at = now();
            $service->save();
        }
        

        Auth::user()->notify(new \App\Notifications\Database\ServiceDeleted($service));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ServiceDeleted($service));
        }

        $services = Service::where('user_id',Auth::user()->id)->with('user','user.userdetails','skills','section','reviews','ModelLogs')->paginate(10);


        $data['status'] = true;
        $data['data'] = $services;


        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }

}
