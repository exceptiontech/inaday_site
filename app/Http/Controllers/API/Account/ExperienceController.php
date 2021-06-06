<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;

use App\Experience;
use App\Usersettings;
use Illuminate\Http\Request;

use App\Log;
use Auth;
use Validator;

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

            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => __('api.un_updated_profile'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        $experiences = Experience::where('user_id',Auth::user()->id)->paginate(10);

        $data['status'] = 200;
        $data['data'] = $experiences;

        return \Response::json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required',
            'company' => 'required',
            'desc' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        $experience = new Experience();
        $experience->user_id=Auth::id();
        $experience->position=$request->position;
        $experience->company=$request->company;
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


        Auth::user()->notify(new \App\Notifications\Database\ExperienceCreated($experience));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ExperienceCreated($experience));
        }

        $experiences = Experience::where('user_id',Auth::user()->id)->paginate(10);

        $data['status'] = 200;
        $data['data'] = $experiences;

        return \Response::json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {

            $arr = array("status" => 401, "errorMsg" =>  __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }
        elseif(is_null(Experience::where('user_id',Auth::id())->first()) == 1)
        {
            $arr = array("status" => 401, "errorMsg" =>  __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }



        $validator = Validator::make($request->all(), [
            'position'     =>'required|min:3|max:500',
            'company'      =>'required|min:3|max:500',
            'desc'      =>'required|min:3|max:500',
            'start_date'      =>'required|max:10',
        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $experience= Experience::find($id);
        $experience->user_id=Auth::id();
        $experience->position=$request->position;
        $experience->desc=$request->desc;
        $experience->company=$request->company;
        $experience->start_date=$request->start_date;
        $experience->end_date=$request->end_date;
        $experience->save();

        if ($experience) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'experience';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Auth::user()->notify(new \App\Notifications\Database\ExperienceUpdated($experience));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ExperienceUpdated($experience));
        }



        $experiences = Experience::where('user_id',Auth::user()->id)->paginate(10);

        $data['status'] = 200;
        $data['data'] = $experiences;

        return \Response::json($data);

    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $experience= Experience::find($id);

        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {

            $arr = array("status" => 401, "errorMsg" =>  __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }
        elseif(is_null(Experience::where('user_id',Auth::id())->first()) == 1)
        {
            $arr = array("status" => 401, "errorMsg" =>  __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }



        if (!$experience) {
            $arr = array("status" => 404, "errorMsg" => __('api.not_found'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        if ($experience->deleted_at) {
            $arr = array("status" => 404, "errorMsg" => __('api.alreadyـdeleted'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $experience->deleted_at = now();
            $experience->save();

            if ($experience) {
                $log           = new Log;
                $log->user_id  = Auth::user()->id;
                $log->action   = 'delete';
                $log->model    = 'experience';
                $log->url      = $request->server()['REQUEST_URI'];
                $log->ip       = $request->server()['REMOTE_ADDR'];
                $log->save();
            }
        }
        

        Auth::user()->notify(new \App\Notifications\Database\ExperienceDeleted($experience));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ExperienceDeleted($experience));
        }



        $experiences = Experience::where('user_id',Auth::user()->id)->paginate(10);

        $data['status'] = 200;
        $data['data'] = $experiences;

        return \Response::json($data);

    }


}
