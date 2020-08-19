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

use App\Beneficiary;
use App\Log;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beneficiaries = Beneficiary::all();
        return view('admin.beneficiaries.index')->withBeneficiaries($beneficiaries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.beneficiaries.create');
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
            'title'             => 'required|array|unique:beneficiaries',
            'desc'             => 'required|array',
            'subtitle'             => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect('admin/beneficiaries/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $beneficiary = new Beneficiary;
        $beneficiary->title = $request->title;
        $beneficiary->desc = $request->desc;
        $beneficiary->subtitle = $request->slug;
        $beneficiary->save();


        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/beneficiaries';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $beneficiary->image =  $destinationPath.'/'.$fileName;
        }

        $beneficiary->save();


        if ($beneficiary) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'beneficiary';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/beneficiaries');
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
            $beneficiary = Beneficiary::find($id);
        }else {
            $beneficiary = Beneficiary::where('slug',$id)->first();
        }

        return view('admin.beneficiaries.edit')->withBeneficiary($beneficiary);
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
            'title'             => 'required|array|unique:beneficiaries',
            'desc'             => 'required|array',
            'subtitle'             => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect('admin/beneficiaries/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $beneficiary = Beneficiary::find($id);
        $beneficiary->title = $request->title;
        $beneficiary->desc = $request->desc;
        $beneficiary->subtitle = $request->slug;
                $beneficiary->save();


        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/beneficiaries';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $beneficiary->image =  $destinationPath.'/'.$fileName;
        }

        $beneficiary->save();


        if ($beneficiary) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'beneficiary';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/beneficiaries');
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
            $beneficiary = Beneficiary::find($id);
        }else {
            $beneficiary = Beneficiary::where('slug',$id)->first();
        }

        if ($beneficiary) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'beneficiary';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $beneficiary->delete();


        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/beneficiaries');
    }
}
