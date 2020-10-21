<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
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
        return view('front.profile.projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (count(Auth::user()->roles) == 0 || !Auth::user()->isEntrepreneur() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {
            Session::flash('status', __('admin.info'));
            Session::flash('message', 'لا بد من تحديث الملف الشخصى لتتمكن من اضافة مشروع');
            return redirect::to('/account/profile/edit');
        }

        $stages = Stage::where('is_active', 1)->get();
        $skills = Skill::where('is_active', 1)->get();
        $averagekinds= Averagekind::where('is_active', 1)->get();
        $sections= Section::where('is_active', 1)->get();
        $applykinds=Applykind::where('is_active', 1)->get();
        $levels=Level::where('is_active', 1)->get();
        $rewardkinds=Rewardkind::where('is_active', 1)->get();
        $costkinds=Costkind::where('is_active', 1)->get();
        $readiness_kinds=Readinesskind::where('is_active', 1)->get();

        return view('front.profile.projects.create',compact('skills','averagekinds','sections','applykinds','levels','rewardkinds','costkinds','readiness_kinds','stages'));

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
            'section_id'      =>'required|integer',
            'applykind_id'      =>'required',
            'num_team'      =>'required',
            'cost'      =>'required',
            'files.*' => 'required|mimes:jpg,jpeg,png,pdf,docx,doc',
            'duration'      =>'required|numeric|min:1|max:24',
            'skills' =>'required|array',
            'skills.*' =>'required|integer'
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
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

            $skills = $request->skills;

            if ($skills) {
                foreach ($skills as $skill) {
                    $project->skills()->attach($skill);
                }
            }



            $other_skill = $request->other_skill;

            if ($other_skill) {
                $item = Skill::where('title', 'like', '%' . $other_skill . '%')->orWhere('slug', 'like', '%' . $skill . '%')->first();


                if ($item) {
                    $project->skills()->attach($item);
                }else {

                    $title = array();
                    $title['ar'] = $skill;
                    $new_skill = new Skill;
                    $new_skill->title = $title;
                    $new_skill->slug = $skill;
                    $new_skill->is_active = 0;
                    $new_skill->save();

                    $project->skills()->attach($new_skill);
                }
            }


        }

        Auth::user()->notify(new \App\Notifications\Database\ProjectCreated($project));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ProjectCreated($project));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', 'تم إنشاء المشروع وستتم مراجعته قريباً من إدارة الموقع');
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
        if (count(Auth::user()->roles) == 0 || !Auth::user()->isEntrepreneur() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        $project =Project::find($id);


        if ($project->user_id != Auth::id() ) {
            return view('front.errors.notfound');
        }

        // if (!$project->is_approved ) {
        //     return view('front.errors.notfound');
        // }

        $stages = Stage::where('is_active', 1)->get();
        $skills = Skill::where('is_active', 1)->get();
        $averagekinds= Averagekind::all();
        $sections= Section::all();
        $applykinds=Applykind::all();
        $levels=Level::all();
        $rewardkinds=Rewardkind::all();
        $costkinds=Costkind::all();
        $readiness_kinds=Readinesskind::all();

        return view('front.profile.projects.edit',compact('project','skills','averagekinds','sections','applykinds','levels','rewardkinds','costkinds','readiness_kinds','stages'));
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
            return view('front.errors.denied');
        }
        elseif(is_null(Project::where('user_id',Auth::id())->first()) == 1)
        {
            return view('front.errors.denied');
        }
        $this->validate($request,[
            'title'      =>'required|max:500',
            'desc'      =>'required',
        ]);


        $project= Project::find($id);
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

            //skills
            $project->skills()->sync($request->skills);

        }

        

        Auth::user()->notify(new \App\Notifications\Database\ProjectUpdated($project));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new ProjectUpdated($project));
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
    public function delete(Request $request ,$id)
    {


        if (Auth::user() && Auth::user()->isEntrepreneur() == 1)
        {
            $project= Project::find($id);

            if (!$project->is_approved ) {
                return view('front.errors.notfound');
            }

            if ($project->user_id != Auth::id() ) {
                return view('front.errors.notfound');
            }

            
            $project->deleted_at = now();
            $project->save();
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
