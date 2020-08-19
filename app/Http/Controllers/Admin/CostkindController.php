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

use App\Costkind;
use App\Log;

class CostkindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costkinds = Costkind::all();

        return view('admin.costkinds.index')->withCostkinds($costkinds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.costkinds.create');

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
            'slug'              => 'required|unique:costkinds|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/costkinds/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $costkind = new Costkind;
        $costkind->title = $request->title;
        $costkind->is_active = $request->is_active;
        $costkind->slug = $request->slug;
        $costkind->save();

        if ($costkind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'costkind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $costkinds = Costkind::all();
        Session::flash('costkind', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/costkinds');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Costkind  $costkind
     * @return \Illuminate\Http\Response
     */
    public function show(Costkind $costkind)
    {
        if (is_numeric($id)) {
            $costkind = Costkind::where('id',$id)->where('is_active',1)->first();
        }else {
            $costkind = Costkind::where('slug',$id)->where('is_active',1)->first();
        }

        return view('costkinds.show')->withCostkind($costkind);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Costkind  $costkind
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $costkind = Costkind::find($id);
        }else {
            $costkind = Costkind::where('slug',$id)->first();
        }

        return view('admin.costkinds.edit')->withcostkind($costkind);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Costkind  $costkind
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:costkinds',
            'slug'              => 'required',
            'is_active'              => 'required',

        ]);

        $costkind = Costkind::find($id);

        $costkind->title = $request->title;

        $costkind->is_active = $request->is_active;
        $costkind->slug = $request->slug;
        $costkind->save();

        if ($costkind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'costkind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('costkind', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/costkinds');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Costkind  $costkind
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $costkind = Costkind::find($id);
        }else {
            $costkind = Costkind::where('slug',$id)->first();
        }

        if ($costkind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'costkind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $costkind->delete();


        Session::flash('costkind', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/costkinds');
    }
}
