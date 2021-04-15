<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\ServiceCreated;

use App\Mixture;
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
        $mixtures->where('deleted_at', null);

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

        return response()->json(['data' => $mixtures->with('team','skills','section','users','users.userdetails','team','team.users.userdetails','team.users','services','status')->latest()->paginate(10)], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

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
            $mixture = Mixture::where('id',$id)->with('status','skills','section','team','skills','section','users','users.userdetails','team','team.users.userdetails','team.users','services')->get();
        }else {
            $mixture = Mixture::where('title',$id)->with('status','skills','section','team','skills','section','user','user.userdetails','users','users.userdetails','team','team.users.userdetails','team.users','services')->get();;

        }
        return response()->json(['data' => $mixture], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }



}
