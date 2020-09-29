<?php

namespace App\Http\Controllers;

use App\Project;
use App\Offer;
use App\Team;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Log;
use Redirect;
use Session;
use Mail;

use App\Notifications\OfferCreated;
use App\Notifications\OfferConfirm;


class OfferController extends Controller
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


        // if ($request->duration > 24) {
        //     Session::flash('status', __('admin.danger'));
        //     Session::flash('message', 'الحد الاقصي للساعات ٢٤ ساعة');
        //     return redirect::back();
        // }


        $validator = Validator::make($request->all(), [
            'project_id'        => 'required|integer',
            'duration'          => 'required|integer|numeric:1,24',
            'price'             => 'required|integer',
            'offer'             => 'required',

        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput();
        }


        $offer= new Offer();
        $offer->user_id=Auth::id();
        if ($request->team_id) {
            $team = Team::findorfail($request->team_id);
            if ($team->user_id != Auth::user()->id) {
                return redirect::back();
            }
            $offer->team_id=$request->team_id;  
        }
        $offer->project_id=$request->project_id;
        $offer->price=$request->price;
        $offer->duration =$request->duration;
        $offer->offer =$request->offer;
        $offer->save();


        $project = Project::findorfail($request->project_id);



        if (Auth::user()->usersettings && Auth::user()->usersettings->offer_notifications)
        {
            $offer->user->notify(new OfferCreated($offer));
        }

        if ($project->user->usersettings && $project->user->usersettings->offer_notifications) {
            $project->user->notify(new OfferCreated($offer));
        }



        Session::flash('status', __('file.success'));
        Session::flash('message', __('file.create_success_offer'));
        return redirect::back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
