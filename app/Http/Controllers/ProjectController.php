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
        $projects->where('deleted_at', '=', null);


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


        if ($request->title) {

            $title = $request->title;

            $projects->where('title', 'like', '%' . $title . '%');

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

    }

    /**
     * delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

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
