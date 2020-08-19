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

use App\Jobtype;
use App\Log;

class JobtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobtypes = Jobtype::all();

        return view('admin.jobtypes.index')->withJobtypes($jobtypes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jobtypes.create');

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
            'slug'              => 'required|unique:jobtypes|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/jobtypes/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $jobtype = new Jobtype;
        $jobtype->title = $request->title;
        $jobtype->is_active = $request->is_active;
        $jobtype->slug = $request->slug;
        $jobtype->save();

        if ($jobtype) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'jobtype';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $jobtypes = Jobtype::all();
        Session::flash('jobtype', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/jobtypes');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jobtype  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $jobtype = Jobtype::find($id);
        }else {
            $jobtype = Jobtype::where('slug',$id)->where('is_active',1)->first();
        }

        return view('jobtypes.show')->withjobtype($jobtype);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jobtype  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $jobtype = Jobtype::find($id);
        }else {
            $jobtype = Jobtype::where('slug',$id)->first();
        }

        return view('admin.jobtypes.edit')->withjobtype($jobtype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jobtype  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:jobtypes',
            'is_active'              => 'required',

        ]);

        $jobtype = Jobtype::find($id);

        $jobtype->title = $request->title;
        $jobtype->is_active = $request->is_active;
        $jobtype->slug = $request->slug;
        $jobtype->save();

        if ($jobtype) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'jobtype';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('jobtype', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/jobtypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jobtype  $jobtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $jobtype = Jobtype::find($id);
        }else {
            $jobtype = Jobtype::where('slug',$id)->first();
        }

        if ($jobtype) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'jobtype';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $jobtype->delete();


        Session::flash('jobtype', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/jobtypes');
    }
}
