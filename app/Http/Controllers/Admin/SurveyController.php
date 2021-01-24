<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Survey;
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
use Spatie\Permission\Models\Role;
use App\Log;


class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::all();

        return view('admin.surveys.index')->withSurveys($surveys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.surveys.create')->withRoles($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return $request;

        $validator = Validator::make($request->all(), [
            'title'             => 'required',
            'role_id'             => 'required|integer',
            'start_date'             => 'required',
            'end_date'             => 'required',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/surveys/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $survey = new Survey;
        $survey->title = $request->title;
        $survey->desc = $request->desc;
        $survey->start_date = $request->start_date;
        $survey->end_date = $request->end_date;
        $survey->role_id = $request->role_id;
        $survey->is_active = $request->is_active;
        $survey->save();

        if ($survey) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'survey';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/surveys');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey = Survey::find($id);
        $roles = Role::all();

        return view('admin.surveys.edit')->withSurvey($survey)->withRoles($roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title'             => 'required',
            'role_id'             => 'required|integer',
            'start_date'             => 'required',
            'end_date'             => 'required',
            'is_active'              => 'required',

        ]);

        if ($validator->fails()) {
            return redirect('admin/surveys/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $survey = Survey::find($id);
        $survey->title = $request->title;
        $survey->desc = $request->desc;
        $survey->start_date = $request->start_date;
        $survey->end_date = $request->end_date;
        $survey->role_id = $request->role_id;
        $survey->is_active = $request->is_active;
        $survey->save();

        if ($survey) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'survey';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/surveys');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id , Request $request)
    {
        $survey = Survey::find($id);

        if ($survey) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'survey';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $survey->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/surveys');
    }
}
