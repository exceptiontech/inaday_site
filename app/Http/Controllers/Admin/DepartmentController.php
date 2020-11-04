<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Department;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Validator;
use Session;
use Redirect;
use Input;
use Carbon\Carbon;
use DB;
use Auth;
use Config;
use App;


use App\Log;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:department-list|department-create|department-edit|department-delete', ['only' => ['index','show']]);
         $this->middleware('permission:department-create', ['only' => ['create','store']]);
         $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->type;

        if($type) {
            $departments = Department::where('type',$type)->get();
        }else {
            $departments = Department::all();
        }

        return view('admin.departments.index')->withDepartments($departments);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->type;

        if($type) {
            $departments = Department::where('type',$type)->get();
        }else {
            $departments = Department::all();
        }

        return view('admin.departments.create')->withDepartments($departments);
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
            'title'             => 'required|unique:departments',
            //'parent_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/departments/create')
                        ->withErrors($validator)
                        ->withInput();
        }


        $data = $request->all();

        $department = Department::create($data);

        $image = $request->image;

        if (isset($image)) {
            $destinationPath = 'uploads/departments';
            $extension =  $image->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension;
            $upload_success = $image->move($destinationPath, $fileName);
            $department->image =  $destinationPath.'/'.$fileName;
        }

        $department->save();

        if ($department) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'department-'.$department->id;;
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/departments');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $type = $request->type;

        if($type) {
            $departments = Department::where('type',$type)->get();
        }else {
            $departments = Department::all();
        }
        $department = Department::find($id);

        return view('admin.departments.edit')->withDepartment($department)->withDepartments($departments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        $department->title = $request->title;
        $department->desc = $request->desc;
        $department->parent_id = $request->parent_id;
        $department->is_active = $request->is_active;
        $department->save();

        $image = $request->image;

        if (isset($image)) {
            $destinationPath = 'uploads/departments';
            $extension =  $image->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension;
            $upload_success = $image->move($destinationPath, $fileName);
            $department->image =  $destinationPath.'/'.$fileName;
        }

        $department->save();


        if ($department) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'department-'.$department->id;;
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));

        return redirect::to('admin/departments?type='.$department->type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {

        $department  = Department::findOrFail($id);
        $department->delete();

        if ($department) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'department-'.$department->id;
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', "danger");
        Session::flash('message', __('admin.delete_success'));
        return  redirect::to('admin/departments');

    }
}
