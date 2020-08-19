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

use App\Stage;
use App\Log;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages = Stage::all();

        return view('admin.stages.index')->withStages($stages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.stages.create');

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
            'slug'              => 'required|unique:Stages|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/stages/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $stage = new Stage;
        $stage->title = $request->title;
        $stage->is_active = $request->is_active;
        $stage->slug = $request->slug;
        $stage->save();

        if ($stage) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'Stage';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $stages = Stage::all();
        Session::flash('Stage', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/stages');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function show(Stage $stage)
    {
        if (is_numeric($id)) {
            $stage = Stage::where('id',$id)->where('is_active',1)->first();
        }else {
            $stage = Stage::where('slug',$id)->where('is_active',1)->first();
        }

        return view('stages.show')->withStage($stage);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $stage = Stage::find($id);
        }else {
            $stage = Stage::where('slug',$id)->first();
        }

        return view('admin.stages.edit')->withStage($stage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:Stages',
            'desc'              => 'required',
            'is_active'              => 'required',

        ]);

        $stage = Stage::find($id);

        $stage->title = $request->title;

        $stage->is_active = $request->is_active;
        $stage->slug = $request->slug;
        $stage->save();

        if ($stage) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'stage';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('Stage', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/stages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stage  $stage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $stage = Stage::find($id);
        }else {
            $stage = Stage::where('slug',$id)->first();
        }

        if ($stage) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'stage';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $stage->delete();


        Session::flash('Stage', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/stages');
    }
}
