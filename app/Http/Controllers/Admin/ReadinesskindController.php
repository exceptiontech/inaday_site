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

use App\Readinesskind;
use App\Log;

class ReadinesskindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $readinesskinds = Readinesskind::all();

        return view('admin.readinesskinds.index')->withReadinesskinds($readinesskinds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.readinesskinds.create');

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
            'slug'              => 'required|unique:readinesskinds|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/Readinesskinds/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $readinesskind = new Readinesskind;
        $readinesskind->title = $request->title;
        $readinesskind->is_active = $request->is_active;
        $readinesskind->slug = $request->slug;
        $readinesskind->save();

        if ($readinesskind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'Readinesskind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $readinesskinds = Readinesskind::all();
        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/readinesskinds');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Readinesskind  $readinesskind
     * @return \Illuminate\Http\Response
     */
    public function show(Readinesskind $readinesskind)
    {
        if (is_numeric($id)) {
            $readinesskind = Readinesskind::where('id',$id)->where('is_active',1)->first();
        }else {
            $readinesskind = Readinesskind::where('slug',$id)->where('is_active',1)->first();
        }

        return view('readinesskinds.show')->withReadinesskind($readinesskind);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Readinesskind  $readinesskind
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $readinesskind = Readinesskind::find($id);
        }else {
            $readinesskind = Readinesskind::where('slug',$id)->first();
        }

        return view('admin.readinesskinds.edit')->withReadinesskind($readinesskind);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Readinesskind  $readinesskind
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:readinesskinds',
            'slug'              => 'required',
            'is_active'              => 'required',

        ]);

        $readinesskind = Readinesskind::find($id);

        $readinesskind->title = $request->title;

        $readinesskind->is_active = $request->is_active;
        $readinesskind->slug = $request->slug;
        $readinesskind->save();

        if ($readinesskind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'Readinesskind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/readinesskinds');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Readinesskind  $readinesskind
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $readinesskind = Readinesskind::find($id);
        }else {
            $readinesskind = Readinesskind::where('slug',$id)->first();
        }

        if ($readinesskind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'Readinesskind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $readinesskind->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/readinesskinds');
    }
}