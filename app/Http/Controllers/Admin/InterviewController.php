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

use App\Interview;
use App\Log;

class interviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $interviews = Interview::all();

        return view('admin.interviews.index')->withInterviews($interviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'إضافة صفحة';
        return view('admin.interviews.create')->withTitle($title);
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
            'slug'              => 'required|unique:interviews|max:255|min:3',
            'image'              => 'mimes:jpeg,png,jpg,pdf',
            'desc'              => 'required|array',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/interviews/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $interview = new interview;
        $interview->title = $request->title;

        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/interviews';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $interview->image =  $destinationPath.'/'.$fileName;
        }

        $interview->desc = $request->desc;
        $interview->slug = $request->slug;
        $interview->is_active = $request->is_active;
        $interview->save();

        if ($interview) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'interview';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $interviews = Interview::all();
        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/interviews');

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
            $interview = Interview::where('id',$id)->where('is_active',1)->first();
        }else {
            $interview = Interview::where('slug',$id)->where('is_active',1)->first();
        }

        return view('admin.interviews.show')->withInterview($interview);
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
            $interview = Interview::find($id);
        }else {
            $interview = Interview::where('slug',$id)->first();
        }

        return view('admin.interviews.edit')->withInterview($interview);
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
            'title'             => 'required|unique:interviews',
            'desc'              => 'required',
            'is_active'              => 'required',

        ]);

        if ($validator->fails()) {
            return redirect('admin/interviews/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $interview = Interview::find($id);

        $interview->title = $request->title;


        if (isset($file)) {
            $destinationPath = 'uploads/interviews';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $interview->image =  $destinationPath.'/'.$fileName;
        }

        $interview->desc = $request->desc;
        $interview->slug = $request->slug;
        $interview->is_active = $request->is_active;
        $interview->save();

        if ($interview) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'interview';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/interviews');
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
            $interview = Interview::find($id);
        }else {
            $interview = Interview::where('slug',$id)->first();
        }

        if ($interview) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'interview';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $interview->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/interviews');
    }
}
