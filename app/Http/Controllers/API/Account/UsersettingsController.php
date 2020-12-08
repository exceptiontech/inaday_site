<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;

use App\Usersettings;
use Illuminate\Http\Request;

use App\Log;
use Auth;
use Redirect;
use Session;


class UsersettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }


        return view('front.profile.settings.index');
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


        function convert($string) {
            $arabic = [ 'on','off'];
            $num = range(1, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }

        $usersettings= Usersettings::where('user_id',Auth::id())->first();

        if ($usersettings) {
            $usersettings->blog_notifications= convert($request->blog_notifications);
            $usersettings->offer_notifications=convert($request->offer_notifications);
            $usersettings->booking_notifications=convert($request->booking_notifications);
            $usersettings->review_notifications=convert($request->review_notifications);
            $usersettings->team_notifications=convert($request->team_notifications);
            $usersettings->profile_notifications=convert($request->profile_notifications);
            $usersettings->favorite_notifications=convert($request->favorite_notifications);
            $usersettings->replay_notifications=convert($request->replay_notifications);
            $usersettings->message_notifications=convert($request->message_notifications);
            $usersettings->support_notifications=convert($request->support_notifications);
            $usersettings->user_id = Auth::id();
            $usersettings->save();
        }else {
            $usersettings = new Usersettings;
            $usersettings->blog_notifications= convert($request->blog_notifications);
            $usersettings->offer_notifications=convert($request->offer_notifications);
            $usersettings->booking_notifications=convert($request->booking_notifications);
            $usersettings->review_notifications=convert($request->review_notifications);
            $usersettings->team_notifications=convert($request->team_notifications);
            $usersettings->profile_notifications=convert($request->profile_notifications);
            $usersettings->favorite_notifications=convert($request->favorite_notifications);
            $usersettings->replay_notifications=convert($request->replay_notifications);
            $usersettings->message_notifications=convert($request->message_notifications);
            $usersettings->support_notifications=convert($request->support_notifications);
            $usersettings->user_id = Auth::id();
            $usersettings->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usersettings  $usersettings
     * @return \Illuminate\Http\Response
     */
    public function show(Usersettings $usersettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usersettings  $usersettings
     * @return \Illuminate\Http\Response
     */
    public function edit(Usersettings $usersettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usersettings  $usersettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        function convert($string) {
            $arabic = [ 'on','off'];
            $num = range(1, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }

        $usersettings= Usersettings::where('user_id',Auth::user()->id)->first();

        if ($usersettings) {

            $usersettings->blog_notifications= convert($request->blog_notifications);
            $usersettings->offer_notifications=convert($request->offer_notifications);
            $usersettings->booking_notifications=convert($request->booking_notifications);
            $usersettings->review_notifications=convert($request->review_notifications);
            $usersettings->team_notifications=convert($request->team_notifications);
            $usersettings->profile_notifications=convert($request->profile_notifications);
            $usersettings->favorite_notifications=convert($request->favorite_notifications);
            $usersettings->replay_notifications=convert($request->replay_notifications);
            $usersettings->message_notifications=convert($request->message_notifications);
            $usersettings->support_notifications=convert($request->support_notifications);
            $usersettings->user_id = Auth::id();
            $usersettings->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usersettings  $usersettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usersettings $usersettings)
    {
        //
    }
}
