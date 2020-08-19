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

use App\Skill;
use App\Log;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $skills = Skill::all();

        return view('admin.skills.index')->withSkills($skills);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'إضافة صفحة';
        return view('admin.skills.create')->withTitle($title);
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
            'title'             => 'required|array',
            'slug'              => 'required|unique:skills|max:255|min:3',
            'image'              => 'mimes:jpeg,png,jpg,pdf',
            'desc'              => 'required|array',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/skills/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $skill = new Skill;
        $skill->title = $request->title;

        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/skills';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $skill->image =  $destinationPath.'/'.$fileName;
        }

        $skill->desc = $request->desc;
        $skill->slug = $request->slug;
        $skill->is_active = $request->is_active;
        $skill->save();

        if ($skill) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'skill';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $skills = Skill::all();
        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/skills');

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
            $skill = Skill::where('id',$id)->where('is_active',1)->first();
        }else {
            $skill = Skill::where('slug',$id)->where('is_active',1)->first();
        }

        return view('skills.show')->withSkill($skill);
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
            $skill = Skill::find($id);
        }else {
            $skill = Skill::where('slug',$id)->first();
        }

        return view('admin.skills.edit')->withSkill($skill);
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
            'title'             => 'required|unique:skills',
            'desc'              => 'required',
            'is_active'              => 'required',

        ]);

        if ($validator->fails()) {
            return redirect('admin/skills/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $skill = Skill::find($id);

        $skill->title = $request->title;


        if (isset($file)) {
            $destinationPath = 'uploads/skills';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $skill->image =  $destinationPath.'/'.$fileName;
        }

        $skill->desc = $request->desc;
        $skill->slug = $request->slug;
        $skill->is_active = $request->is_active;
        $skill->save();

        if ($skill) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'skill';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/skills');
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
            $skill = Skill::find($id);
        }else {
            $skill = Skill::where('slug',$id)->first();
        }

        if ($skill) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'skill';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $skill->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/skills');
    }
}
