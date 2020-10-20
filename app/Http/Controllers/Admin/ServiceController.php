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

use App\Service;
use App\Section;
use App\User;
use App\Skill;
use App\Log;
use App\ModelLog;


use App\Notifications\ServiceApproved;
use App\Notifications\ServiceRefused;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $services = Service::all();

        return view('admin.services.index')->withServices($services);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections= Section::all();
        $skills = Skill::all();
        $type = 'services_provider';

        $users = User::whereHas('roles',function($q) use ($type){
                            $q->where('name', $type);
                        })->get();


        return view('admin.services.create')->withSections($sections)->withSkills($skills)->withUsers($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'             => 'required',
            'image'              => 'mimes:jpeg,png,jpg,pdf',
            'desc'              => 'required',
            'is_active'              => 'required',
            'is_approved'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/services/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $service = new service;
        $service->title = $request->title;

        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/services';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $service->image =  $destinationPath.'/'.$fileName;
        }

        $service->desc = $request->desc;
        $service->cost = $request->cost;
        $service->duration = $request->duration;
        $service->section_id = $request->section_id;
        $service->user_id = $request->user_id;
        $service->is_active = $request->is_active;
        $service->is_approved = $request->is_approved;
        $service->save();

        $skills = $request->skills;
        $service->skills()->attach($skills);
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

        // $service->user->notify(new \App\Notifications\Database\ServiceApproved($offer));

        // if ($service->is_approved) {
        //     $service->user->notify(new ServiceApproved($project));
        // }

        $services = Service::all();
        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/services');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $service = Service::where('id',$id)->where('is_active',1)->first();
        }else {
            $service = Service::where('slug',$id)->where('is_active',1)->first();
        }

        $sections= Section::all();

        return view('admin.services.show')->withService($service)->withSections($sections);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $service = Service::find($id);
        }else {
            $service = Service::where('slug',$id)->first();
        }

        $sections= Section::all();
        $skills = Skill::all();

        $userskill = $service->skills->pluck('id','id')->all();


        return view('admin.services.edit')->withService($service)->withSections($sections)->withSkills($skills)->withUserskill($userskill);
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
        $validator = Validator::make($request->all(), [
            'title'             => 'required',
            'desc'              => 'required',
            'is_active'              => 'required',
            'is_approved'              => 'required',

        ]);

        if ($validator->fails()) {
            return redirect('admin/services/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $service = Service::find($id);

        $service->title = $request->title;


        if (isset($file)) {
            $destinationPath = 'uploads/services';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $service->image =  $destinationPath.'/'.$fileName;
        }

        $service->desc = $request->desc;
        $service->cost = $request->cost;
        $service->duration = $request->duration;
        $service->section_id = $request->section_id;
        $service->is_active = $request->is_active;
        $service->is_approved = $request->is_approved;
        $service->save();

        $skills = $request->skills;
        $service->skills()->attach($skills);

        if ($service) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'service';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        $service->user->notify(new \App\Notifications\Database\ServiceApproved($service));

        if ($service->is_approved) {
            $service->user->notify(new ServiceApproved($service));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/services');
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
            $service = Service::find($id);
        }else {
            $service = Service::where('slug',$id)->first();
        }

        if ($service) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'service';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $service->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/services');
    }



    public function approve($id , Request $request)
    {


        $service= Service::find($id);        
        $service->is_approved= 1;
        $service->save();

        if ($service->is_approved == 1) {
            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'approve';
            $model_log->model_type   = 'service';
            $model_log->model_id     = $service->id;
            $model_log->desc         = __('admin.approve_service');
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();
        }

        $service->user->notify(new \App\Notifications\Database\ServiceApproved($service));

        if ($service->is_approved) {
            $service->user->notify(new ServiceApproved($service));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.approve_success'));

        return  redirect::back();

    }

    public function refuse(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'desc'      =>'required|min:3',
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $service= Service::find($request->model_id);        
        //$project->is_active=$request->is_active;
        $service->is_approved= 0;
        $service->save();

        if ($service->is_approved == 0) {
            $model_log               = new ModelLog;
            $model_log->user_id      = Auth::user()->id;
            $model_log->action       = 'refuse';
            $model_log->model_type   = 'service';
            $model_log->model_id     = $service->id;
            $model_log->desc         = $request->desc;
            $model_log->url          = $request->server()['REQUEST_URI'];
            $model_log->ip           = $request->server()['REMOTE_ADDR'];
            $model_log->save();
        }

        $service->user->notify(new \App\Notifications\Database\ServiceRefused($service));

        if ($service->is_approved) {
            $service->user->notify(new ServiceRefused($service));
        }

        Session::flash('status', __('admin.info'));
        Session::flash('message', __('admin.refuse_success'));

        return  redirect::back();

    }
}
