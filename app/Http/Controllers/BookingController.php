<?php

namespace App\Http\Controllers;

use App\Booking;
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

        if (!$booking  ) {
            return view('front.errors.denied');
        }

        if ($booking->service_id ) {
            return view('front.bookings.service.show')->withBooking($booking);

            if (Auth::user()->id == $booking->user_id || Auth::user()->id == $booking->service->user_id) {
                return view('front.bookings.service.show')->withBooking($booking);
            }else{
                return view('front.errors.denied');
            }

        }elseif ($booking->project_id ) {
            return view('front.bookings.project.show')->withBooking($booking);

            if (Auth::user()->id == $booking->user_id || Auth::user()->id == $booking->project->user_id) {
                    return view('front.bookings.project.show')->withBooking($booking);
            }else {
                return view('front.errors.denied');
            }

        } 

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
