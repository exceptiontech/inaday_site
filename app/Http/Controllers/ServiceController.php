<?php

namespace App\Http\Controllers;

use App\Notifications\ServiceCreated;

use App\Service;
use Illuminate\Http\Request;
use App\Image;
use App\Section;
use App\Skill;
use App\Applykind;
use App\Log;
use Auth;

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

        if ($services) {
            if ($request->targetskills) {
                $targetskills = $request->targetskills;
            }else {
                $targetskills =  array();
            }

            $sections = Section::where('is_active',1)->get();
            $skills = Skill::where('is_active',1)->get();
            return view('front.services.index')->withServices($services->latest()->paginate(15))->withSections($sections)->withSkills($skills)->withTargetskills($targetskills);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        $skills = Skill::all();
        $sections= Section::all();
        $applykinds= Applykind::all();

        return view('front.services.create',compact('skills','sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request);
        $this->validate($request,[
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'cost'      =>'required|max:10',
            'duration'  =>'required|max:8',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);

        $service= new Service();
        if ($request->hasFile('img')) {
            $file=$request->file('img');
            $file_name = date('Y_m_d_h_i_s_').($request->title).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $filePath = $destinationPath. "/".  $file_name;
            $file->move($destinationPath, $file_name);
            $service->img = $file_name;
        }

        $service->user_id=Auth::id();
        $service->title=$request->title;
        $service->desc=$request->desc;
        $service->cost=$request->cost;
        $service->section_id=(int)$request->section_id;
        $service->duration=(int)$request->duration;
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
        }

        Auth::user()->notify(new ServiceCreated($service));


        return view('front.services.success');
    }

    public function success()
    {
        // $service = Service::find($id);
        // dd($service);
        return view('front.services.success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $service = Service::find($id);
            if (!$service) {
                $service = Service::where('title',$id)->first();
            }
        }else{
            $service = Service::where('title',$id)->first();
        }
        
        if (!$service  || !$service->user  || count($service->user->userdetail) == 0 || Auth::user() &&  count(Auth::user()->roles) == 0) {
            return view('front.errors.notfound');
        }

        return view('front.services.show')->withService($service);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        $result=Service::find($id);
        $skills = Skill::all();
        $sections= Section::all();

        return view('front.services.edit',compact('result','skills','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }
        elseif(is_null(Service::where('user_id',Auth::id())->first()) == 1)
        {
            return view('front.errors.denied');
        }
        $this->validate($request,[
            'title'     =>'required|max:500',
            'desc'      =>'required|max:500',
            'cost'      =>'required|max:10',
            'duration'  =>'required|max:8',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048'
        ]);
        $service= Service::find($id);
        if ($request->hasFile('img')) {
            $file=$request->file('img');
            $file_name = date('Y_m_d_h_i_s_').($request->title).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $filePath = $destinationPath. "/".  $file_name;
            $file->move($destinationPath, $file_name);
            $service->img = $file_name;
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
        }
        return redirect(route('account.profile'))->with('flash_message','تم تعديل الخدمه بنجاح');
    }
    /**
     * delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $data= Service::find($id);
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
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
