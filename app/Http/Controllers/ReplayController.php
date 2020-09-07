<?php

namespace App\Http\Controllers;

use App\Replay;
use App\Booking;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Log;
use Redirect;
use Session;

use App\Notifications\ReplayCreated;

class ReplayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'booking_id'        => 'required|integer',
            'replay'             => 'required',

        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput();
        }


        $replay= new Replay();
        $replay->user_id=Auth::id();
        $replay->booking_id=$request->booking_id;
        $replay->replay=$request->replay;
        $replay->save();



        if (Auth::user()->usersettings && Auth::user()->usersettings->replay_notifications)
        {
            $replay->booking->user->notify(new ReplayCreated($replay));
        } 

        Session::flash('status', __('file.success'));
        Session::flash('message', __('file.create_success_replay'));
        return redirect::back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function show(Replay $replay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function edit(Replay $replay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Replay $replay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function destroy(Replay $replay)
    {
        //
    }
}
