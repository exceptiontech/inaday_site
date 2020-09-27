<?php

namespace App\Http\Controllers;

use App\Notifications\MixtureCreated;

use App\Mixture;
use Illuminate\Http\Request;
use App\Image;
use App\Section;
use App\Skill;
use App\Applykind;
use App\Log;
use Auth;

class MixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , Mixture $mixtures)
    {

        $mixtures = $mixtures->newQuery();

        $mixtures->where('is_approved',1);
        $mixtures->where('deleted_at', '=', null);

        if ($request->section_id) {

            $section_id = $request->section_id;

            $mixtures->where('section_id',$section_id);

        }


        if ($request->targetskills) {

            $targetskills = $request->targetskills;

            $mixtures->whereHas('skills', function ($query) use ($targetskills) {
                $query->whereIn('skill_id', $targetskills);
            });
        }



        if ($request->title) {

            $title = $request->title;

            $mixtures->where('title', 'like', '%' . $title . '%');

        }

        if ($mixtures) {
            if ($request->targetskills) {
                $targetskills = $request->targetskills;
            }else {
                $targetskills =  array();
            }

            $sections = Section::where('is_active',1)->get();
            $skills = Skill::where('is_active',1)->get();
            return view('front.mixtures.index')->withMixtures($mixtures->latest()->paginate(15))->withSections($sections)->withSkills($skills)->withTargetskills($targetskills);
        }
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

    }

    public function success()
    {
        // $Mixture = Mixture::find($id);
        // dd($Mixture);
        return view('front.Mixtures.success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mixture  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $mixture = Mixture::findorfail($id);
            if (!$mixture) {
                $mixture = Mixture::where('title',$id)->first();
            }
        }else{
            $mixture = Mixture::where('title',$id)->first();
        }
        
        if (!$mixture  || !$mixture->team  ||  Auth::user() &&  count(Auth::user()->roles) == 0) {
            return view('front.errors.notfound');
        }

        return view('front.mixtures.show')->withMixture($mixture);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mixture  $Mixture
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mixture  $Mixture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }
    /**
     * delete the specified resource from storage.
     *
     * @param  \App\Mixture  $Mixture
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mixture  $Mixture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mixture $Mixture)
    {
        //
    }
}
