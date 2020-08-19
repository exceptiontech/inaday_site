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

use App\Rewardkind;
use App\Log;

class RewardkindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rewardkinds = Rewardkind::all();

        return view('admin.rewardkinds.index')->withRewardkinds($rewardkinds);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.rewardkinds.create');

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
            'slug'              => 'required|unique:rewardkinds|max:255|min:3',
            'is_active'              => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/rewardkinds/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $rewardkind = new Rewardkind;
        $rewardkind->title = $request->title;
        $rewardkind->is_active = $request->is_active;
        $rewardkind->slug = $request->slug;
        $rewardkind->save();

        if ($rewardkind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'rewardkind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $rewardkinds = Rewardkind::all();
        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/rewardkinds');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rewardkind  $rewardkind
     * @return \Illuminate\Http\Response
     */
    public function show(Rewardkind $rewardkind)
    {
        if (is_numeric($id)) {
            $rewardkind = Rewardkind::where('id',$id)->where('is_active',1)->first();
        }else {
            $rewardkind = Rewardkind::where('slug',$id)->where('is_active',1)->first();
        }

        return view('rewardkinds.show')->withRewardkind($rewardkind);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rewardkind  $rewardkind
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $rewardkind = Rewardkind::find($id);
        }else {
            $rewardkind = Rewardkind::where('slug',$id)->first();
        }

        return view('admin.rewardkinds.edit')->withRewardkind($rewardkind);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rewardkind  $rewardkind
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:rewardkinds',
            'slug'              => 'required',
            'is_active'              => 'required',

        ]);

        $rewardkind = Rewardkind::find($id);

        $rewardkind->title = $request->title;

        $rewardkind->is_active = $request->is_active;
        $rewardkind->slug = $request->slug;
        $rewardkind->save();

        if ($rewardkind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'rewardkind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/rewardkinds');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rewardkind  $rewardkind
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $rewardkind = Rewardkind::find($id);
        }else {
            $rewardkind = Rewardkind::where('slug',$id)->first();
        }

        if ($rewardkind) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'rewardkind';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $rewardkind->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/rewardkinds');
    }
}
