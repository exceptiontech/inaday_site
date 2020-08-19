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

use App\Level;
use App\Log;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = Level::all();

        return view('admin.levels.index')->withLevels($levels);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.levels.create');

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
            'slug'              => 'required|unique:levels|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/levels/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $level = new Level;
        $level->title = $request->title;
        $level->is_active = $request->is_active;
        $level->slug = $request->slug;
        $level->save();

        if ($level) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'level';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $levels = Level::all();
        Session::flash('level', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/levels');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        if (is_numeric($id)) {
            $level = Level::where('id',$id)->where('is_active',1)->first();
        }else {
            $level = Level::where('slug',$id)->where('is_active',1)->first();
        }

        return view('levels.show')->withLevel($level);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $level = Level::find($id);
        }else {
            $level = Level::where('slug',$id)->first();
        }

        return view('admin.levels.edit')->withLevel($level);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:levels',
            'desc'              => 'required',
            'is_active'              => 'required',

        ]);

        $level = Level::find($id);

        $level->title = $request->title;

        $level->is_active = $request->is_active;
        $level->slug = $request->slug;
        $level->save();

        if ($level) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'level';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('level', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/levels');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $level = Level::find($id);
        }else {
            $level = Level::where('slug',$id)->first();
        }

        if ($level) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'level';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $level->delete();


        Session::flash('level', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/levels');
    }
}
