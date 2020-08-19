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

use App\Applykind;
use App\Log;

class ApplykindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applykinds = Applykind::all();

        return view('admin.applykinds.index')->withApplykinds($applykinds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.applykinds.create');
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
            'slug'              => 'required|unique:applykinds|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/applykinds/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $applykind = new Applykind;
        $applykind->title = $request->title;
        $applykind->is_active = $request->is_active;
        $applykind->slug = $request->slug;
        $applykind->save();

        if ($applykind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'applykind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('averagekind', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/applykinds');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            $applykind = Applykind::find($id);
        }else {
            $applykind = Applykind::where('slug',$id)->first();
        }

        return view('admin.applykinds.edit')->withApplykind($applykind);
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
            'title'             => 'required|unique:applykinds',
            'slug'              => 'required',
            'is_active'              => 'required',

        ]);

        $applykind = Applykind::find($id);

        $applykind->title = $request->title;

        $applykind->is_active = $request->is_active;
        $applykind->slug = $request->slug;
        $applykind->save();

        if ($applykind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'applykind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('averagekind', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/applykinds');
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
            $applykind = Applykind::find($id);
        }else {
            $applykind = Applykind::where('slug',$id)->first();
        }

        if ($applykind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'applykind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $applykind->delete();


        Session::flash('applykind', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/applykinds');
    }
}
