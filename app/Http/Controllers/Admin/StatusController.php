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

use App\Status;
use App\Log;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();

        return view('admin.statuses.index')->withStatuses($statuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.statuses.create');

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
            'slug'              => 'required|unique:statuses|max:255|min:3',
            'desc'              => 'required|array',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/statuses/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $status = new Status;
        $status->title = $request->title;
        $status->desc = $request->desc;
        $status->slug = $request->slug;
        $status->save();

        if ($status) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'status';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $statuses = Status::all();
        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/statuses');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        if (is_numeric($id)) {
            $status = status::where('id',$id)->where('is_active',1)->first();
        }else {
            $status = status::where('slug',$id)->where('is_active',1)->first();
        }

        return view('statuses.show')->withstatus($status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $status = Status::find($id);
        }else {
            $status = Status::where('slug',$id)->first();
        }

        return view('admin.statuses.edit')->withStatus($status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:statuses',
            'desc'              => 'required',
            'is_active'              => 'required',

        ]);

        $status = status::find($id);

        $status->title = $request->title;

        $status->desc = $request->desc;
        $status->slug = $request->slug;
        $status->save();

        if ($status) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'status';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/statuses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $status = Status::find($id);
        }else {
            $status = Status::where('slug',$id)->first();
        }

        if ($status) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'status';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $status->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/statuses');
    }
}
