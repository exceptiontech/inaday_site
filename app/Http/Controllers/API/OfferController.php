<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

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
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return response()->json(['error' => 'UnAuthorised'], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $offers = Offer::where('user_id',Auth::user()->id)->paginate(10);

        return response()->json(['data' => $offers], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return response()->json(['error' => 'UnAuthorised'], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }


        $validator = Validator::make($request->all(), [
            'project_id'        => 'required|integer',
            'duration'          => 'required|numeric|min:1|max:24',
            'price'             => 'required|integer',
            'offer'             => 'required',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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


        $offer->user->notify(new \App\Notifications\Database\OfferCreated($offer));

        if (Auth::user()->usersettings && Auth::user()->usersettings->offer_notifications)
        {
            $offer->user->notify(new OfferCreated($offer));
        }

        $project->user->notify(new \App\Notifications\Database\OfferCreated($offer));

        if ($project->user->usersettings && $project->user->usersettings->offer_notifications) {
            $project->user->notify(new OfferCreated($offer));
        }



        Session::flash('status', __('file.success'));
        Session::flash('message', __('file.create_success_offer'));

        return response()->json(['data' => $offer], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

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
