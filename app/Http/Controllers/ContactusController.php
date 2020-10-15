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
use Mail;

use App\Contactus;
use App\Department;
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
        $departments = Department::where('type','support')->get();
        return view('front.contact.index')->withDepartments($departments);
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
            //'name'      =>'required|max:200',
            'department_id'     => 'required',
            'email'     => 'required|email',
            'subject'   => 'required',
            'mobile'   => 'required',
            'message'   => 'required|min:15'
        ]);

        if (isset($request->validator) && $request->validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput();
        }


        $contact =ContactUs::where(['name'=>$request->name ,'email'=>$request->email , 'message' =>$request->message])->first();

        if(!$contact){

            $contact= new Contactus();
            $file = $request->file;
            if ($file) {
                $destinationPath = 'uploads/contactus';
                $extension =  $file->getClientOriginalExtension();
                $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
                $upload_success = $file->move($destinationPath, $fileName);
                $contact->file = $destinationPath.'/'.$fileName;
            }
            $contact->name=$request->name;
            $contact->email=$request->email;
            $contact->mobile=$request->mobile;
            $contact->subject=$request->subject;
            $contact->message=$request->message;
            $contact->department_id=$request->department_id;
            $contact->save();


            Mail::send('mail.contactus', ['contactus'=>$contact], function($message) use ($contact)
                {
                    $message->to($contact->email, 'info@inaday.sa')->subject($contact->department->title[App::getLocale()]);
                }); 

            Mail::send('mail.contactus', ['contactus'=>$contact], function($message) use ($contact)
                {
                    $message->to($contact->email, 'support@inaday.sa')->subject($contact->department->title[App::getLocale()]);
                }); 

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
