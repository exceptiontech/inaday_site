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
use App\User;
use App\Log;

use App\Notifications\ProjectApproved;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index')->withProjects($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stages = Stage::where('is_active', 1)->get();
        $skills = Skill::all();
        $averagekinds= Averagekind::all();
        $sections= Section::all();
        $apply_kinds=Applykind::all();
        $levels=Level::all();
        $reward_kinds=Rewardkind::all();
        $cost_kinds=Costkind::all();
        $readiness_kinds=Readinesskind::all();

        $type = 'entrepreneur';

        $users = User::whereHas('roles',function($q) use ($type){
                            $q->where('name', $type);
                        })->get();

        return view('admin.projects.create',compact('skills','averagekinds','sections','apply_kinds','levels','reward_kinds','cost_kinds','readiness_kinds','stages','users'));


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
            'title'      =>'required|max:500',
            'desc'      =>'required',
        ]);


        $project= new Project();
        $project->user_id=Auth::id();
        $project->title=$request->title;
        $project->desc=$request->desc;
        $project->stage_id =$request->stage_id;
        $project->section_id=(int)$request->section_id;
        $project->applykind_id=$request->applykind_id;
        $project->num_team=(int)$request->num_team;
        $project->level_id=$request->level_id;
        $project->averagekind_id=$request->averagekind_id;
        $project->cost=$request->cost;
        $project->costkind_id=$request->costkind_id;
        $project->reward=(int)$request->reward;
        $project->rewardkind_id=$request->rewardkind_id;
        $project->rule=$request->rule;
        $project->is_active=$request->is_active;
        $project->is_approved=$request->is_approved;
        $project->save();

        if ($project) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'project';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();


            $phase = new Phase;
            $phase->target_clients=(int)$request->target_clients;
            $phase->target_sales=(int)$request->target_sales;
            $phase->target_profits=(int)$request->target_profits;
            $phase->readinesskind_id=$request->readinesskind_id;
            $phase->next_status=$request->next_status;
            $phase->date=$request->date;
            $phase->next_status=1;
            $phase->save();

            if ($phase) {
                $log           = new Log;
                $log->user_id  = Auth::user()->id;
                $log->action   = 'create';
                $log->model    = 'stage';
                $log->url      = $request->server()['REQUEST_URI'];
                $log->ip       = $request->server()['REMOTE_ADDR'];
                $log->save();
            }

            $files = $request->hasFile('files');
            if ($files) {
                $i=1;
                foreach($request->file('files') as $file)
                {
                    $file_name = date('Y_m_d_h_i_s_').($request->title).$i.'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads');
                    $filePath = $destinationPath. "/".  $file_name;
                    $file->move($destinationPath, $file_name);
                    //to insert in table file
                    $data_file=new File();
                    $data_file->project_id =$project->id;
                    $data_file->name = $file_name;
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

            foreach ($skills as $skill) {


                if (is_numeric($skill) && $skill > 0) {
                    $project->skills()->attach($skill);

                }else {

                    $item = Skill::where('title', 'like', '%' . $skill . '%')->orWhere('slug', 'like', '%' . $skill . '%')->first();


                    if ($item) {
                        $project->skills()->attach($skill);
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

        }

        if ($project->is_approved) {
            $project->user->notify(new ProjectApproved($project));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/projects');


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

        $project=Project::find($id);
        $stages = Stage::where('is_active', 1)->get();
        $averagekinds= Averagekind::all();
        $sections= Section::all();
        $apply_kinds=Applykind::all();
        $reward_kinds=Rewardkind::all();
        $cost_kinds=Costkind::all();
        $readiness_kinds=Readinesskind::all();
        $skills = Skill::all();

        $userskill = $project->skills->pluck('id','id')->all();

        return view('admin.projects.edit',compact('project','averagekinds','sections','apply_kinds','reward_kinds','cost_kinds','readiness_kinds','stages','skills','userskill'));
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
        $project->is_active=$request->is_active;
        $project->is_approved=$request->is_approved;
        $project->save();

        if ($project) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'project';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();

            $files = $request->hasFile('files');
            if ($files) {
                $i=1;
                foreach($request->file('files') as $file)
                {
                    $file_name = date('Y_m_d_h_i_s_').($request->title).$i.'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads');
                    $filePath = $destinationPath. "/".  $file_name;
                    $file->move($destinationPath, $file_name);
                    //to insert in table file
                    $data_file=new File();
                    $data_file->project_id =$project->id;
                    $data_file->name = $file_name;
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

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/projects');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $project = Project::find($id);
        }else {
            $project = Project::where('slug',$id)->first();
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

        $project->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/projects');
    }
}
