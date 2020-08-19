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

use App\Sponsor;
use App\Department;
use App\Log;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsors = Sponsor::all();
        return view('admin.sponsors.index')->withSponsors($sponsors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('type','blog')->get();
        return view('admin.sponsors.create')->withDepartments($departments);
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
            'title'             => 'required|array|unique:sponsors',
            'desc'             => 'required|array',
            'slug'             => 'required|unique:sponsors|max:255|min:3',
            'department_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/sponsors/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $sponsor = new Sponsor;
        $sponsor->title = $request->title;
        $sponsor->desc = $request->desc;
        $sponsor->slug = $request->slug;
        $sponsor->department_id = $request->department_id;
        $sponsor->is_active = $request->is_active;
        if ($request->user_id) {
            $sponsor->user_id = $request->user_id;
        }else {
            $sponsor->user_id = Auth::user()->id;
        }
        
        $sponsor->order = $request->order;
        $sponsor->save();


        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/sponsors';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension; 
            $upload_success = $file->move($destinationPath, $fileName);
            $sponsor->image =  $destinationPath.'/'.$fileName;
        }

        $sponsor->save();


        if ($sponsor) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'sponsor';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/sponsors');
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
            $sponsor = Sponsor::find($id);
        }else {
            $sponsor = Sponsor::where('slug',$id)->first();
        }

        $departments = Department::where('type','blog')->get();

        return view('admin.sponsors.edit')->withSponsor($sponsor)->withDepartments($departments);
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
            'title'             => 'required|array|unique:sponsors',
            'desc'             => 'required|array',
            'slug'              => 'required|unique:sponsors',
            'department_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/sponsors/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $sponsor = Sponsor::find($id);
        $sponsor->title = $request->title;
        $sponsor->desc = $request->desc;
        $sponsor->slug = $request->slug;
        $sponsor->department_id = $request->department_id;
        $sponsor->is_active = $request->is_active;
        if ($request->user_id) {
            $sponsor->user_id = $request->user_id;
        }else {
            $sponsor->user_id = Auth::user()->id;
        }
        
        $sponsor->order = $request->order;
        $sponsor->save();


        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/sponsors';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension; 
            $upload_success = $file->move($destinationPath, $fileName);
            $page->image =  $destinationPath.'/'.$fileName;
        }

        $sponsor->save();


        if ($sponsor) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'sponsor';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/sponsors');
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
            $sponsor = Sponsor::find($id);
        }else {
            $sponsor = Sponsor::where('slug',$id)->first();
        }

        if ($sponsor) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'sponsor';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $sponsor->delete();
        

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/sponsors');
    }
}
