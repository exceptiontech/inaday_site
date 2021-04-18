<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\ProjectCreated;

use App\Project;
use App\offer;

use Auth;

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


        return response()->json(['data' => $projects->with('skills','section','offers','user','user.userdetails','offers.user','offers.user.userdetails','ConfirmOffer','status','booking')->latest()->paginate(10)], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(is_numeric($id)) {
            $project = Project::where('id',$id)->with('status','skills','section','offers','ConfirmOffer','user','user.userdetails','offers.user','offers.user.userdetails')->get();
        }else {
            $project = Project::where('title',$id)->with('status','skills','section','offers','ConfirmOffer','user','user.userdetails','offers.user','offers.user.userdetails')->get();;

        }
        return response()->json(['data' => $project], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function offers($id)
    {

        $offers = Offer::where('project_id',$id)->get();

        return response()->json(['data' => $offers], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            

    }


    



}
