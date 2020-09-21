<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Replaykind;
use Illuminate\Http\Request;
use App\Log;
use Auth;


class BookingController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $booking = Booking::findorfail($id);

        $replaykinds = Replaykind::all();

        if (!$booking) {
            return view('front.errors.denied');
        }

        if ($booking->service_id ) {

            if (Auth::user()->isServicesProvider()) {

                if (Auth::user()->id == $booking->service->user_id) {
                    return view('front.bookings.service.show')->withBooking($booking)->withReplaykinds($replaykinds);
                }

            }elseif (Auth::user()->isEntrepreneur()) {

                if (Auth::user()->id == $booking->user_id) {
                    return view('front.bookings.service.show')->withBooking($booking)->withReplaykinds($replaykinds);
                }

            }else{
                return view('front.errors.denied');
            }

            return view('front.bookings.service.show')->withBooking($booking)->withReplaykinds($replaykinds);

        }elseif ($booking->project_id ) {

            if (Auth::user()->id == $booking->user_id || Auth::user()->id == $booking->project->user_id) {

                    if (Auth::user()->isServicesProvider()) {
                        return view('front.bookings.project.show')->withBooking($booking)->withReplaykinds($replaykinds);
                    }else {
                        return view('front.bookings.project.entrepreneur.show')->withBooking($booking)->withReplaykinds($replaykinds);
                    }

            }else {
                return view('front.errors.denied');
            }
            
            return view('front.bookings.project.show')->withBooking($booking)->withReplaykinds($replaykinds);

        } elseif ($booking->mixture_id ) {

            if (Auth::user()->id == $booking->user_id || Auth::user()->id == $booking->mixture->team->user_id) {
                    return view('front.bookings.mixture.show')->withBooking($booking)->withReplaykinds($replaykinds);
            }else {
                return view('front.errors.denied');
            }
            
            return view('front.bookings.mixture.show')->withBooking($booking)->withReplaykinds($replaykinds);

        } 

            return view('front.errors.denied');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
