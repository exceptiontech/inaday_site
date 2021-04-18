<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\ServiceCreated;

use App\Service;
use App\Image;
use App\Section;
use App\Skill;
use App\Applykind;
use App\Log;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request , Service $services)
    {


        $services = $services->newQuery();

        $services->where('deleted_at', '=', null);

        $services->where('is_approved',1);

        if ($request->section_id) {

            $section_id = $request->section_id;

            $services->where('section_id',$section_id);

        }


        if ($request->targetskills) {

            $targetskills = $request->targetskills;

            $services->whereHas('skills', function ($query) use ($targetskills) {
                $query->whereIn('skill_id', $targetskills);
            });
        }



        if ($request->title) {

            $title = $request->title;

            $services->where('title', 'like', '%' . $title . '%');

        }

        return response()->json(['data' => $services->with('user','user.userdetails','user.skills','section','reviews','reviews.user','reviews.user.userdetails')->latest()->paginate(10)], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

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
            $service = Service::where('id',$id)->with('skills','section','user','user.userdetails','user.skills','reviews','reviews.user','reviews.user.userdetails')->get();
        }else {
            $service = Service::where('title',$id)->with('skills','section','user','user.userdetails','user.skills','reviews','reviews.user','reviews.user.userdetails')->get();

        }
        return response()->json(['data' => $service], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }



}
