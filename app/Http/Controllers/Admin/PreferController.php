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

use App\Prefer;
use App\Log;

class PreferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prefers = Prefer::all();

        return view('admin.prefers.index')->withPrefers($prefers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.prefers.create');

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
            'slug'              => 'required|unique:prefers|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/prefers/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $prefer = new Prefer;
        $prefer->title = $request->title;
        $prefer->is_active = $request->is_active;
        $prefer->slug = $request->slug;
        $prefer->save();

        if ($prefer) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'prefer';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $prefers = Prefer::all();
        Session::flash('prefer', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/prefers');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prefer  $prefer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $prefer = Prefer::where('id',$id)->where('is_active',1)->first();
        }else {
            $prefer = Prefer::where('slug',$id)->where('is_active',1)->first();
        }

        return view('prefers.show')->withprefer($prefer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prefer  $prefer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $prefer = Prefer::find($id);
        }else {
            $prefer = Prefer::where('slug',$id)->first();
        }

        return view('admin.prefers.edit')->withPrefer($prefer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prefer  $prefer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:prefers',
            'slug'              => 'required',
            'is_active'              => 'required',

        ]);

        $prefer = Prefer::find($id);

        $prefer->title = $request->title;
        $prefer->is_active = $request->is_active;
        $prefer->slug = $request->slug;
        $prefer->save();

        if ($prefer) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'prefer';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('prefer', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/prefers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prefer  $prefer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $prefer = Prefer::find($id);
        }else {
            $prefer = Prefer::where('slug',$id)->first();
        }

        if ($prefer) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'prefer';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $prefer->delete();


        Session::flash('prefer', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/prefers');
    }
}
