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

use App\Averagekind;
use App\Log;

class AveragekindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $averagekinds = Averagekind::all();

        return view('admin.averagekinds.index')->withAveragekinds($averagekinds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.averagekinds.create');

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
            'slug'              => 'required|unique:averagekinds|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/averagekinds/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $averagekind = new Averagekind;
        $averagekind->title = $request->title;
        $averagekind->is_active = $request->is_active;
        $averagekind->slug = $request->slug;
        $averagekind->save();

        if ($averagekind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'averagekind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $averagekinds = Averagekind::all();
        Session::flash('averagekind', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/averagekinds');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Averagekind  $averagekind
     * @return \Illuminate\Http\Response
     */
    public function show(Averagekind $averagekind)
    {
        if (is_numeric($id)) {
            $averagekind = Averagekind::where('id',$id)->where('is_active',1)->first();
        }else {
            $averagekind = Averagekind::where('slug',$id)->where('is_active',1)->first();
        }

        return view('averagekinds.show')->withAveragekind($averagekind);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Averagekind  $averagekind
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $averagekind = Averagekind::find($id);
        }else {
            $averagekind = Averagekind::where('slug',$id)->first();
        }

        return view('admin.averagekinds.edit')->withAveragekind($averagekind);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Averagekind  $averagekind
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:averagekinds',
            'slug'              => 'required',
            'is_active'              => 'required',

        ]);

        $averagekind = Averagekind::find($id);

        $averagekind->title = $request->title;

        $averagekind->is_active = $request->is_active;
        $averagekind->slug = $request->slug;
        $averagekind->save();

        if ($averagekind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'averagekind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('averagekind', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/averagekinds');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Averagekind  $averagekind
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $averagekind = Averagekind::find($id);
        }else {
            $averagekind = Averagekind::where('slug',$id)->first();
        }

        if ($averagekind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'averagekind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $averagekind->delete();


        Session::flash('averagekind', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/averagekinds');
    }
}
