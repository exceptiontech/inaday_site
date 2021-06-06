<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\Skill;
use App\Offer;
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
use App\ModelLog;

use App\Notifications\ProjectCreated;
use App\Notifications\ProjectUpdated;
use App\Notifications\ProjectDeleted;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Auth::user()->isEntrepreneur() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {

            $arr = array("status" => 402, "errorMsg" => __('api.un_updated_profile'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $projects = Project::where('user_id',Auth::user()->id)->with('skills','section','ModelLogs','offers','offers.user','offers.user.userdetails','offers.team','ConfirmOffer','status')->paginate(10);


        $data['status'] = 200;
        $data['data'] = $projects;

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
        

        if (!Auth::user()->isEntrepreneur() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        function convert($string) {
            $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
            $num = range(9, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }


        $validator = Validator::make($request->all(), [
            'title'     =>'required|min:3|max:100|string|unique:projects',
            'desc'      =>'required|min:3|max:500',
            'section_id'      =>'required|integer',
            'applykind_id'      =>'required|integer',
            'num_team'      =>'required|integer',
            'cost'      =>'required|integer',
            'files' => 'required',
            'files.*' => 'required|mimes:jpg,jpeg,png,pdf,docx,doc',
            'duration'      =>'required|numeric|min:1|max:24',
            //'skills' =>'required|array',
            //'skills.*' =>'required|integer'
        ]);


        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        $project= new Project();
        $project->user_id=Auth::id();
        $project->title=$request->title;
        $project->desc=$request->desc;
        $project->stage_id =$request->stage_id;
        $project->section_id=(int)$request->section_id;
        $project->applykind_id=$request->applykind_id;
        $project->num_team=convert($request->num_team);
        $project->level_id=$request->level_id;
        $project->averagekind_id=$request->averagekind_id;
        $project->cost=convert($request->cost);
        $project->duration=$request->duration;
        $project->costkind_id=$request->costkind_id;
        $project->reward=$request->reward;
        $project->rewardkind_id=$request->rewardkind_id;
        $project->rule=$request->rule;
        $project->is_active=0;
        $project->save();

        if ($project) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'project';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();


            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'create';
            $model_log->model_type   = 'project';
            $model_log->model_id     = $project->id;
            $model_log->desc         = __('file.create_project');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();

            // $phase = new Phase;
            // $phase->target_clients=convert($request->target_clients);
            // $phase->target_sales=convert($request->target_sales);
            // $phase->target_profits=convert($request->target_profits);
            // $phase->readinesskind_id=$request->readinesskind_id;
            // $phase->next_status=0;
            // $phase->date=$request->date;
            // $phase->project_id=$project->id;
            // $phase->save();

            // if ($phase) {
            //     $log           = new Log;
            //     $log->user_id  = Auth::user()->id;
            //     $log->action   = 'create';
            //     $log->model    = 'phase';
            //     $log->url      = $request->server()['REQUEST_URI'];
            //     $log->ip       = $request->server()['REMOTE_ADDR'];
            //     $log->save();
            // }

            $files = $request->files;
            if ($files) {
                $i=1;
                foreach($files as $file)
                {
                    $destinationPath = 'uploads/projects';
                    $extension =  $file->getClientOriginalExtension();
                    $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
                    $upload_success = $file->move($destinationPath, $fileName);

                    //to insert in table file
                    $data_file=new File();
                    $data_file->type ='project';
                    $data_file->project_id =$project->id;
                    $data_file->name = $fileName;
                    $data_file->url = $destinationPath.'/'.$fileName;
                    $data_file->save();

                    if ($data_file) {
                        $log           = new Log;
                        $log->user_id  = Auth::user()->id;
                        $log->action   = 'create';
                        $log->model    = 'file in project'.$project->id;
                        $log->url      = $request->server()['REQUEST_URI'];
                        $log->ip       = $request->server()['REMOTE_ADDR'];
                        $log->save();
                    }
                    $i++;
                }
            }


        }

        Auth::user()->notify(new \App\Notifications\Database\ProjectCreated($project));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ProjectCreated($project));
        }


        $projects = Project::where('user_id',Auth::user()->id)->with('skills','section','ModelLogs','offers','offers.user','offers.user.userdetails','offers.team','ConfirmOffer','status')->paginate(10);

        $data['status'] = 200;
        $data['data'] = $projects;

        return \Response::json($data);

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



        if (!Auth::user()->isEntrepreneur() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }
        elseif(is_null(Project::where('user_id',Auth::id())->first()) == 1)
        {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $validator = Validator::make($request->all(), [
            'title'     =>'required|min:3|max:100|string|unique:projects,id',
            'desc'      =>'required|min:3|max:500',
            'section_id'      =>'required|integer',
            'applykind_id'      =>'required|integer',
            'num_team'      =>'required|integer',
            'cost'      =>'required|integer',
            'files' => 'required',
            'files.*' => 'required|mimes:jpg,jpeg,png,pdf,docx,doc',
            'duration'      =>'required|numeric|min:1|max:24',
        ]);


        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $project= Project::find($id);

        if (!$project) {
            $arr = array("status" => 404, "errorMsg" => __('api.not_found'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

       if ($project->deleted_at) {
            $arr = array("status" => 404, "errorMsg" => __('api.alreadyـdeleted'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }
            
        $project->title=$request->title;
        $project->desc=$request->desc;
        $project->stage_id =$request->stage_id;
        $project->section_id=(int)$request->section_id;
        $project->applykind_id=$request->applykind_id;
        $project->num_team=(int)$request->num_team;
        $project->averagekind_id=$request->averagekind_id;
        $project->cost=$request->cost;
        $project->costkind_id=$request->costkind_id;
        $project->reward=(int)$request->reward;
        $project->rewardkind_id=$request->rewardkind_id;
        $project->rule=$request->rule;
        $project->save();

        if ($project) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'project';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();


            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'update';
            $model_log->model_type   = 'project';
            $model_log->model_id     = $project->id;
            $model_log->desc         = __('file.update_project');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();


            if (count($project->phases) > 0) {

                foreach ($project->phases as $phase) {

                    $phase = Phase::find($phase->id);
                    $phase->target_clients=(int)$request->target_clients;
                    $phase->target_sales=(int)$request->target_sales;
                    $phase->target_profits=(int)$request->target_profits;
                    $phase->readinesskind_id=$request->readinesskind_id;
                    $phase->next_status=0;
                    $phase->date=$request->date;
                    $phase->project_id=$project->id;
                    $phase->save();

                    if ($phase) {
                        $log           = new Log;
                        $log->user_id  = Auth::user()->id;
                        $log->action   = 'create';
                        $log->model    = 'phase';
                        $log->url      = $request->server()['REQUEST_URI'];
                        $log->ip       = $request->server()['REMOTE_ADDR'];
                        $log->save();
                    }
                }
            }


            $files = $request->files;
            if ($files) {
                $i=1;
                foreach($files as $file)
                {

                    $destinationPath = 'uploads/projects';
                    $extension =  $file->getClientOriginalExtension();
                    $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
                    $upload_success = $file->move($destinationPath, $fileName);

                    //to insert in table file
                    $data_file=new File();
                    $data_file->type ='project';
                    $data_file->project_id =$project->id;
                    $data_file->name = $fileName;
                    $data_file->url = $destinationPath.'/'.$fileName;
                    $data_file->save();

                    if ($data_file) {
                        $log           = new Log;
                        $log->user_id  = Auth::user()->id;
                        $log->action   = 'create';
                        $log->model    = 'file in project'.$project->id;
                        $log->url      = $request->server()['REQUEST_URI'];
                        $log->ip       = $request->server()['REMOTE_ADDR'];
                        $log->save();
                    }
                    $i++;
                }
            }


        }

        

        Auth::user()->notify(new \App\Notifications\Database\ProjectUpdated($project));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ProjectUpdated($project));
        }

        $projects = Project::where('user_id',Auth::user()->id)->with('skills','section','ModelLogs','offers','offers.user','offers.user.userdetails','offers.team','ConfirmOffer','status')->paginate(10);

        $data['status'] = 200;
        $data['data'] = $projects;

        return \Response::json($data);

    }
    /**
     * Delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request ,$id)
    {


        if (Auth::user() && Auth::user()->isEntrepreneur() == 1)
        {
            $project= Project::find($id);


            if (!$project) {
                $arr = array("status" => 404, "errorMsg" => __('api.not_found'), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }


            if ($project->booking) {
                $arr = array("status" => 401, "errorMsg" => __('api.projectـhaveـbooking') , "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }


            if (!$project->is_approved ) {
                $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }

            if ($project->user_id != Auth::id() ) {
                $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }
            
            $project->deleted_at = now();
            $project->save();

        }else {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        if ($project) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'project';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        Auth::user()->notify(new \App\Notifications\Database\ProjectDeleted($project));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ProjectDeleted($project));
        }

        $projects = Project::where('user_id',Auth::user()->id)->with('skills','section','ModelLogs','offers','ConfirmOffer')->paginate(10);

        $data['status'] = 200;
        $data['data'] = $projects;

        return \Response::json($data);

    }

    public function destroy(Request $request, $id)
    {


        if (Auth::user() && Auth::user()->isEntrepreneur() == 1)
        {


            $project= Project::find($id);


            if (!$project) {
                $arr = array("status" => 404, "errorMsg" => __('api.not_found'), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }


            if ($project->deleted_at) {
                $arr = array("status" => 404, "errorMsg" => __('api.alreadyـdeleted'), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }


            if ($project->booking) {
                $arr = array("status" => 401, "errorMsg" => __('api.projectـhaveـbooking') , "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }


            if (!$project->is_approved ) {
                $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }

            if ($project->user_id != Auth::id() ) {
                $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }
            
            $project->deleted_at = now();
            $project->save();

            if ($project) {
                $log           = new Log;
                $log->user_id  = Auth::user()->id;
                $log->action   = 'delete';
                $log->model    = 'project';
                $log->url      = $request->server()['REQUEST_URI'];
                $log->ip       = $request->server()['REMOTE_ADDR'];
                $log->save();
            

                Auth::user()->notify(new \App\Notifications\Database\ProjectDeleted($project));

                if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
                {
                    Auth::user()->notify(new ProjectDeleted($project));
                }


                $projects = Project::where('user_id',Auth::user()->id)->with('skills','section','ModelLogs','offers','ConfirmOffer')->paginate(10);

                $data['status'] = 200;
                $data['data'] = $projects;

                return \Response::json($data);

            }

            $arr = array("status" => 404, "errorMsg" => __('api.not_found'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);


        }else {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $projects = Project::where('user_id',Auth::user()->id)->with('skills','section','ModelLogs','offers','offers.user','offers.user.userdetails','offers.team','ConfirmOffer','status')->paginate(10);

        $data['status'] = 200;
        $data['data'] = $projects;

        return \Response::json($data);
    }
}
