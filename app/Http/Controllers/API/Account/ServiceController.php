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
            return response()->json(['error' => 'UnAuthorised'], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $services = Service::where('user_id',Auth::user()->id)->paginate(10);


        return response()->json(['data' => $services], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        //return view('front.profile.services.index');
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
            'cost'      =>'integer|required',
            'duration'  =>'required|numeric|min:1|max:24',
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:8048',
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

        return response()->json(['data' => $service], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


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
            return response()->json(['error' => 'UnAuthorised'], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        elseif(is_null(Service::where('user_id',Auth::id())->first()) == 1)
        {
            return response()->json(['error' => 'UnAuthorised'], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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

        return response()->json(['data' => $service], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

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
                return view('front.errors.notfound');
            }
            
            if ($service->user_id != Auth::id() ) {
                return view('front.errors.notfound');
            }

            $service->deleted_at = now();
            $service->save();
        }
        

        Auth::user()->notify(new \App\Notifications\Database\ServiceDeleted($service));

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
