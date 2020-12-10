<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Input;
use Carbon\Carbon;
use DB;
use Auth;
use Config;
use App;
use Mail;
use Validator;

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

        $data['status'] = true;
        $data['data'] = $departments;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);
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
        $validator = Validator::make($request->all(), [
            //'name'      =>'required|max:200',
            'department_id'     => 'required',
            'email'     => 'required|email',
            'subject'   => 'required',
            'mobile'   => 'required',
            'message'   => 'required|min:15'
        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
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


            $data['status'] = true;
            $data['data'] = $contact;

            $arr = array("status" => 200,"data" => $data);
            return \Response::json(['data'=> $arr]);


        }


        $arr = array("status" => 401, "errorMsg" => __('file.sent_before'), "data" => array(),"appearForUser" => true);

        return \Response::json(['error'=> $arr]);

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
