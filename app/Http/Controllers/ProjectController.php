<?php

namespace App\Http\Controllers;

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

use App\Notifications\ProjectCreated;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , Project $projects)
    {

        $projects = $projects->newQuery();

        $projects->where('is_approved',1);


        if ($request->targetskills) {

            $targetskills = $request->targetskills;

            $projects->whereHas('skills', function ($query) use ($targetskills) {
                $query->whereIn('skill_id', $targetskills);
            });
        }


        if ($request->section_id) {

            $section_id = $request->section_id;

            $projects->whereIn('section_id',$section_id);
        }


        if ($projects) {

            if ($request->targetskills) {
                $targetskills = $request->targetskills;
            }else {
                $targetskills =  array();
            }

            $skills = Skill::all();
            $sections = Section::all();

            return view('front.projects.index')->withProjects($projects->latest()->paginate(10))->withSections($sections)->withSkills($skills)->withTargetskills($targetskills);
        }
    }

    public function searchBySkills(Request $request, Project $projects)
    {
        $projects = $projects->newQuery();
        $projects->where('is_approved',1);

        if ($request->skill_id) {

            $skill_id = $request->skill_id;

            $projects->whereHas('skills', function ($query) use ($skill_id) {
                $query->whereIn('skill_id', $skill_id);
            });

        }
        if ($request->section_id) {

            $section_id = $request->section_id;

            $projects->whereIn('section_id',$section_id);
        }


        return view('front.projects._search')->withProjects($projects->latest()->paginate(1));
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

        $stages = Stage::where('is_active', 1)->get();
        $skills = Skill::all();
        $averagekinds= Averagekind::all();
        $sections= Section::all();
        $apply_kinds=Applykind::all();
        $levels=Level::all();
        $reward_kinds=Rewardkind::all();
        $cost_kinds=Costkind::all();
        $readiness_kinds=Readinesskind::all();

        return view('front.projects.create',compact('skills','averagekinds','sections','apply_kinds','levels','reward_kinds','cost_kinds','readiness_kinds','stages'));
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


            $phase = new Phase;
            $phase->target_clients=(int)$request->target_clients;
            $phase->target_sales=(int)$request->target_sales;
            $phase->target_profits=(int)$request->target_profits;
            $phase->readinesskind_id=$request->readinesskind_id;
            $phase->next_status=$request->next_status;
            $phase->date=$request->date;
            $phase->project_id=$project->id;
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
                    $destinationPath = public_path('/uploads/');
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

        }

        Auth::user()->notify(new ProjectCreated($project));

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return view('front.projects.success');

    }


    public function success()
    {
        return view('front.projects.success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);

        if (!$project || Auth::user() && count(Auth::user()->roles) == 0) {
            return view('front.errors.notfound');
        }

        return view('front.projects.show')->withProject($project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->isEntrepreneur() || !Auth::user()->isActive()  ) {
            return view('front.errors.denied');
        }

        $result=Project::find($id);
        $stages = Stage::where('is_active', 1)->get();
        $averagekinds= Averagekind::all();
        $sections= Section::all();
        $apply_kinds=Applykind::all();
        $reward_kinds=Rewardkind::all();
        $cost_kinds=Costkind::all();
        $readiness_kinds=Readinesskind::all();

        return view('front.projects.edit',compact('result','averagekinds','sections','apply_kinds','reward_kinds','cost_kinds','readiness_kinds','stages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
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


        return redirect(route('account.profile'))->with('flash_message','تم تعديل المشروع بنجاح');
    }

    /**
     * delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Auth::user() && Auth::user()->isEntrepreneur() == 1)
        {
            $data= Project::find($id);
            $data->deleted_at = now();
            $data->save();
            return redirect()->back()->with('flash_message','تم الحذف بنجاح');
        }
        else
        {
            return redirect()->back()->with('flash_message','عفوا غير مسموح لك بهذا الاجراء');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
