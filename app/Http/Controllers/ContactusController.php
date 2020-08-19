<?php

namespace App\Http\Controllers;
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

use App\Contactus;
use App\Log;

class ContactusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.contact.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'      =>'required|max:200',
            'email'     => 'required|email',
            'subject'   => 'required',
            'mobile'   => 'required',
            'message'   => 'required|min:50'
        ]);

        if (isset($request->validator) && $request->validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput();
        }


        $contact =ContactUs::where(['name'=>$request->name ,'email'=>$request->email , 'message' =>$request->message])->first();

        if(!$contact){

            $data= new Contactus();
            $data->name=$request->name;
            $data->email=$request->email;
            $data->mobile=$request->mobile;
            $data->subject=$request->subject;
            $data->message=$request->message;
            $data->save();

            if ($data) {
                $log           = new Log;
                $log->user_id  = Auth::user()->id;
                $log->action   = 'create';
                $log->model    = 'country';
                $log->url      = $request->server()['REQUEST_URI'];
                $log->ip       = $request->server()['REMOTE_ADDR'];
                $log->save();
            }

            Session::flash('status', __('file.success'));
            Session::flash('message', __('file.sent_succesfully'));
            return redirect::back();

        }

        Session::flash('status', __('file.danger'));
        Session::flash('message', __('file.sent_before'));
        return redirect::back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function show(Contactus $contactus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function edit(Contactus $contactus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contactus $contactus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contactus  $contactus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contactus $contactus)
    {
        //
    }
}
