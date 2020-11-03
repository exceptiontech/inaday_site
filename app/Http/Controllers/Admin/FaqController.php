<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
use App\Faq;
use App\Department;

class FaqController extends Controller
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
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faqs.index')->withFaqs($faqs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('type','faqs')->get();
        return view('admin.faqs.create')->withDepartments($departments);
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
            'question'             => 'required|array|unique:faqs',
            'answer'             => 'required|array',
            'slug'             => 'required|unique:faqs|max:255|min:3',
            'department_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/faqs/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $faq = new Faq;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->slug = $request->slug;
        $faq->department_id = $request->department_id;
        $faq->is_active = $request->is_active;
        if ($request->user_id) {
            $faq->user_id = $request->user_id;
        }else {
            $faq->user_id = Auth::user()->id;
        }

        $faq->order = $request->order;
        $faq->save();


        if ($faq) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'faq';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/faqs');
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
            $faq = Faq::find($id);
        }else {
            $faq = Faq::where('slug',$id)->first();
        }

        $departments = Department::where('type','faqs')->get();

        return view('admin.faqs.edit')->withFaq($faq)->withDepartments($departments);
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
            'question'             => 'required|array|unique:faqs',
            'answer'             => 'required|array',
            //'slug'              => 'required|unique:articles',
            'department_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/faqs/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $faq = Faq::find($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->slug = $request->slug;
        $faq->department_id = $request->department_id;
        $faq->is_active = $request->is_active;
        if ($request->user_id) {
            $faq->user_id = $request->user_id;
        }else {
            $faq->user_id = Auth::user()->id;
        }
        $faq->order = $request->order;
        $faq->save();



        if ($faq) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'faq';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/faqs');
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
            $faq = Faq::find($id);
        }else {
            $faq = Faq::where('slug',$id)->first();
        }

        if ($faq) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'faq';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $faq->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/faqs');
    }
}
